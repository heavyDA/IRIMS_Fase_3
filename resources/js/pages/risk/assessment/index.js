import { formatNumeral } from "cleave-zen";
import createDatatable from "js/components/datatable";
import { decodeHtml, defaultConfigFormatNumeral } from "js/components/helper";
const datatable = createDatatable('table', {
    handleColumnSearchField: false,
    responsive: false,
    serverSide: true,
    ajax: window.location.href,
    fixedColumns: true,
    lengthMenu: [5, 10, 25, 50],
    pageLength: 5,
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
            const worksheetNumber = data.target.worksheet.worksheet_number;
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
            title: 'No',
            data: 'target.worksheet.worksheet_number',
            name: 'target.worksheet.worksheet_number',
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
            data: 'target.worksheet.unit_name',
            name: 'target.worksheet.unit_name',
            width: '256px'
        },
        {
            sortable: false,
            title: 'Pilihan Sasaran',
            data: 'target_body',
            name: 'target_body',
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
            title: 'Pilihan Strategi',
            data: 'body',
            name: 'body',
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
            title: 'Hasil yang diharapkan dapat diterima perusahaan',
            data: 'expected_feedback',
            name: 'expected_feedback',
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
            title: 'Nilai risiko yang akan timbul',
            data: 'risk_value',
            name: 'risk_value',
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
            title: 'Nilai risiko yang akan timbul',
            data: 'risk_value_limit',
            name: 'risk_value_limit',
            width: '256px',
            render: function (data, type, row) {
                if (type !== 'display') {
                    return data
                }

                if (!data) {
                    return 'Rp. 0';
                }

                return formatNumeral(data, defaultConfigFormatNumeral);
            }
        },
        {
            sortable: false,
            title: 'Keputusan Penetapan',
            data: 'decision',
            name: 'decision'
        },
    ],
})


datatable.on('draw', function () {
    const thead = document.querySelector('table thead')
    thead.classList.add('table-dark')
})