import { formatNumeral } from "cleave-zen";
import createDatatable from "js/components/datatable";
import { decodeHtml, defaultConfigFormatNumeral } from "js/components/helper";
const datatable = createDatatable('table', {
    handleColumnSearchField: false,
    responsive: false,
    serverSide: true,
    ajax: window.location.href,
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
            data: 'worksheet.unit_name',
            name: 'worksheet.unit_name',
            width: '256px'
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
            data: 'incident.risk_chronology_body',
            name: 'incident.risk_chronology_body',
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


datatable.on('draw', function () {
    const thead = document.querySelector('table thead')
    thead.classList.add('table-dark')
})