import { Modal } from "bootstrap"
import ApexCharts from "apexcharts"
import Swal from "sweetalert2"
import Choices from "choices.js"
import { formatNumeral } from "cleave-zen"
import { decodeHtml, defaultConfigChoices, defaultConfigFormatNumeral, renderHeatmapBadge } from "js/components/helper"
import createDatatable from "js/components/datatable"

const dashboardFilter = document.querySelector('#dashboard-filter')
const selectYear = dashboardFilter.querySelector('select[name="year"]')
const selectYearChoices = new Choices(selectYear, defaultConfigChoices)

const riskMapInherentModalEl = document.querySelector('#risk-map-inherent-modal')
const riskMapInherentModal = new Modal(riskMapInherentModalEl)
const riskMapInherentTableWrapper = riskMapInherentModalEl.querySelector('#risk-map-inherent-table-wrapper')

const riskMapResidualModalEl = document.querySelector('#risk-map-residual-modal')
const riskMapResidualModal = new Modal(riskMapResidualModalEl)
const riskMapResidualTableWrapper = riskMapResidualModalEl.querySelector('#risk-map-residual-table-wrapper')

selectYear.addEventListener('change', e => dashboardFilter.submit());


let fetchers = {
    inherent_scales: [],
    residual_scales: [],
}

const fetchData = async () => {
    await Promise.allSettled([
        axios.get(`/analytics/inherent-risk-scale?year=${selectYear.value}`),
        axios.get(`/analytics/target-residual-risk-scale?year=${selectYear.value}`),
    ]).then(res => {
        for (let [index, key] of Object.keys(fetchers).entries()) {
            if (res[index].status == 'fulfilled') {
                const response = res[index].value
                if (response.status == 200) {
                    fetchers[key] = response.data.data
                }
            }
        }
    })
}

await fetchData()

let datatableInherent, datatableResidual

let residualUrl = '/risk-process/worksheet/get-by-target-risk-scale'

fetchers?.inherent_scales?.forEach((inherent_scale) => {
    let riskText = document.querySelector(`#inherent-${inherent_scale.risk_scale}`)
    riskText.innerHTML = inherent_scale.total ? inherent_scale.total : ''


    riskText.parentNode.addEventListener('click', e => {
        if (inherent_scale.total == 0) {
            Swal.fire({
                icon: 'info',
                html: `Tidak terdapat data pada <strong class="text-capitalize">Skala ${inherent_scale.risk_level}</strong>`,
            })
            return
        }

        openModalInherent(inherent_scale.risk_scale)
    })


});

const setResidualRiskMap = () => {
    const map = document.querySelector('#risk-chart-residual')
    const blockClone = map.querySelector('svg').cloneNode(true)
    map.innerHTML = ''
    map.append(blockClone)

    fetchers?.residual_scales?.forEach((residual_scale) => {
        let riskText = document.querySelector(`#residual-${residual_scale.risk_scale}`)
        riskText.innerHTML = residual_scale.total ? residual_scale.total : ''

        riskText.parentNode.addEventListener('click', e => {
            if (residual_scale.total == 0) {
                Swal.fire({
                    icon: 'info',
                    html: `Tidak terdapat data pada <strong class="text-capitalize">Skala ${residual_scale.risk_level}</strong>`,
                })
                return
            }

            openModalResidual(residual_scale.risk_scale)
        })
    });
}

setResidualRiskMap()

