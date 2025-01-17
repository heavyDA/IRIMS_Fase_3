import Choices from "choices.js";
import createDatatable from "js/components/datatable";
import { decodeHtml, defaultConfigFormatNumeral, defaultConfigChoices } from "js/components/helper";

const worksheetTableFilter = document.querySelector('#worksheet-table-filter')
const selectYear = worksheetTableFilter.querySelector('select[name="year"]')
const selectLength = worksheetTableFilter.querySelector('select[name="length"]')

new Choices(selectYear, defaultConfigChoices)
new Choices(selectLength, defaultConfigChoices)

selectLength.addEventListener('change', e => {
    datatable.page.len(e.target.value).draw()
})
selectYear.addEventListener('change', e => {
    datatable.draw()
})

const datatable = createDatatable('table', {
    handleColumnSearchField: false,
    responsive: false,
    serverSide: true,
    ordering: false,
    processing: true,
    ajax: {
        url: window.location.href,
        data: function (data) {
            data.year = selectYear.value

            return data
        }
    },
    fixedColumns: true,
    lengthChange: false,
    pageLength: 10,
    drawCallback: function (settings) {
        const api = this.api();
        const columnsToMerge = [0, 1, 2, 3, 4, 5, 6, 7];

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
            const worksheetNumber = data.identification.target.worksheet.worksheet_number;
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
                        equalStatusButton = value.includes(`worksheet_number="${currentCell.children[0]?.dataset.worksheet_number ?? 'x'}"`)
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
            title: 'No.',
            data: 'identification.target.worksheet.worksheet_number',
            name: 'identification.target.worksheet.worksheet_number',
            width: '64px'
        },
        {
            sortable: false,
            title: 'Status',
            data: 'status',
            name: 'status',
            width: '128px'
        },
        {
            sortable: false,
            title: 'Organisasi',
            data: 'identification.target.worksheet.sub_unit_name',
            name: 'identification.target.worksheet.sub_unit_name',
            width: '256px',
            render: function (data, type, row) {
                if (type !== 'display') {
                    return data
                }

                return `[${row.identification.target.worksheet.personnel_area_code}] ${row.identification.target.worksheet.sub_unit_name}`
            }
        },
        {
            sortable: false,
            title: 'Pilihan Sasaran',
            data: 'identification.target.body',
            name: 'identification.target.body',
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
            title: 'Peristiwa Risiko',
            data: 'risk_chronology_body',
            name: 'risk_chronology_body',
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
            title: 'Penyebab Risiko',
            data: 'risk_cause_body',
            name: 'risk_cause_body',
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
            title: 'Dampak',
            data: 'identification.risk_impact_body',
            name: 'identification.risk_impact_body',
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
            title: 'Level',
            data: 'inherent.risk_level',
            name: 'inherent.risk_level',
            width: '160px',
        },
        {
            sortable: false,
            title: 'Skala Risiko',
            data: 'inherent.risk_scale',
            name: 'inherent.risk_scale',
            width: '160px',
        },
    ],
})