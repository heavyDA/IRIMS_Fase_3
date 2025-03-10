import { Offcanvas } from "bootstrap";
import Choices from "choices.js";
import createDatatable from "~js/components/datatable";
import { decodeHtml, defaultConfigFormatNumeral, defaultConfigChoices, renderHeatmapBadge } from "~js/components/helper";
import debounce from "~js/utils/debounce";

const inputSearch = document.querySelector('input[name="search"]')

const worksheetOffcanvas = document.querySelector('#worksheet-table-offcanvas')
const worksheetOffcanvasInstance = new Offcanvas(worksheetOffcanvas)
const worksheetFilterButton = document.querySelector('#worksheet-filter-button')
worksheetFilterButton.addEventListener('click', () => {
    worksheetOffcanvasInstance.show()
})
const worksheetTableFilter = worksheetOffcanvas.querySelector('#worksheet-table-filter')

const selectLength = worksheetTableFilter.querySelector('select[name="length"]')
const selectYear = worksheetTableFilter.querySelector('select[name="year"]')
const selectUnit = worksheetTableFilter.querySelector('select[name="unit"]')
const selectDocumentStatus = worksheetTableFilter.querySelector('select[name="document_status"]')

const selectLengthChoices = new Choices(selectLength, defaultConfigChoices)
const selectYearChoices = new Choices(selectYear, defaultConfigChoices)
const selectUnitChoices = new Choices(selectUnit, defaultConfigChoices)
const selectDocumentStatusChoices = new Choices(selectDocumentStatus, defaultConfigChoices)

const columns = [
    {
        orderable: true,
        data: 'worksheet_number',
        name: 'worksheet_number',
        width: '96px'
    },
    {
        orderable: true,
        data: 'status',
        name: 'status',
        width: '120px'
    },
    {
        orderable: true,
        data: 'sub_unit_name',
        name: 'sub_unit_name',
        width: '128px',
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
        width: '128px',
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
        orderable: true,
        data: 'risk_chronology_body',
        name: 'risk_chronology_body',
        width: '200px',
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
        orderable: true,
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
        orderable: true,
        data: 'risk_impact_body',
        name: 'risk_impact_body',
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
        orderable: true,
        data: 'inherent_risk_level',
        name: 'inherent_risk_level',
        width: '100px',
        render: function (data, type, row) {
            if (type !== 'display') {
                return data
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
            if (type !== 'display') {
                return data
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
            if (type !== 'display') {
                return data
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
            if (type !== 'display') {
                return data
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
            if (type !== 'display') {
                return data
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
        data: 'created_at',
        name: 'created_at',
        visible: false  // Hidden but used for default sorting
    }
]

const datatable = createDatatable('#worksheet-table', {
    handleColumnSearchField: false,
    responsive: false,
    serverSide: true,
    processing: true,
    columnDefs: [{ targets: [3], width: 128 }],
    ajax: {
        url: window.location.href,
        data: function (d) {
            d.year = selectYear.value
            d.unit = selectUnit.value
            d.document_status = selectDocumentStatus.value
        }
    },
    fixedColumns: {
        start: 2
    },
    scrollX: true,
    scrollY: '48vh',
    scrollCollapse: true,
    lengthChange: false,
    autoWidth: true,
    pageLength: 10,
    columns: columns,
    order: [[columns.length - 1, 'desc']],
    drawCallback: function (settings) {
        const api = this.api();

        // Your existing row merging logic
        const columnsToMerge = [0, 1, 2, 3, 4, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16];

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
            const worksheetNumber = data.worksheet_number;
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

        // Ensure proper header rendering
        // api.fixedHeader.adjust();
        // api.columns.adjust();
    },
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
    selectDocumentStatusChoices.destroy()
    selectDocumentStatusChoices.init()

    datatable.page.len(selectLength.value).search('').order([columns.length - 1, 'desc']).draw();
})
