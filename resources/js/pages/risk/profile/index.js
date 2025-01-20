import Choices from "choices.js"
import createDatatable from "js/components/datatable"
import { decodeHtml, defaultConfigFormatNumeral, defaultConfigChoices } from "js/components/helper"
import Swal from "sweetalert2"

const worksheetTable = document.querySelector('#worksheet-table')
const worksheetTableFilter = document.querySelector('#worksheet-table-filter')
const selectLength = worksheetTableFilter.querySelector('select[name="length"]')
const selectLengthChoices = new Choices(selectLength, defaultConfigChoices)
selectLength.addEventListener('change', e => {
    datatable.page.len(e.target.value).draw()
})

const datatable = createDatatable('#worksheet-table', {
    handleColumnSearchField: false,
    responsive: false,
    serverSide: true,
    ordering: false,
    processing: true,
    ajax: window.location.href,
    scrollX: true,
    fixedColumns: true,
    lengthChange: false,
    pageLength: -1,
    drawCallback: function (settings) {
        const api = this.api()
        const columnsToMerge = [0, 1, 2, 3, 6, 17]

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
    scrollX: true,
    columns: [
        {
            sortable: true,
            data: 'worksheet_number',
            name: 'worksheet_number',
            width: '64px'
        },
        {
            sortable: false,
            data: 'status',
            name: 'status',
            width: '128px'
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
            sortable: false,
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
            sortable: false,
            data: 'inherent_risk_level',
            name: 'inherent_risk_level',
            width: '100px',
        },
        {
            sortable: false,
            data: 'inherent_risk_scale',
            name: 'inherent_risk_scale',
            width: '100px',
        },
        {
            sortable: false,
            data: 'residual_1_risk_level',
            name: 'residual_1_risk_level',
            width: '100px',
        },
        {
            sortable: false,
            data: 'residual_2_risk_level',
            name: 'residual_2_risk_level',
            width: '100px',
        },
        {
            sortable: false,
            data: 'residual_3_risk_level',
            name: 'residual_3_risk_level',
            width: '100px',
        },
        {
            sortable: false,
            data: 'residual_4_risk_level',
            name: 'residual_4_risk_level',
            width: '100px',
        },
        {
            sortable: false,
            data: 'residual_1_risk_scale',
            name: 'residual_1_risk_scale',
            width: '100px',
        },
        {
            sortable: false,
            data: 'residual_2_risk_scale',
            name: 'residual_2_risk_scale',
            width: '100px',
        },
        {
            sortable: false,
            data: 'residual_3_risk_scale',
            name: 'residual_3_risk_scale',
            width: '100px',
        },
        {
            sortable: false,
            data: 'residual_4_risk_scale',
            name: 'residual_4_risk_scale',
            width: '100px',
        },
        {
            sortable: true,
            data: 'worksheet_id',
            name: 'worksheet_id',
            width: '96px',
            render: function (data, type, row) {
                if (type !== 'display') {
                    return data
                }

                if (row.top_risk) {
                    return `<button type="button" data-id="${row.top_risk}" class="worksheet-deletes btn btn-sm btn-danger"><i style="font-size: 12px;" class="ti ti-x"></i></button>`
                }

                return `<input ${row.top_risk == null ? '' : 'checked'} type="checkbox" name="worksheets[${row.worksheet_id}]" value="${data}" class="worksheet-selects">`
            }
        },
    ],
})


let worksheetChecks = []
let worksheetChecksCount = 0;
let worksheetDeletes = document.querySelector('.worksheet-deletes')
datatable.on('draw.dt', () => {
    worksheetChecksCount = 0
    worksheetChecks = document.querySelectorAll('.worksheet-selects')
    worksheetChecks.forEach(checkbox => {
        checkbox.addEventListener('change', e => {
            if (e.target.checked) {
                worksheetChecksCount += 1
            } else {
                worksheetChecksCount -= 1
            }

            worksheetSubmitButton.disabled = worksheetChecksCount == 0;
        })
    })

    worksheetDeletes = document.querySelectorAll('.worksheet-deletes')
    let worksheetDeletesLength = worksheetDeletes.length

    worksheetDeletes.forEach((button, index) => {
        if (index != 0 && worksheetDeletesLength > 1) {
            if (worksheetDeletes[index - 1].dataset.id == button.dataset.id) {
                button.remove()
                return
            }
        }

        button.addEventListener('click', async e => {
            const response = await axios.post(window.location.href + '/top-risk', {
                id: button.dataset.id,
                "_method": 'DELETE'
            })
            Swal.fire({
                icon: response.status == 200 ? 'success' : 'error',
                title: response.status == 200 ? 'Berhasil' : 'Gagal',
                text: response.data?.message,
            }).then(() => datatable.draw())
        })
    })
})

const worksheetSubmitButton = document.querySelector('#worksheet-submit-button')
worksheetSubmitButton.addEventListener('click', async e => {
    e.preventDefault()
    let worksheets = []
    worksheetChecks.forEach(checkbox => {
        if (checkbox.checked) {
            worksheets.push(checkbox.value)
        }
    })

    worksheets = new Set(worksheets)

    const response = await axios.post(window.location.href + '/top-risk', { worksheets: [...worksheets] })
    Swal.fire({
        icon: response.status == 200 ? 'success' : 'error',
        title: response.status == 200 ? 'Berhasil' : 'Gagal',
        text: response.data?.message,
    }).then(() => datatable.draw())
});
const inputCheckAll = document.querySelector('#worksheet-check-all')
inputCheckAll.addEventListener('change', e => {
    worksheetChecks.forEach(checkbox => {
        checkbox.checked = e.target.checked

        if (e.target.checked) {
            worksheetChecksCount += 1
        } else {
            worksheetChecksCount -= 1
        }
    })

    worksheetSubmitButton.disabled = worksheetChecksCount == 0;
})