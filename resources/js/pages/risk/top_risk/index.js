import { Offcanvas } from "bootstrap"
import Choices from "choices.js"
import createDatatable from "js/components/datatable"
import { decodeHtml, defaultConfigFormatNumeral, defaultConfigChoices } from "js/components/helper"
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
    fixedColumns: true,
    lengthChange: false,
    pageLength: -1,
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
    columns: [
        {
            sortable: true,
            data: 'worksheet_number',
            name: 'worksheet_number',
            width: '64px'
        },
        {
            sortable: true,
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
            sortable: true,
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
            sortable: true,
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
            sortable: true,
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
            sortable: true,
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
            sortable: true,
            data: 'inherent_risk_level',
            name: 'inherent_risk_level',
            width: '100px',
        },
        {
            sortable: true,
            data: 'inherent_risk_scale',
            name: 'inherent_risk_scale',
            width: '100px',
        },
        {
            sortable: true,
            data: 'residual_1_risk_level',
            name: 'residual_1_risk_level',
            width: '100px',
        },
        {
            sortable: true,
            data: 'residual_2_risk_level',
            name: 'residual_2_risk_level',
            width: '100px',
        },
        {
            sortable: true,
            data: 'residual_3_risk_level',
            name: 'residual_3_risk_level',
            width: '100px',
        },
        {
            sortable: true,
            data: 'residual_4_risk_level',
            name: 'residual_4_risk_level',
            width: '100px',
        },
        {
            sortable: true,
            data: 'residual_1_risk_scale',
            name: 'residual_1_risk_scale',
            width: '100px',
        },
        {
            sortable: true,
            data: 'residual_2_risk_scale',
            name: 'residual_2_risk_scale',
            width: '100px',
        },
        {
            sortable: true,
            data: 'residual_3_risk_scale',
            name: 'residual_3_risk_scale',
            width: '100px',
        },
        {
            sortable: true,
            data: 'residual_4_risk_scale',
            name: 'residual_4_risk_scale',
            width: '100px',
        },
        {
            sortable: true,
            data: 'top_risk_action',
            name: 'top_risk_action',
            width: '96px',
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
    ],
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

    datatable.page.len(selectLength.value).search('').draw();
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
worksheetSubmitButton.addEventListener('click', async e => {
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
                    console.log(checkbox.value)
                    worksheets.push(checkbox.value)
                }
            })

            worksheets = new Set(worksheets)
            const response = await axios.post('/risk-process/top-risk', { worksheets: [...worksheets] })
            const data = await response.data;

            if (response.status != 200) {
                return Swal.showValidationMessage(data.message)
            }

            return data
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
