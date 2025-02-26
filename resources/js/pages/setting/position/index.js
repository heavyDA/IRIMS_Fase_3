import createDatatable from "js/components/datatable";
import debounce from "js/utils/debounce";

const table = createDatatable("#position-table", {
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
            data: 'position_name',
            name: 'position_name',
            width: '120px'
        },
        {
            sortable: true,
            data: 'personnel_area_name',
            name: 'personnel_area_name',
            defaultContent: '',
            width: '120px'
        },
        {
            sortable: true,
            data: 'unit_name',
            name: 'unit_name',
            defaultContent: '',
            width: '120px',
        },
        {
            sortable: true,
            data: 'assigned_roles',
            name: 'assigned_roles',
            defaultContent: '',
            width: '120px',
            render: (data, type, row) => {
                if (type !== 'display') {
                    return data
                }
                return `<div class="text-capitalize">${data}</div>`
            }
        },
        {
            sortable: true,
            data: 'creator.employee_name',
            name: 'creator.employee_name',
            defaultContent: '',
            width: '164px',
        },
        {
            sortable: true,
            data: 'action',
            name: 'action',
            defaultContent: '',
            width: '64px',
        }
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
