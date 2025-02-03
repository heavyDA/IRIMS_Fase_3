import { Modal } from "bootstrap"
import ApexCharts from "apexcharts"
import Swal from "sweetalert2"
import Choices from "choices.js"
import { formatNumeral } from "cleave-zen"
import { decodeHtml, defaultConfigChoices, defaultConfigFormatNumeral } from "js/components/helper"
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
    residual_scales: []
}

const fetchData = async () => {
    await Promise.allSettled([
        axios.get('/analytics/inherent-risk-scale'),
        axios.get('/analytics/residual-risk-scale'),
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
                                <th class="text-center" rowspan="2">No. Risiko</th>
                                <th class="text-center" rowspan="2">Organisasi</th>
                                <th class="text-center" rowspan="2">Peristiwa Risiko</th>
                                <th class="text-center" rowspan="2">Kategori Risiko T2 & T3</th>
                                <th class="text-center" colspan="2">Risiko Inheren</th>
                            </tr>
                            <tr>
                                <th class="text-center">Level Risiko</th>
                                <th class="text-center">Eksposur Risiko</th>
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
                datatableInherent = createDatatable(table, {
                    handleColumnSearchField: false,
                    responsive: true,
                    serverSide: true,
                    ordering: false,
                    processing: true,
                    ajax: `/risk-process/worksheet/get-by-inherent-risk-scale/${inherentScale}`,
                    scrollX: true,
                    fixedColumns: true,
                    lengthChange: false,
                    pageLength: -1,
                    paging: false,
                    scrollCollapse: true,
                    scrollY: '74vh',
                    columns: [
                        {
                            sortable: false,
                            data: 'worksheet_number',
                            name: 'worksheet_number',
                            width: '120px',
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
                            data: 'identification.risk_chronology_body',
                            name: 'identification.risk_chronology_body',
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
                            data: 'identification.risk_category_t2',
                            name: 'identification.risk_category_t2',
                            width: '100px',
                            render: function (data, type, row) {
                                if (type !== 'display') {
                                    return data
                                }

                                return `${row.identification.risk_category_t2.name} & ${row.identification.risk_category_t3.name}`
                            }
                        },
                        {
                            sortable: false,
                            data: 'identification.inherent_risk_level',
                            name: 'identification.inherent_risk_level',
                            width: '100px',
                        },
                        {
                            sortable: false,
                            data: 'identification.inherent_risk_exposure',
                            name: 'identification.inherent_risk_exposure',
                            width: '100px',
                            render: function (data, type, row) {
                                if (type !== 'display') {
                                    return data
                                }

                                return formatNumeral(data.replaceAll('.', ','), defaultConfigFormatNumeral)
                            }
                        }
                    ]
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
    riskMapResidualModal.show()
    riskMapResidualModalEl.addEventListener('shown.bs.modal', e => {
        // Clear the table's HTML content first
        const table = document.createElement('table')
        table.id = 'risk-map-residual-table'
        table.classList.add('table', 'table-bordered', 'table-striped', 'display', 'nowrap')
        table.style.width = '100%'

        table.innerHTML = `<thead class="table-dark">
                            <tr>
                                <th class="text-center" rowspan="2">No. Risiko</th>
                                <th class="text-center" rowspan="2">Organisasi</th>
                                <th class="text-center" rowspan="2">Peristiwa Risiko</th>
                                <th class="text-center" rowspan="2">Penyebab Risiko</th>
                                <th class="text-center" rowspan="2">Kategori Risiko T2 & T3</th>
                                <th class="text-center" colspan="2">Risiko Inheren</th>
                                <th class="text-center" colspan="2">Risiko Residual</th>
                            </tr>
                            <tr>
                                <th class="text-center">Level Risiko</th>
                                <th class="text-center">Eksposur Risiko</th>
                                <th class="text-center">Level Risiko</th>
                                <th class="text-center">Eksposur Risiko</th>
                            </tr>
                        </thead>`

        riskMapResidualTableWrapper.innerHTML = ''
        riskMapResidualTableWrapper.append(table)

        if (datatableResidual) {
            datatableResidual.clear()
            datatableResidual.destroy()
            datatableResidual = null
        }

        setTimeout(
            () => {
                datatableResidual = createDatatable(table, {
                    handleColumnSearchField: false,
                    responsive: true,
                    serverSide: true,
                    ordering: false,
                    processing: true,
                    ajax: `/risk-process/worksheet/get-by-actualization-risk-scale/${residualScale}`,
                    scrollX: true,
                    fixedColumns: true,
                    lengthChange: false,
                    pageLength: -1,
                    paging: false,
                    scrollCollapse: true,
                    scrollY: '74vh',
                    drawCallback: function (settings) {
                        const api = this.api()
                        const columnsToMerge = [0, 1, 2, 3, 5, 6]

                        // Reset all cells visibility first
                        api.cells().every(function () {
                            const node = this.node()
                            if (node) {
                                node.style.display = ''
                                node.setAttribute('rowspan', 1)
                            }
                        })

                        // Group rows by worksheet ID
                        const groups = {}
                        api.rows({ page: 'current' }).every(function (rowIdx) {
                            const data = this.data()
                            const worksheetNumber = data.monitoring.worksheet.worksheet_number
                            if (!groups[worksheetNumber]) {
                                groups[worksheetNumber] = []
                            }
                            groups[worksheetNumber].push(rowIdx)
                        })

                        // Process each column for each worksheet group separately
                        Object.values(groups).forEach(groupRows => {
                            columnsToMerge.forEach(colIdx => {
                                let lastValue = null
                                let rowsToMerge = 1
                                let firstRow = null

                                groupRows.forEach(rowIdx => {
                                    const value = api.cell(rowIdx, colIdx).data()
                                    const currentCell = api.cell(rowIdx, colIdx).node()

                                    let equalStatusButton = false

                                    if (lastValue === null) {
                                        lastValue = value
                                        firstRow = rowIdx
                                        return
                                    }

                                    // Strict comparison for values
                                    if (JSON.stringify(lastValue) === JSON.stringify(value) || equalStatusButton) {
                                        rowsToMerge++
                                        if (currentCell) {
                                            currentCell.style.display = 'none'
                                        }
                                    } else {
                                        if (rowsToMerge > 1) {
                                            const firstCell = api.cell(firstRow, colIdx).node()
                                            if (firstCell) {
                                                firstCell.setAttribute('rowspan', rowsToMerge)
                                            }
                                        }
                                        lastValue = value
                                        firstRow = rowIdx
                                        rowsToMerge = 1
                                    }
                                })

                                // Handle the last group
                                if (rowsToMerge > 1) {
                                    const firstCell = api.cell(firstRow, colIdx).node()
                                    if (firstCell) {
                                        firstCell.setAttribute('rowspan', rowsToMerge)
                                    }
                                }
                            })
                        })
                    },
                    columns: [
                        {
                            sortable: false,
                            data: 'monitoring.worksheet.worksheet_number',
                            name: 'monitoring.worksheet.worksheet_number',
                            width: '120px',
                        },
                        {
                            sortable: false,
                            data: 'monitoring.worksheet.sub_unit_name',
                            name: 'monitoring.worksheet.sub_unit_name',
                            width: '256px',
                            render: function (data, type, row) {
                                if (type !== 'display') {
                                    return data
                                }

                                return `[${row.monitoring.worksheet.personnel_area_code}] ${row.monitoring.worksheet.sub_unit_name}`
                            }
                        },
                        {
                            sortable: false,
                            data: 'monitoring.worksheet.identification.risk_chronology_body',
                            name: 'monitoring.worksheet.identification.risk_chronology_body',
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
                            data: 'incident.risk_cause_body',
                            name: 'incident.risk_cause_body',
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
                            data: 'monitoring.worksheet.identification.risk_category_t2',
                            name: 'monitoring.worksheet.identification.risk_category_t2',
                            width: '100px',
                            render: function (data, type, row) {
                                if (type !== 'display') {
                                    return data
                                }

                                return `${row.monitoring.worksheet.identification.risk_category_t2.name} & ${row.monitoring.worksheet.identification.risk_category_t3.name}`
                            }
                        },
                        {
                            sortable: false,
                            data: 'monitoring.worksheet.identification.inherent_risk_level',
                            name: 'monitoring.worksheet.identification.inherent_risk_level',
                            width: '100px',
                        },
                        {
                            sortable: false,
                            data: 'monitoring.worksheet.identification.inherent_risk_exposure',
                            name: 'monitoring.worksheet.identification.inherent_risk_exposure',
                            width: '100px',
                            render: function (data, type, row) {
                                if (type !== 'display') {
                                    return data
                                }

                                return formatNumeral(data.replaceAll('.', ','), defaultConfigFormatNumeral)
                            }
                        },
                        {
                            sortable: false,
                            data: 'risk_level',
                            name: 'risk_level',
                            width: '100px',
                        },
                        {
                            sortable: false,
                            data: 'risk_exposure',
                            name: 'risk_exposure',
                            width: '100px',
                            render: function (data, type, row) {
                                if (type !== 'display') {
                                    return data
                                }

                                return formatNumeral(data.replaceAll('.', ','), defaultConfigFormatNumeral)
                            }
                        }
                    ]
                })
            }, 275
        )
    })
    riskMapResidualModalEl.addEventListener('hidden.bs.modal', e => {
        riskMapResidualTableWrapper.innerHTML = ''
        if (datatableResidual) {
            datatableResidual.clear()
            datatableResidual = null
        }
    })
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

let actualRiskLevelData = []
riskLevels.forEach((level, index) => {
    fetchers.residual_scales.filter(x => x.risk_level == level).forEach(
        item => {
            if (typeof actualRiskLevelData[index] === 'undefined') {
                actualRiskLevelData[index] = item.total
                return
            }

            actualRiskLevelData[index] += item.total
        }
    )
})

const actualRiskLevelChart = new ApexCharts(
    document.querySelector('#actual-risk-level-chart'),
    {
        series: [
            { data: actualRiskLevelData }
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
actualRiskLevelChart.render()