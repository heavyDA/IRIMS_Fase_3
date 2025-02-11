import createDatatable from "js/components/datatable";
import debounce from "js/utils/debounce";

const table = createDatatable("#bumn-scale-table", {handleColumnSearchField: false,
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
            data: 'impact_category',
            name: 'impact_category',
            width: '120px'
        },
        {
            sortable: true,
            data: 'scale',
            name: 'scale',
            width: '64px'
        },
        {
            sortable: true,
            data: 'criteria',
            name: 'criteria',
            width: '164px',
        },
        {
            sortable: true,
            data: 'description',
            name: 'description',
            width: '164px',
        },
        {
            sortable: true,
            data: 'min',
            name: 'min',
            width: '64px',
        },
        {
            sortable: true,
            data: 'max',
            name: 'max',
            width: '64px',
        },
        {
            sortable: true,
            data: 'action',
            name: 'action',
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
