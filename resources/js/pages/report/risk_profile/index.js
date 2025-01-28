import { Offcanvas } from "bootstrap";
import Choices from "choices.js";
import createDatatable from "js/components/datatable";
import { decodeHtml, defaultConfigFormatNumeral, defaultConfigChoices } from "js/components/helper";
import debounce from "js/utils/debounce";

const inputSearch = document.querySelector('input[name="search"]')

const worksheetOffcanvas = document.querySelector('#worksheet-table-offcanvas')
const worksheetOffcanvasInstance = new Offcanvas(worksheetOffcanvas)
const worksheetTableFilter = worksheetOffcanvas.querySelector('#worksheet-table-filter')

const selectLength = worksheetTableFilter.querySelector('select[name="length"]')
const selectYear = worksheetTableFilter.querySelector('select[name="year"]')
const selectUnit = worksheetTableFilter.querySelector('select[name="unit"]')
const selectDocumentStatus = worksheetTableFilter.querySelector('select[name="document_status"]')

const selectLengthChoices = new Choices(selectLength, defaultConfigChoices)
const selectYearChoices = new Choices(selectYear, defaultConfigChoices)
const selectUnitChoices = new Choices(selectUnit, defaultConfigChoices)
const selectDocumentStatusChoices = new Choices(selectDocumentStatus, defaultConfigChoices)

const exportButton = document.querySelector('#worksheet-export')

const datatable = createDatatable('table', {
    handleColumnSearchField: false,
    responsive: false,
    serverSide: true,
    processing: true,
    ajax: {
        url: window.location.href,
        data: function (d) {
            d.year = selectYear.value
            d.unit = selectUnit.value
            d.document_status = selectDocumentStatus.value
        }
    },
    scrollX: true,
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
    },
    scrollX: true,
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
            data: 'status',
            name: 'status',
            width: '128px'
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
                    return '';
                }

                const decodeData = decodeHtml(decodeHtml(data))
                const parsedData = new DOMParser().parseFromString(decodeData, 'text/html');

                return parsedData.body ? parsedData.body.innerHTML : '';
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
                    return '';
                }

                const decodeData = decodeHtml(decodeHtml(data))
                const parsedData = new DOMParser().parseFromString(decodeData, 'text/html');

                return parsedData.body ? parsedData.body.innerHTML : '';
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
                    return '';
                }

                const decodeData = decodeHtml(decodeHtml(data))
                const parsedData = new DOMParser().parseFromString(decodeData, 'text/html');

                return parsedData.body ? parsedData.body.innerHTML : '';
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
                    return '';
                }

                const decodeData = decodeHtml(decodeHtml(data))
                const parsedData = new DOMParser().parseFromString(decodeData, 'text/html');

                return parsedData.body ? parsedData.body.innerHTML : '';
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
    ],
})

datatable.on('draw.dt', e => {
    query.page = datatable.page() + 1
})

const query = {
    year: selectYear.value,
    page: 1,
    per_page: selectLength.value
}

exportButton.addEventListener('click', e => {
    e.preventDefault();
    const url = new URL(e.target.dataset.url)
    url.search = new URLSearchParams(query).toString()
    window.open(url, '_blank')
})

worksheetTableFilter.addEventListener('submit', e => {
    e.preventDefault()

    query.search = inputSearch.value
    query.page = datatable.page() + 1
    query.per_page = selectLength.value
    query.unit = selectUnit.value
    query.year = selectYear.value
    query.document_status = selectDocumentStatus.value

    datatable.page.len(selectLength.value).draw();

    setTimeout(() => {
        worksheetOffcanvasInstance.hide()
    }, 315);
})

inputSearch.addEventListener('input', debounce(
    e => {
        query.search = e.target.value
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

    query.search = inputSearch.value
    query.page = 1
    query.per_page = selectLength.value
    query.unit = selectUnit.value
    query.year = selectYear.value
    query.document_status = selectDocumentStatus.value

    datatable.page.len(selectLength.value).search('').draw();
})