const openModalInherent = (inherentScale) => {
    riskMapInherentModal.show()
    riskMapInherentModalEl.addEventListener('shown.bs.modal', e => {
        // Clear the table's HTML content first
        const table = document.createElement('table')
        table.id = 'risk-map-inherent-table'
        table.classList.add('table', 'table-bordered', 'table-striped', 'display', 'nowrap')
        table.style.width = '100%'

        table.innerHTML = `<thead class="table-dark">
                            <tr>
                                <th class="table-dark-custom" rowspan="2">No. Risiko</th>
                                <th class="table-dark-custom" rowspan="2">Organisasi</th>
                                <th class="table-dark-custom" rowspan="2">Peristiwa Risiko</th>
                                <th class="table-dark-custom" rowspan="2">Kategori Risiko T2 & T3</th>
                                <th class="table-dark-custom" style="text-align: center !important;" colspan="3">Inheren</th>
                                <th class="table-dark-custom" rowspan="2">Tanggal</th>
                            </tr>
                            <tr>
                                <th class="table-dark-custom" style="text-align: center !important;">Level Risiko</th>
                                <th class="table-dark-custom" style="text-align: center !important;">Skala Risiko</th>
                                <th class="table-dark-custom" style="text-align: center !important;">Eksposur Risiko</th>
                            </tr>
                        </thead>`

        riskMapInherentTableWrapper.innerHTML = ''
        riskMapInherentTableWrapper.append(table)

        if (datatableInherent) {
            datatableInherent.clear()
            datatableInherent.destroy()
            datatableInherent = null
        }

        setTimeout(
            () => {
                const columns = [
                    {
                        sortable: false,
                        data: 'worksheet_number',
                        name: 'worksheet_number',
                        width: '120px',
                        render: (data, type, row) => {
                            if (type !== 'display') {
                                return data
                            }

                            return `<a class="link-primary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-none" href="${row.worksheet_id}">${data}</a>`
                        }
                    },
                    {
                        sortable: false,
                        data: 'sub_unit_name',
                        name: 'sub_unit_name',
                        width: '256px',
                        render: function (data, type, row) {
                            if (type !== 'display') {
                                return data
                            }

                            return `[${row.personnel_area_code}] ${row.sub_unit_name}`
                        }
                    },
                    {
                        sortable: false,
                        data: 'risk_chronology_body',
                        name: 'risk_chronology_body',
                        width: '256px',
                        render: function (data, type, row) {
                            if (type !== 'display') {
                                return data
                            }

                            if (!data) {
                                return ''
                            }

                            const decodeData = decodeHtml(decodeHtml(data))
                            const parsedData = new DOMParser().parseFromString(decodeData, 'text/html')

                            return parsedData.body ? parsedData.body.innerHTML : ''
                        }
                    },
                    {
                        sortable: false,
                        data: 'risk_category_t2_name',
                        name: 'risk_category_t2_name',
                        width: '100px',
                        render: function (data, type, row) {
                            if (type !== 'display') {
                                return data
                            }

                            return `${data} & ${row.risk_category_t3_name}`
                        }
                    },
                    {
                        sortable: false,
                        data: 'inherent_impact_probability_level',
                        name: 'inherent_impact_probability_level',
                        width: '100px',
                        render: (data, type, row) => {
                            if (type !== 'display') {
                                return data
                            }

                            if (!data) {
                                return data
                            }

                            return renderHeatmapBadge(data, row.inherent_impact_probability_color)
                        }
                    },
                    {
                        sortable: false,
                        data: 'inherent_impact_probability_scale',
                        name: 'inherent_impact_probability_scale',
                        width: '100px',
                    },
                    {
                        sortable: false,
                        data: 'inherent_risk_exposure',
                        name: 'inherent_risk_exposure',
                        width: '100px',
                        render: function (data, type, row) {
                            if (type !== 'display') {
                                return data
                            }

                            if (!data) {
                                return ''
                            }

                            return formatNumeral(data.replaceAll('.', ','), defaultConfigFormatNumeral)
                        }
                    },
                    {
                        orderable: true,
                        data: 'created_at',
                        name: 'created_at',
                        visible: false
                    }
                ]
                datatableInherent = createDatatable(table, {
                    handleColumnSearchField: false,
                    responsive: false,
                    serverSide: true,
                    ordering: false,
                    processing: true,
                    ajax: {
                        url: `/risk-process/worksheet/get-by-inherent-risk-scale/${inherentScale}`,
                        data: function (d) {
                            d.year = selectYear.value
                        }
                    },
                    scrollX: true,
                    fixedColumns: {
                        start: 2
                    },
                    lengthChange: false,
                    pageLength: 10,
                    paging: true,
                    scrollCollapse: true,
                    scrollY: '74vh',
                    columns: columns,
                    order: [[columns.length - 1, 'desc']],
                    drawCallback: function (settings) {
                        const api = this.api();
                        const columnsToMerge = [0, 1, 2, 3, 4, 5, 6];

                        // Reset all cells visibility first
                        api.cells().every(function () {
                            const node = this.node();
                            if (node) {
                                node.style.display = '';
                                node.setAttribute('rowspan', 1);
                            }
                        });

                        // Group rows by worksheet ID
                        const groups = {};
                        api.rows({ page: 'current' }).every(function (rowIdx) {
                            const data = this.data();
                            const worksheetNumber = data.worksheet_number;
                            if (!groups[worksheetNumber]) {
                                groups[worksheetNumber] = [];
                            }
                            groups[worksheetNumber].push(rowIdx);
                        });

                        // Process each column for each worksheet group separately
                        Object.values(groups).forEach(groupRows => {
                            columnsToMerge.forEach(colIdx => {
                                let lastValue = null;
                                let rowsToMerge = 1;
                                let firstRow = null;

                                groupRows.forEach(rowIdx => {
                                    const value = api.cell(rowIdx, colIdx).data();
                                    const currentCell = api.cell(rowIdx, colIdx).node();

                                    let equalStatusButton = false;

                                    if (lastValue === null) {
                                        lastValue = value;
                                        firstRow = rowIdx;
                                        return;
                                    }

                                    if (colIdx == 1) {
                                        equalStatusButton = value.includes(`key="${currentCell.children[0]?.dataset.key ?? 'x'}"`)
                                    }

                                    // Strict comparison for values
                                    if (JSON.stringify(lastValue) === JSON.stringify(value) || equalStatusButton) {
                                        rowsToMerge++;
                                        if (currentCell) {
                                            currentCell.style.display = 'none';
                                        }
                                    } else {
                                        if (rowsToMerge > 1) {
                                            const firstCell = api.cell(firstRow, colIdx).node();
                                            if (firstCell) {
                                                firstCell.setAttribute('rowspan', rowsToMerge);
                                            }
                                        }
                                        lastValue = value;
                                        firstRow = rowIdx;
                                        rowsToMerge = 1;
                                    }
                                });

                                // Handle the last group
                                if (rowsToMerge > 1) {
                                    const firstCell = api.cell(firstRow, colIdx).node();
                                    if (firstCell) {
                                        firstCell.setAttribute('rowspan', rowsToMerge);
                                    }
                                }
                            });
                        });
                    }
                })
            }, 275
        )
    })
    riskMapInherentModalEl.addEventListener('hidden.bs.modal', e => {
        riskMapInherentTableWrapper.innerHTML = ''
        if (datatableInherent) {
            datatableInherent.clear()
            datatableInherent = null
        }
    })
}

