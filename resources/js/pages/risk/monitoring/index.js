import { Offcanvas } from "bootstrap";
import Choices from "choices.js";
import createDatatable from "~js/components/datatable";
import { decodeHtml, defaultConfigChoices, renderHeatmapBadge } from "~js/components/helper";
import debounce from "~js/utils/debounce";

const inputSearch = document.querySelector('input[name="search"]')

const worksheetTable = document.querySelector('#worksheet-table')
const worksheetOffcanvas = document.querySelector('#worksheet-table-offcanvas')
const worksheetOffcanvasInstance = new Offcanvas(worksheetOffcanvas)
const worksheetFilterButton = document.querySelector('#worksheet-filter-button')
worksheetFilterButton.addEventListener('click', () => {
    worksheetOffcanvasInstance.show()
})
const worksheetTableFilter = worksheetOffcanvas.querySelector('#worksheet-table-filter')

const selectLength = worksheetTableFilter.querySelector('select[name="length"]')
const selectYear = worksheetTableFilter.querySelector('select[name="year"]')
const selectMonth = worksheetTableFilter.querySelector('select[name="month"]')
const selectUnit = worksheetTableFilter.querySelector('select[name="unit"]')
const selectDocumentStatus = worksheetTableFilter.querySelector('select[name="document_status"]')
const selectLocation = worksheetTableFilter.querySelector('select[name="location"]')
const selectRiskQualification = worksheetTableFilter.querySelector('select[name="risk_qualification"]')

const selectLengthChoices = new Choices(selectLength, defaultConfigChoices)
const selectYearChoices = new Choices(selectYear, defaultConfigChoices)
const selectMonthChoices = new Choices(selectMonth, defaultConfigChoices)
const selectUnitChoices = new Choices(selectUnit, defaultConfigChoices)
const selectDocumentStatusChoices = new Choices(selectDocumentStatus, defaultConfigChoices)
const selectLocationChoices = new Choices(selectLocation, defaultConfigChoices)
const selectRiskQualificationChoices = new Choices(selectRiskQualification, defaultConfigChoices)

const units = selectUnitChoices._currentState.choices;
const placeholder = { label: 'Semua', value: '', placeholder: true, selected: true };
selectUnitChoices.disable()
selectLocation.addEventListener('change', (e) => {
    const item = selectLocationChoices.getValue();

    if (item.value) {
        selectUnitChoices.clearChoices()
        selectUnitChoices.setChoices([
            placeholder,
            ...units.filter(
                (choice) => choice.customProperties.parent == item.value
            )
        ])
            .enable()
        return
    }

    selectUnitChoices.clearChoices()
    selectUnitChoices.setChoices([placeholder])
        .disable()
})
selectLocation.dispatchEvent(new Event('change'));
worksheetTableFilter.addEventListener('reset', e => {
    inputSearch.value = '';

    selectLengthChoices.destroy()
    selectLengthChoices.init()
    selectYearChoices.destroy()
    selectYearChoices.init()
    selectMonthChoices.destroy()
    selectMonthChoices.init()
    selectLocationChoices.destroy()
    selectLocationChoices.init()
    selectUnitChoices.destroy()
    selectUnitChoices.init()
    selectDocumentStatusChoices.destroy()
    selectDocumentStatusChoices.init()
    selectRiskQualificationChoices.destroy()
    selectRiskQualificationChoices.init()
    datatable.page.len(selectLength.value).search('').order([columns.length - 1, 'desc']).draw();
})

worksheetTableFilter.addEventListener('submit', e => {
    e.preventDefault();
    datatable.page.len(selectLength.value).draw();

    setTimeout(() => {
        worksheetOffcanvasInstance.hide()
    }, 315);
})

inputSearch.addEventListener('input', debounce(
    e => datatable.search(e.target.value).draw(),
    875
))

const columns = [
    {
        orderable: true,
        data: 'worksheet_number',
        name: 'worksheet_number',
        width: '128px'
    },
    {
        orderable: true,
        data: 'status_monitoring',
        name: 'status_monitoring',
        width: '128px'
    },
    {
        orderable: true,
        data: 'sub_unit_name',
        name: 'sub_unit_name',
        width: '192px',
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
        width: '312px',
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
        width: '312px',
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
        data: 'mitigation_plan',
        name: 'mitigation_plan',
        width: '312px',
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
        data: 'actualization_plan_output',
        name: 'actualization_plan_output',
        width: '312px',
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
        orderable: true,
        data: 'inherent_risk_level',
        name: 'inherent_risk_level',
        width: '128px',
        render: function (data, type, row) {
            if (type !== 'display') {
                return data
            }

            if (!data) {
                return '';
            }

            return renderHeatmapBadge(data, row.inherent_risk_color)
        }
    },
    {
        orderable: true,
        data: 'inherent_risk_scale',
        name: 'inherent_risk_scale',
        width: '128px',
        render: function (data, type, row) {
            if (type !== 'display') return data;

            return data ? data : '-';
        }
    },
    {
        orderable: true,
        data: 'residual_risk_level',
        name: 'residual_risk_level',
        width: '128px',
        render: function (data, type, row) {
            if (type !== 'display') {
                return data
            }

            if (!data) {
                return '';
            }

            return renderHeatmapBadge(data, row.residual_risk_color)
        }
    },
    {
        orderable: true,
        data: 'residual_risk_scale',
        name: 'residual_risk_scale',
        width: '128px',
        render: function (data, type, row) {
            if (type !== 'display') return data;

            return data ? data : '-';
        }
    },
    {
        orderable: true,
        data: 'created_at',
        name: 'created_at',
        visible: false
    }
]
const datatable = createDatatable('table', {
    handleColumnSearchField: false,
    responsive: false,
    serverSide: true,
    processing: true,
    ajax: {
        url: window.location.href,
        data: function (d) {
            d.year = selectYear.value
            d.month = selectMonth.value
            d.unit = selectUnit.value
            d.document_status = selectDocumentStatus.value
            d.risk_qualification = selectRiskQualification.value
        }
    },
    columnDefs: [{ targets: [3], width: 128 }],
    fixedColumns: {
        start: 2
    },
    scrollX: true,
    scrollY: '48vh',
    scrollCollapse: true,
    lengthChange: false,
    autoWidth: false,
    pageLength: 10,
    columns: columns,
    order: [[columns.length - 1, 'desc']],
    drawCallback: function (settings) {
        const api = this.api();
        const columnsToMerge = [0, 1, 2, 3, 4, 7, 8, 9, 10];

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
    }
})

datatable.on('draw', function () {
    const thead = document.querySelector('table thead')
    thead.classList.add('table-dark')
})
