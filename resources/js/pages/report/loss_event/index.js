import { formatNumeral } from "cleave-zen";
import { Offcanvas } from "bootstrap";
import Choices from "choices.js";
import createDatatable from "~js/components/datatable";
import { decodeHtml, defaultConfigChoices, defaultConfigFormatNumeral } from "~js/components/helper";
import debounce from "~js/utils/debounce";

const inputSearch = document.querySelector('input[name="search"]')

const lossEventOffcanvas = document.querySelector('#loss_event-table-offcanvas')
const lossEventOffcanvasInstance = new Offcanvas(lossEventOffcanvas)
const lossEventFilterButton = document.querySelector('#loss_event-filter-button')
lossEventFilterButton.addEventListener('click', () => {
    lossEventOffcanvasInstance.show()
})
const lossEventTableFilter = lossEventOffcanvas.querySelector('#loss_event-table-filter')

const selectLength = lossEventTableFilter.querySelector('select[name="length"]')
const selectYear = lossEventTableFilter.querySelector('select[name="year"]')
const selectUnit = lossEventTableFilter.querySelector('select[name="unit"]')

const selectLengthChoices = new Choices(selectLength, defaultConfigChoices)
const selectYearChoices = new Choices(selectYear, defaultConfigChoices)
const selectUnitChoices = new Choices(selectUnit, defaultConfigChoices)

const exportButton = document.querySelector('#loss_event-export')

const columns = [
    {
        orderable: true,
        data: 'worksheet_number',
        name: 'worksheet_number',
        width: '96px'
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

            return `[${row.sub_unit_code_doc}] ${row.sub_unit_name}`
        }
    },
    {
        orderable: true,
        data: 'target_body',
        name: 'target_body',
        width: '128px',
    },
    {
        orderable: true,
        data: 'incident_body',
        name: 'incident_body',
        width: '256px',
    },
    {
        orderable: true,
        data: 'incident_date',
        name: 'incident_date',
        width: '128px',
    },
    {
        orderable: true,
        data: 'incident_source',
        name: 'incident_source',
        width: '160px',
    },
    {
        orderable: true,
        data: 'incident_handling',
        name: 'incident_handling',
        width: '256px',
    },
    {
        orderable: true,
        data: 'risk_category',
        name: 'risk_category',
        render: function (data, type, row) {
            return `${row.risk_category_t2_name} & ${row.risk_category_t3_name}`;
        }
    },
    {
        orderable: true,
        data: 'loss_value',
        name: 'loss_value',
        width: '160px',
        render: function (data, type, row) {
            if (data) {
                return formatNumeral(data, defaultConfigFormatNumeral);
            }

            return '';
        }
    },
    {
        orderable: true,
        data: 'related_party',
        name: 'related_party',
        width: '256px',
    },
    {
        orderable: true,
        data: 'restoration_status',
        name: 'restoration_status',
        width: '256px',
    },
    {
        orderable: true,
        data: 'insurance_status',
        name: 'insurance_status',
    },
    {
        orderable: true,
        data: 'insurance_permit',
        name: 'insurance_permit',
        width: '160px',
        render: function (data, type, row) {
            if (data) {
                return formatNumeral(data, defaultConfigFormatNumeral);
            }

            return '';
        }
    },
    {
        orderable: true,
        data: 'insurance_claim',
        name: 'insurance_claim',
        width: '160px',
        render: function (data, type, row) {
            if (data) {
                return formatNumeral(data, defaultConfigFormatNumeral);
            }

            return '';
        }
    },
    {
        orderable: true,
        data: 'employee_name',
        name: 'employee_name',
        width: '160px',
    },
    {
        defaultContent: "Aksi",
        data: 'action',
        name: 'action',
        searchable: false,
        sortable: false,
        responsivePriority: 1
    },
    {
        orderable: true,
        data: 'created_at',
        name: 'created_at',
        visible: false  // Hidden but used for default sorting
    }
]

const datatable = createDatatable('#loss_event-table', {
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

    const a = document.createElement('a')
    a.href = url.toString()
    a.target = '_blank'

    document.body.appendChild(a)
    a.click()
    document.body.removeChild(a)
})

lossEventTableFilter.addEventListener('submit', e => {
    e.preventDefault()

    query.search = inputSearch.value
    query.page = datatable.page() + 1
    query.per_page = selectLength.value
    query.unit = selectUnit.value
    query.year = selectYear.value

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

lossEventTableFilter.addEventListener('reset', e => {
    inputSearch.value = '';

    selectLengthChoices.destroy()
    selectLengthChoices.init()
    selectYearChoices.destroy()
    selectYearChoices.init()
    selectUnitChoices.destroy()
    selectUnitChoices.init()

    query.search = inputSearch.value
    query.page = 1
    query.per_page = selectLength.value
    query.unit = selectUnit.value
    query.year = selectYear.value

    datatable.page.len(selectLength.value).search('').order([columns.length - 1, 'desc']).draw();
})