const openModalResidual = (residualScale) => {
    function handleCleanup(e) {
        riskMapResidualTableWrapper.innerHTML = ''
        if (datatableResidual) {
            datatableResidual.clear()
            datatableResidual.destroy()
            datatableResidual = null
        }
    }

    function handleShow(e) {
        // Clear the table's HTML content first
        const table = document.createElement('table')
        table.id = 'risk-map-residual-table'
        table.classList.add('table', 'table-bordered', 'table-striped', 'display', 'nowrap')
        table.style.width = '100%'

        table.innerHTML = `<thead>
                                <tr>
                                    <th class="table-dark-custom" rowspan="2">No. Risiko</th>
                                    <th class="table-dark-custom" rowspan="2">Organisasi</th>
                                    <th class="table-dark-custom" rowspan="2">Peristiwa Risiko</th>
                                    <th class="table-dark-custom" rowspan="2">Kategori Risiko T2 & T3</th>
                                    <th class="table-dark-custom" style="text-align: center !important;" colspan="3">Inheren</th>
                                    <th class="table-dark-custom" style="text-align: center !important;" colspan="3">Residual</th>
                                    <th class="table-dark-custom" rowspan="2">Tanggal</th>
                                    </tr>
                                <tr>
                                    <th class="table-dark-custom" style="text-align: center !important;">Level Risiko</th>
                                    <th class="table-dark-custom" style="text-align: center !important;">Skala Risiko</th>
                                    <th class="table-dark-custom" style="text-align: center !important;">Eksposur Risiko</th>
                                    <th class="table-dark-custom" style="text-align: center !important;">Level Risiko</th>
                                    <th class="table-dark-custom" style="text-align: center !important;">Skala Risiko</th>
                                    <th class="table-dark-custom" style="text-align: center !important;">Eksposur Risiko</th>
                                </tr>
                            </thead>`

        riskMapResidualTableWrapper.innerHTML = ''
        riskMapResidualTableWrapper.append(table)
        if (datatableResidual) {
            datatableResidual.clear()
            datatableResidual.destroy()
            datatableResidual = null
        }

        const columns = [
            {
                sortable: false,
                data: 'worksheet_number',
                name: 'worksheet_number',
                width: '120px',
                render: (data, type, row) => {
                    if (type !== 'display') {
                        return data
                    }

                    return `<a class="link-primary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-none" href="${row.worksheet_id}">${data}</a>`
                }
            },
            {
                sortable: false,
                data: 'sub_unit_name',
                name: 'sub_unit_name',
                width: '256px',
                render: function (data, type, row) {
                    if (type !== 'display') {
                        return data
                    }

                    return `[${row.personnel_area_code}] ${data}`
                }
            },
            {
                sortable: false,
                data: 'risk_chronology_body',
                name: 'risk_chronology_body',
                width: '256px',
                render: function (data, type, row) {
                    if (type !== 'display') {
                        return data
                    }

                    if (!data) {
                        return ''
                    }

                    const decodeData = decodeHtml(decodeHtml(data))
                    const parsedData = new DOMParser().parseFromString(decodeData, 'text/html')

                    return parsedData.body ? parsedData.body.innerHTML : ''
                }
            },
            {
                sortable: false,
                data: 'risk_category_t2_name',
                name: 'risk_category_t2_name',
                defaultContent: '',
                width: '100px',
                render: function (data, type, row) {
                    if (type !== 'display') {
                        return data
                    }

                    return `${data} & ${row.risk_category_t3_name}`
                }
            },
            {
                sortable: false,
                data: 'inherent_impact_probability_level',
                name: 'inherent_impact_probability_level',
                width: '100px',
                render: function (data, type, row) {
                    if (type !== 'display') {
                        return data
                    }

                    if (!data) {
                        return data
                    }

                    return renderHeatmapBadge(data, row.inherent_impact_probability_color)
                }
            },
            {
                sortable: false,
                data: 'inherent_impact_probability_scale',
                name: 'inherent_impact_probability_scale',
                width: '100px',
            },
            {
                sortable: false,
                data: 'inherent_risk_exposure',
                name: 'inherent_risk_exposure',
                width: '100px',
                render: function (data, type, row) {
                    if (type !== 'display') {
                        return data
                    }

                    if (!data) {
                        return ''
                    }

                    return formatNumeral(data.replaceAll('.', ','), defaultConfigFormatNumeral)
                }
            },
            {
                sortable: false,
                data: 'residual_risk_level',
                name: 'residual_risk_level',
                width: '100px',
                render: function (data, type, row) {
                    if (type !== 'display') {
                        return data
                    }

                    if (!data) {
                        return data
                    }

                    return renderHeatmapBadge(data, row.residual_risk_color)
                }
            },
            {
                sortable: false,
                data: 'residual_risk_scale',
                name: 'residual_risk_scale',
                width: '100px',
            },
            {
                sortable: false,
                data: 'residual_risk_exposure',
                name: 'residual_risk_exposure',
                width: '100px',
                render: function (data, type, row) {
                    if (type !== 'display') {
                        return data
                    }

                    if (!data) {
                        return ''
                    }

                    return formatNumeral(data.replaceAll('.', ','), defaultConfigFormatNumeral)
                }
            },
            {
                orderable: true,
                name: 'created_at',
                data: 'created_at',
                visible: false
            }
        ];

        datatableResidual = createDatatable(table, {
            handleColumnSearchField: false,
            responsive: false,
            serverSide: true,
            ordering: false,
            processing: true,
            ajax: {
                url: `${residualUrl}/${residualScale}`,
                data: function (d) {
                    d.year = selectYear.value

                    if (!riskLevelQuarterSelect.classList.contains('d-none')) {
                        d.quarter = riskLevelQuarterSelect.value
                    }
                }
            },
            scrollX: true,
            fixedColumns: {
                start: 2
            },
            lengthChange: false,
            pageLength: 10,
            paging: true,
            scrollCollapse: true,
            scrollY: '74vh',
            columns: columns,
            order: [[columns.length - 1, 'desc']]
        })
    }

    riskMapResidualModal.show()
    riskMapResidualModalEl.addEventListener('hidden.bs.modal', handleCleanup)

    setTimeout(() => {
        handleShow()
    }, 525)
}

