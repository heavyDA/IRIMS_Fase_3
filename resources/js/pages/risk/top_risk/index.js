import { Offcanvas } from "bootstrap"
import Choices from "choices.js"
import createDatatable from "js/components/datatable"
import { decodeHtml, defaultConfigFormatNumeral, defaultConfigChoices, renderHeatmapBadge } from "js/components/helper"
import Swal from "sweetalert2"
import debounce from "js/utils/debounce";


const inputSearch = document.querySelector('input[name="search"]')

const worksheetOffcanvas = document.querySelector('#worksheet-table-offcanvas')
const worksheetOffcanvasInstance = new Offcanvas(worksheetOffcanvas)
const worksheetFilterButton = document.querySelector('#worksheet-filter-button')
worksheetFilterButton.addEventListener('click', () => {
    worksheetOffcanvasInstance.show()
})

const worksheetTable = document.querySelector('#worksheet-table')
const worksheetTableFilter = worksheetOffcanvas.querySelector('#worksheet-table-filter')

const selectLength = worksheetTableFilter.querySelector('select[name="length"]')
const selectYear = worksheetTableFilter.querySelector('select[name="year"]')
const selectUnit = worksheetTableFilter.querySelector('select[name="unit"]')

const selectLengthChoices = new Choices(selectLength, defaultConfigChoices)
const selectYearChoices = new Choices(selectYear, defaultConfigChoices)
const selectUnitChoices = new Choices(selectUnit, defaultConfigChoices)

