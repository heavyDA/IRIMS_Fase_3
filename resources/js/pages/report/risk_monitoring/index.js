import Choices from "choices.js";
import createDatatable from "js/components/datatable";
import { decodeHtml, defaultConfigFormatNumeral, defaultConfigChoices } from "js/components/helper";

const worksheetTableFilter = document.querySelector('#worksheet-table-filter')
const selectLength = worksheetTableFilter.querySelector('select[name="length"]')
const selectYear = worksheetTableFilter.querySelector('select[name="year"]')
const selectUnit = worksheetTableFilter.querySelector('select[name="unit"]')
const selectDocumentStatus = worksheetTableFilter.querySelector('select[name="document_status"]')

const selectLengthChoices = new Choices(selectLength, defaultConfigChoices)
const selectYearChoices = new Choices(selectYear, defaultConfigChoices)
const selectUnitChoices = new Choices(selectUnit, defaultConfigChoices)
const selectDocumentStatusChoices = new Choices(selectDocumentStatus, defaultConfigChoices)

const exportButton = worksheetTableFilter.querySelector('#worksheet-export')

if (selectUnitChoices._currentState.choices.length == 2) {
    selectUnitChoices.setChoiceByValue(selectUnitChoices._currentState.choices[1].value)
    selectUnitChoices.disable()
}

const query = {
    year: selectYear.value
}

selectLength.addEventListener('change', e => {
    datatable.page.len(e.target.value).draw();
})

selectUnit.addEventListener('change', e => {
    query.unit = e.target.value
    datatable.draw()
})
selectYear.addEventListener('change', e => {
    query.year = e.target.value
    datatable.draw()
})
selectDocumentStatus.addEventListener('change', e => {
    query.document_status = e.target.value
    datatable.draw()
})

exportButton.addEventListener('click', e => {
    e.preventDefault();
    const url = new URL(e.target.dataset.url)
    url.search = new URLSearchParams(query).toString()
    window.open(url, '_blank')
})

worksheetTableFilter.addEventListener('reset', e => {
    selectLengthChoices.destroy()
    selectLengthChoices.init()
    selectYearChoices.destroy()
    selectYearChoices.init()
    selectUnitChoices.destroy()
    selectUnitChoices.init()
    selectDocumentStatusChoices.destroy()
    selectDocumentStatusChoices.init()

    datatable.draw()
});

const datatable = createDatatable('table', {
    handleColumnSearchField: false,
    responsive: false,
    serverSide: true,
    ajax: {
        url: window.location.href,
        data: function (d) {
            d.year = selectYear.value
            d.unit = selectUnit.value
            d.document_status = selectDocumentStatus.value
        }
    },
    fixedColumns: true,
    lengthMenu: [10, 25, 50, 100],
    pageLength: 10,
    sorting: false,
    processing: true,
    drawCallback: function (settings) {
        const api = this.api();
        const columnsToMerge = [0, 1, 2, 3, 4, 5, 6,];

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
            const worksheetNumber = data.worksheet.worksheet_number;
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
    },
    scrollX: true,
    columns: [
        {
            sortable: true,
            data: 'worksheet.worksheet_number',
            name: 'worksheet.worksheet_number',
            width: '64px'
        },
        {
            sortable: false,
            data: 'status_monitoring',
            name: 'status_monitoring',
            width: '128px'
        },
        {
            sortable: false,
            data: 'worksheet.sub_unit_name',
            name: 'worksheet.sub_unit_name',
            width: '256px',
            render: function (data, type, row) {
                if (type !== 'display') {
                    return data
                }

                return `[${row.worksheet.personnel_area_code}] ${row.worksheet.sub_unit_name}`
            }
        },
        {
            sortable: false,
            data: 'worksheet.target_body',
            name: 'worksheet.target_body',
            width: '256px',
            render: function (data, type, row) {
                if (type !== 'display') {
                    return data
                }

                if (!data) {
                    return '';
                }

                const decodeData = decodeHtml(decodeHtml(data))
                const parsedData = new DOMParser().parseFromString(decodeData, 'text/html');

                return parsedData.body ? parsedData.body.innerHTML : '';
            }
        },
        {
            sortable: false,
            data: 'worksheet.identification.risk_chronology_body',
            name: 'worksheet.identification.risk_chronology_body',
            width: '256px',
            render: function (data, type, row) {
                if (type !== 'display') {
                    return data
                }

                if (!data) {
                    return '';
                }

                const decodeData = decodeHtml(decodeHtml(data))
                const parsedData = new DOMParser().parseFromString(decodeData, 'text/html');

                return parsedData.body ? parsedData.body.innerHTML : '';
            }
        },
        {
            sortable: false,
            data: 'mitigation_plan',
            name: 'mitigation_plan',
            width: '256px',
            render: function (data, type, row) {
                if (type !== 'display') {
                    return data
                }

                if (!data) {
                    return '';
                }

                const decodeData = decodeHtml(decodeHtml(data))
                const parsedData = new DOMParser().parseFromString(decodeData, 'text/html');

                return parsedData.body ? parsedData.body.innerHTML : '';
            }
        },
        {
            sortable: false,
            data: 'monitoring_actualization.actualization_mitigation_plan',
            name: 'monitoring_actualization.actualization_mitigation_plan',
            width: '256px',
            render: function (data, type, row) {
                if (type !== 'display') {
                    return data
                }

                if (!data) {
                    return '-';
                }

                const decodeData = decodeHtml(decodeHtml(data))
                const parsedData = new DOMParser().parseFromString(decodeData, 'text/html');

                return parsedData.body ? parsedData.body.innerHTML : '-';
            }
        },
        {
            sortable: false,
            data: 'worksheet.identification.inherent_risk_level',
            name: 'worksheet.identification.inherent_risk_level',
            width: '160px',
            render: function (data, type, row) {
                if (type !== 'display') return data;

                return data ? data : '-';
            }
        },
        {
            sortable: false,
            data: 'worksheet.identification.inherent_risk_scale',
            name: 'worksheet.identification.inherent_risk_scale',
            width: '160px',
            render: function (data, type, row) {
                if (type !== 'display') return data;

                return data ? data : '-';
            }
        },
        {
            sortable: false,
            data: 'monitoring_residual.quarter',
            name: 'monitoring_residual.quarter',
            width: '160px',
            render: function (data, type, row) {
                if (type !== 'display') return data;

                return data ? 'Q' + data : '-';
            }
        },
        {
            sortable: false,
            data: 'monitoring_residual.risk_level',
            name: 'monitoring_residual.risk_level',
            width: '160px',
            render: function (data, type, row) {
                if (type !== 'display') return data;

                return data ? data : '-';
            }
        },
        {
            sortable: false,
            data: 'monitoring_residual.risk_scale',
            name: 'monitoring_residual.risk_scale',
            width: '160px',
            render: function (data, type, row) {
                if (type !== 'display') return data;

                return data ? data : '-';
            }
        }
    ],
})