let riskLevels = fetchers.inherent_scales.reduce(
    (levels, item) => [...levels, item.risk_level], [])
riskLevels = [...new Set(riskLevels)]

let riskLevelColors = fetchers.inherent_scales.reduce(
    (colors, item) => [...colors, item.color], [])
riskLevelColors = [...new Set(riskLevelColors)]

let inherentRiskLevelData = []
riskLevels.forEach((level, index) => {
    fetchers.inherent_scales.filter(x => x.risk_level == level).forEach(
        item => {
            if (typeof inherentRiskLevelData[index] === 'undefined') {
                inherentRiskLevelData[index] = item.total
                return
            }

            inherentRiskLevelData[index] += item.total
        }
    )
})

const inherentRiskLevelChart = new ApexCharts(
    document.querySelector('#inherent-risk-level-chart'),
    {
        series: [
            { data: inherentRiskLevelData }
        ],
        chart: {
            type: 'bar',
            height: 350
        },
        xaxis: {
            categories: [...riskLevels]
        },
        yaxis: {
            title: {
                text: 'Jumlah Risiko'
            }
        },
        plotOptions: {
            bar: {
                distributed: true // Enable different colors per category
            }
        },
        colors: riskLevelColors
    }
)
inherentRiskLevelChart.render()

let riskLevelData = []
const mapRiskLevelData = () => {
    riskLevels.forEach((level, index) => {
        fetchers.residual_scales.filter(x => x.risk_level == level).forEach(
            item => {
                if (typeof riskLevelData[index] === 'undefined') {
                    riskLevelData[index] = item.total
                    return
                }

                riskLevelData[index] += item.total
            }
        )
    })
}

