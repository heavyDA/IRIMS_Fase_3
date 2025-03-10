import createDatatable from "~js/components/datatable";
import { renderHeatmapBadge } from "~js/components/helper";

// Call the function when the page loads with columns to exclude
// Example: exclude columns 3 and 4 (risk_value and risk_value_limit)
document.addEventListener('DOMContentLoaded', () => {
    const contextTable = document.querySelector('#contextTable')
    if (contextTable) {
        const contextDatatable = createDatatable(contextTable, {
            handleColumnSearchField: false,
            responsive: false,
            serverSide: false,
            processing: false,
            paging: false,
            fixedColumns: {
                start: 2
            },
            scrollX: true,
            scrollCollapse: true,
            lengthChange: false,
            autoWidth: true,
            pageLength: -1,
            ordering: false,
            sorting: false,
            info: false,
            columnDefs: [
                { targets: [4, 5], width: 164 }
            ],
            drawCallback: function (settings) {
                const api = this.api();

                // Your existing row merging logic
                const columnsToMerge = [0, 4];

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
                    const worksheetNumber = data.target_body;
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
                            const currentCell = api.cell(rowIdx, colIdx).node();
                            if (!currentCell) return;

                            const value = currentCell.textContent.trim();

                            if (lastValue === null) {
                                lastValue = value;
                                firstRow = rowIdx;
                                return;
                            }

                            // Strict comparison for values
                            if (lastValue === value) {
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
        })
    }

    const treatmentTable = document.querySelector('#treatmentTable')
    if (treatmentTable) {
        const treatmentDatatable = createDatatable(treatmentTable, {
            handleColumnSearchField: false,
            responsive: false,
            serverSide: false,
            processing: false,
            paging: false,
            fixedColumns: {
                start: 2
            },
            scrollX: true,
            scrollCollapse: true,
            lengthChange: false,
            autoWidth: true,
            pageLength: -1,
            ordering: false,
            sorting: false,
            info: false,
            columnDefs: [
                { targets: [0], width: 96 },
                { targets: [1, 10], width: 128 },
                { targets: [2, 3, 4, 5, 6, 7, 8, 9, 11], width: 164 }
            ],
            drawCallback: function (settings) {
                const api = this.api();

                // Your existing row merging logic
                const columnsToMerge = [0, 1, 2];

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
                    const worksheetNumber = data.target_body;
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
                            const currentCell = api.cell(rowIdx, colIdx).node();
                            if (!currentCell) return;

                            const value = currentCell.textContent.trim();

                            if (lastValue === null) {
                                lastValue = value;
                                firstRow = rowIdx;
                                return;
                            }

                            // Strict comparison for values
                            if (lastValue === value) {
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
        })
    }

    const identificationTable = document.querySelector('#identificationTable')
    if (identificationTable) {
        const identificationDatatable = createDatatable(identificationTable, {
            handleColumnSearchField: false,
            responsive: false,
            serverSide: false,
            processing: false,
            paging: false,
            scrollX: true,
            scrollCollapse: true,
            lengthChange: false,
            autoWidth: true,
            pageLength: -1,
            ordering: false,
            sorting: false,
            info: false,
            columnDefs: [
                { targets: [0, 2, 3, 4, 5, 8, 9, 14, 18, 19, 20], width: 164 },
                { targets: [1, 6, 10, 22, 23, 24, 26, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 44, 45, 46, 47, 48, 49, 50, 51,], width: 96 },
                { targets: [7, 11, 12, 13, 15, 16, 17, 21, 25, 27, 40, 41, 42, 43, 52, 53, 54, 55], width: 128 },
                {
                    targets: [27, 40, 41, 42, 43, 52, 53, 54, 55],
                    createdCell: (td, data, rowData, row, col) => {
                        td.innerHTML = renderHeatmapBadge(data, td?.dataset?.color ?? '')
                    },
                }
            ],
            drawCallback: function (settings) {
                const api = this.api();

                // Your existing row merging logic
                const columnsToMerge = [0, 1, 2, 3, 4, 5].concat(Array.from({ length: 52 }, (x, i) => i + 14));

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
                    const worksheetNumber = data.target_body;
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
                            const currentCell = api.cell(rowIdx, colIdx).node();
                            if (!currentCell) return;

                            const value = currentCell.textContent.trim();

                            if (lastValue === null) {
                                lastValue = value;
                                firstRow = rowIdx;
                                return;
                            }

                            // Strict comparison for values
                            if (lastValue === value) {
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
        })
    }
});