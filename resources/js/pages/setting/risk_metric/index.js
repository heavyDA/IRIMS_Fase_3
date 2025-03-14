import { formatNumeral } from "cleave-zen";
import createDatatable from "~js/components/datatable";
import { defaultConfigFormatNumeral } from "~js/components/helper";
import debounce from "~js/utils/debounce";

const table = createDatatable("#risk-metric-table", {
    handleColumnSearchField: false,
    responsive: false,
    serverSide: true,
    processing: true,
    ajax: window.location.href,
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
    ],
});

const searchField = document.querySelector('input[name="search"]')

searchField?.addEventListener('input', debounce(e => {
    table.search(e.target.value).draw()
}, 825))

const resetTableButton = document.querySelector('button[type="reset"]')
resetTableButton?.addEventListener('click', () => {
    if (searchField) {
        searchField.value = ''
    }
    table.draw()
})
