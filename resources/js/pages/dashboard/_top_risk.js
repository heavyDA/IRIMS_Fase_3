const topRiskDatatable = createDatatable('#top-risk-table', {
    handleColumnSearchField: false,
    responsive: false,
    serverSide: true,
    ordering: false,
    processing: true,
    ajax: {
        url: '/risk-process/top-risk/get-for-dashboard',
        data: function (d) {
            d.year = selectYear.value
        }
    },
    scrollX: true,
    fixedColumns: true,
    lengthChange: false,
    pageLength: -1,
    drawCallback: function (settings) {
        const api = this.api()
        const columnsToMerge = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17]

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
            data: 'mitigation_plan',
            name: 'mitigation_plan',
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
            data: 'residual_risk_scale',
            name: 'residual_risk_scale',
            width: '100px',
        },
        {
            sortable: true,
            data: 'residual_risk_level',
            name: 'residual_risk_level',
            width: '100px',
        },
    ],
})