mapRiskLevelData()

const riskLevelChart = new ApexCharts(
    document.querySelector('#residual-risk-level-chart'),
    {
        series: [
            { data: riskLevelData }
        ],
        chart: {
            type: 'bar',
            height: 350
        },
        xaxis: {
            categories: [...riskLevels]
        },
        yaxis: {
            title: {
                text: 'Jumlah Risiko'
            }
        },
        plotOptions: {
            bar: {
                distributed: true // Enable different colors per category
            }
        },
        colors: riskLevelColors
    }
)
riskLevelChart.render()

const riskLevelSelect = document.querySelector('#residual-risk-level-select')
new Choices(riskLevelSelect, { ...defaultConfigChoices, ...{ searchEnabled: false } })
const riskLevelQuarterSelect = document.querySelector('#residual-risk-level-quarter')
const riskLevelQuarterChoices = new Choices(riskLevelQuarterSelect, { ...defaultConfigChoices, ...{ searchEnabled: false } })
const riskMapResidualTitle = document.querySelector('#risk-map-residual-title')
riskLevelSelect.addEventListener('change', async e => {
    if (['residual', 'target-residual'].includes(e.target.value)) {
        riskMapResidualTitle.innerHTML = 'Peta Risiko ' + e.target.value.replaceAll('-', ' ')
        let url = `/analytics/${e.target.value}-risk-scale?year=${selectYear.value}`
        if (e.target.value == 'target-residual') {
            riskLevelQuarterChoices.containerOuter.element.classList.replace('d-none', 'flex-grow-1')
            url += `&quarter=${riskLevelQuarterSelect.value}`
            residualUrl = residualUrl.replaceAll('actualization', 'target')
        } else {
            residualUrl = residualUrl.replaceAll('target', 'actualization')
            riskLevelQuarterChoices.containerOuter.element.classList.replace('flex-grow-1', 'd-none')
        }

        const response = await axios.get(url)

        if (response.status == 200) {
            fetchers.residual_scales = response.data.data
            setResidualRiskMap()
            riskLevelData = []
            mapRiskLevelData()
            riskLevelChart.updateSeries([
                { data: riskLevelData }
            ])
        }
    }
});

riskLevelQuarterSelect.addEventListener('change', e => riskLevelSelect.dispatchEvent(new Event('change')))