import { Offcanvas } from "bootstrap";
import Choices from "choices.js";
import createDatatable from "~js/components/datatable";
import { decodeHtml, defaultConfigChoices } from "~js/components/helper";
import debounce from "~js/utils/debounce";

const inputSearch = document.querySelector('input[name="search"]')

const alterationOffcanvas = document.querySelector('#alteration-table-offcanvas')
const alterationOffcanvasInstance = new Offcanvas(alterationOffcanvas)
const alterationFilterButton = document.querySelector('#alteration-filter-button')
alterationFilterButton.addEventListener('click', () => {
    alterationOffcanvasInstance.show()
})
const alterationTableFilter = alterationOffcanvas.querySelector('#alteration-table-filter')

const selectLength = alterationTableFilter.querySelector('select[name="length"]')
const selectYear = alterationTableFilter.querySelector('select[name="year"]')
const selectMonth = alterationTableFilter.querySelector('select[name="month"]')
const selectUnit = alterationTableFilter.querySelector('select[name="unit"]')
const selectLocation = alterationTableFilter.querySelector('select[name="location"]')

const selectLengthChoices = new Choices(selectLength, defaultConfigChoices)
const selectYearChoices = new Choices(selectYear, defaultConfigChoices)
const selectMonthChoices = new Choices(selectMonth, defaultConfigChoices)
const selectUnitChoices = new Choices(selectUnit, defaultConfigChoices)
const selectLocationChoices = new Choices(selectLocation, defaultConfigChoices)

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
const exportButton = document.querySelector('#alteration-export')

const columns = [
    {
        orderable: true,
        data: 'worksheet_number',
        name: 'worksheet_number',
        width: '128px'
    },
    {
        orderable: true,
        data: 'sub_unit_name',
        name: 'sub_unit_name',
        width: '196px',
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
        data: 'body',
        name: 'body',
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
        data: 'impact',
        name: 'impact',
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
        data: 'description',
        name: 'description',
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
        data: 'employee_name',
        name: 'employee_name',
        width: '192px',
        visible: false  // Hidden but used for default sorting
    },
    {
        defaultContent: "Aksi",
        data: 'action',
        name: 'action',
        searchable: false,
        sortable: false,
        responsivePriority: 1
    },
    // {
    //     orderable: true,
    //     data: 'created_at',
    //     name: 'created_at',
    //     visible: false  // Hidden but used for default sorting
    // },
]

const datatable = createDatatable('#alteration-table', {
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
        }
    },
    fixedColumns: {
        start: 3
    },
    scrollX: true,
    scrollY: '48vh',
    scrollCollapse: true,
    lengthChange: false,
    autoWidth: false,
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

alterationTableFilter.addEventListener('submit', e => {
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

alterationTableFilter.addEventListener('reset', e => {
    inputSearch.value = '';

    selectLengthChoices.destroy()
    selectLengthChoices.init()
    selectYearChoices.destroy()
    selectYearChoices.init()
    selectMonthChoices.destroy()
    selectMonthChoices.init()
    selectUnitChoices.destroy()
    selectUnitChoices.init()

    query.search = inputSearch.value
    query.page = 1
    query.per_page = selectLength.value
    query.unit = selectUnit.value
    query.year = selectYear.value

    datatable.page.len(selectLength.value).search('').order([columns.length - 1, 'desc']).draw();
})
