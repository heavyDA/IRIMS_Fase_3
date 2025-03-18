import { Offcanvas } from "bootstrap";
import Choices from "choices.js";
import { formatNumeral } from "cleave-zen";
import { defaultConfigChoices } from "~js/components/helper";
import createDatatable from "~js/components/datatable";
import { defaultConfigFormatNumeral } from "~js/components/helper";
import debounce from "~js/utils/debounce";

const searchField = document.querySelector('input[name="search"]')

const offcanvas = document.querySelector('#table-offcanvas')
const offcanvasInstance = new Offcanvas(offcanvas)
const filterButton = document.querySelector('#filter-button')
filterButton.addEventListener('click', () => {
    offcanvasInstance.show()
})
const tableFilter = offcanvas.querySelector('#table-filter')

const selectLength = tableFilter.querySelector('select[name="length"]')
const selectUnit = tableFilter.querySelector('select[name="unit"]')

const selectLengthChoices = new Choices(selectLength, defaultConfigChoices)
const selectUnitChoices = new Choices(selectUnit, defaultConfigChoices)
const withHistoryCheckbox = tableFilter.querySelector('input[name="with_history"]')

searchField?.addEventListener('input', debounce(e => {
    table.search(e.target.value).draw()
}, 825))


tableFilter.addEventListener('submit', e => {
    e.preventDefault()


    table.page.len(selectLength.value).draw();

    setTimeout(() => {
        offcanvasInstance.hide()
    }, 315);
})

const resetTableButton = document.querySelector('button[type="reset"]')
resetTableButton?.addEventListener('click', () => {
    searchField.value = '';

    selectLengthChoices.destroy()
    selectLengthChoices.init()
    selectUnitChoices.destroy()
    selectUnitChoices.init()
    withHistoryCheckbox.checked = false

    table.page.len(selectLength.value).search('').draw();
})

const table = createDatatable("#risk-metric-table", {
    handleColumnSearchField: false,
    responsive: false,
    serverSide: true,
    processing: true,
    ajax: {
        url: window.location.href,
        data: function (d) {
            d.unit = selectUnit.value
            d.with_history = withHistoryCheckbox.checked ? 1 : 0
        }
    },
    scrollX: true,
    fixedColumns: true,
    lengthChange: false,
    pageLength: 10,
    scrollX: true,
    scrollY: '48vh',
    columns: [
        {
            sortable: true,
            data: 'organization_name',
            name: 'organization_name',
            width: '120px',
            render: function (data, type, row) {
                if (type !== 'display') {
                    return data
                }

                return `[${row.personnel_area_code}] ${row.organization_name}`
            }
        },
        {
            sortable: true,
            data: 'capacity',
            name: 'capacity',
            width: '128px',
            render: function (data, type, row) {
                if (type !== 'display') {
                    return data
                }

                return formatNumeral(row.capacity.replace('.', ','), defaultConfigFormatNumeral)
            }
        },
        {
            sortable: true,
            data: 'appetite',
            name: 'appetite',
            width: '128px',
            render: function (data, type, row) {
                if (type !== 'display') {
                    return data
                }

                return formatNumeral(row.appetite.replace('.', ','), defaultConfigFormatNumeral)
            }
        },
        {
            sortable: true,
            data: 'tolerancy',
            name: 'tolerancy',
            width: '128px',
            render: function (data, type, row) {
                if (type !== 'display') {
                    return data
                }

                return formatNumeral(row.tolerancy.replace('.', ','), defaultConfigFormatNumeral)
            }
        },
        {
            sortable: true,
            data: 'limit',
            name: 'limit',
            width: '128px',
            render: function (data, type, row) {
                if (type !== 'display') {
                    return data
                }

                return formatNumeral(row.limit.replace('.', ','), defaultConfigFormatNumeral)
            }
        },
        {
            sortable: true,
            data: 'creator.employee_name',
            name: 'creator.employee_name',
            width: '128px',
        },
        {
            sortable: true,
            data: 'status',
            name: 'status',
            width: '64px',
        },
        {
            sortable: true,
            data: 'created_at',
            name: 'created_at',
            width: '64px',
        },
    ],
});