const columns = [
    {
        orderable: true,
        data: 'worksheet_number',
        name: 'worksheet_number',
        width: '64px'
    },
    {
        orderable: true,
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
        orderable: true,
        data: 'target_body',
        name: 'target_body',
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
        orderable: true,
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
        orderable: true,
        data: 'risk_cause_body',
        name: 'risk_cause_body',
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
        orderable: true,
        data: 'risk_impact_body',
        name: 'risk_impact_body',
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
        orderable: true,
        data: 'inherent_risk_level',
        name: 'inherent_risk_level',
        width: '100px',
        render: function (data, type, row) {
            if (type != 'display') {
                return data;
            }

            if (!data) {
                return '';
            }

            return renderHeatmapBadge(data, row.inherent_impact_probability_color)
        }
    },
    {
        orderable: true,
        data: 'inherent_risk_scale',
        name: 'inherent_risk_scale',
        width: '100px',
    },
    {
        orderable: true,
        data: 'residual_1_risk_level',
        name: 'residual_1_risk_level',
        width: '100px',
        render: function (data, type, row) {
            if (type != 'display') {
                return data;
            }

            if (!data) {
                return '';
            }

            return renderHeatmapBadge(data, row.residual_1_impact_probability_color)
        }
    },
    {
        orderable: true,
        data: 'residual_2_risk_level',
        name: 'residual_2_risk_level',
        width: '100px',
        render: function (data, type, row) {
            if (type != 'display') {
                return data;
            }

            if (!data) {
                return '';
            }

            return renderHeatmapBadge(data, row.residual_2_impact_probability_color)
        }
    },
    {
        orderable: true,
        data: 'residual_3_risk_level',
        name: 'residual_3_risk_level',
        width: '100px',
        render: function (data, type, row) {
            if (type != 'display') {
                return data;
            }

            if (!data) {
                return '';
            }

            return renderHeatmapBadge(data, row.residual_3_impact_probability_color)
        }
    },
    {
        orderable: true,
        data: 'residual_4_risk_level',
        name: 'residual_4_risk_level',
        width: '100px',
        render: function (data, type, row) {
            if (type != 'display') {
                return data;
            }

            if (!data) {
                return '';
            }

            return renderHeatmapBadge(data, row.residual_4_impact_probability_color)
        }
    },
    {
        orderable: true,
        data: 'residual_1_risk_scale',
        name: 'residual_1_risk_scale',
        width: '100px',
    },
    {
        orderable: true,
        data: 'residual_2_risk_scale',
        name: 'residual_2_risk_scale',
        width: '100px',
    },
    {
        orderable: true,
        data: 'residual_3_risk_scale',
        name: 'residual_3_risk_scale',
        width: '100px',
    },
    {
        orderable: true,
        data: 'residual_4_risk_scale',
        name: 'residual_4_risk_scale',
        width: '100px',
    },
    {
        orderable: true,
        data: 'top_risk_action',
        name: 'top_risk_action',
        width: '96px'
    },
    {
        orderable: true,
        data: 'created_at',
        name: 'created_at',
        defaultContent: '',
        visible: false,
    }
]
const datatable = createDatatable('#worksheet-table', {
    handleColumnSearchField: false,
    responsive: false,
    serverSide: true,
    ordering: false,
    processing: true,
    ajax: {
        url: window.location.href,
        data: function (d) {
            d.year = selectYear.value
            d.unit = selectUnit.value
        }
    },
    scrollX: true,
    fixedColumns: {
        start: 2
    },
    lengthChange: false,
    pageLength: 10,
    drawCallback: function (settings) {
        const api = this.api()
        const columnsToMerge = [0, 1, 2, 3, 6, 16]

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
            const worksheetNumber = data.worksheet_number
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

                    if (colIdx == 1) {
                        equalStatusButton = value.includes(`worksheet_number="${currentCell.children[0]?.dataset.worksheet_number ?? 'x'}"`)
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
    scrollY: '48vh',
    columns: columns,
    order: [[columns.length - 1, 'desc']],
})

worksheetTableFilter.addEventListener('submit', e => {
    e.preventDefault()
    datatable.page.len(selectLength.value).draw();

    setTimeout(() => {
        worksheetOffcanvasInstance.hide()
    }, 315);
})

inputSearch.addEventListener('input', debounce(
    e => {
        datatable.search(e.target.value).draw()
    },
    815
))

worksheetTableFilter.addEventListener('reset', e => {
    inputSearch.value = '';

    selectLengthChoices.destroy()
    selectLengthChoices.init()
    selectYearChoices.destroy()
    selectYearChoices.init()
    selectUnitChoices.destroy()
    selectUnitChoices.init()

    inputCheckAll.checked = false;
    inputCheckAll.dispatchEvent(new Event('change'))

    datatable.page.len(selectLength.value).search('').order([columns.length - 1, 'desc']).draw();
})

let worksheetChecks = []
let worksheetChecksCount = 0;
let worksheetChecksLength = 0
datatable.on('draw.dt', () => {
    let checkboxes = document.querySelectorAll('.worksheet-selects');

    worksheetChecksLength = checkboxes.length
    worksheetChecksCount = 0

    for (let [index, item] of [...checkboxes].entries()) {
        if (index == 0) {
            worksheetChecks.push(item)
            continue;
        }

        if (checkboxes[index - 1].value != item.value)
            worksheetChecks.push(item)

    }

    worksheetChecks.forEach(checkbox => {
        checkbox.addEventListener('change', e => {
            console.log(e.target)
            if (e.target.checked) {
                worksheetChecksCount += 1
            } else {
                worksheetChecksCount -= 1
            }

            inputCheckAll.checked = worksheetChecksLength == worksheetChecksCount
            worksheetSubmitButton.disabled = worksheetChecksCount == 0;
        })
    })
})

const worksheetSubmitButton = document.querySelector('#worksheet-submit-button')
worksheetSubmitButton?.addEventListener('click', async e => {
    e.preventDefault()

    Swal.fire({
        icon: 'info',
        title: 'Peringatan',
        text: 'Apakah Anda yakin ingin mengirim profil risiko pilihan sebagai top risk?',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak',
        showLoaderOnConfirm: true,
        allowOutsideClick: () => !Swal.isLoading(),
        preConfirm: async () => {
            let worksheets = []
            worksheetChecks.forEach(checkbox => {
                if (checkbox.checked) {
                    worksheets.push(checkbox.value)
                }
            })

            worksheets = new Set(worksheets)

            try {
                const response = await axios.post('/risk-process/top-risk', { worksheets: [...worksheets] })
                const data = await response.data;

                return data
            } catch (error) {

                return Swal.showValidationMessage(error?.response?.data?.message)
            }

        }
    }).then(async (result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: result.value.message,
            }).then(() => datatable.draw())
        }
    });
});

const inputCheckAll = document.querySelector('#worksheet-check-all')
inputCheckAll.addEventListener('change', e => {
    worksheetChecksCount = 0;

    worksheetChecks.forEach(checkbox => {
        checkbox.checked = e.target.checked

        worksheetChecksCount += e.target.checked
    })

    worksheetSubmitButton.disabled = worksheetChecksCount == 0;
})
