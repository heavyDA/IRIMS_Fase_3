import createDatatable from "js/components/datatable";
import debounce from "js/utils/debounce";

const table = createDatatable("#risk-treatment-type-table", {
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
            data: 'name',
            name: 'name',
            width: '120px'
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
