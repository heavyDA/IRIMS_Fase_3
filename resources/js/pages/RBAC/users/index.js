import createDatatable from "js/components/datatable";
import debounce from "js/utils/debounce";

const columns = [
    {
        title: 'Nama Lengkap',
        data: 'employee_name',
        name: 'employee_name',
        render: function (data, type, row) {
            if (type !== 'display') {
                return data
            }

            return `<div class="d-flex flex-column">
                <p>${data}</p>
                <small><strong>${row.employee_id}</strong></small>
            </div>`
        }
    },
    {
        title: 'Email',
        data: 'email',
        name: 'email'
    },
    {
        title: 'Unit',
        data: 'sub_unit_name',
        name: 'sub_unit_name',
        render: function (data, type, row) {
            if (type !== 'display') {
                return data
            }

            return `[${row.personnel_area_code}] ${data}`
        }
    },
    {
        title: 'Posisi',
        data: 'position_name',
        name: 'position_name'
    },
    {
        title: 'Status',
        data: 'is_local_user',
        name: 'is_local_user',
        searchable: false,
        render: function (data, type, row) {
            if (type !== 'display') {
                return data
            }

            if (data) {
                return `<span class="badge badge-sm bg-secondary-transparent">E-Office</span>`
            }

            return `<span class="badge badge-sm bg-info-transparent">Lokal</span>`
        }
    },
    {
        title: 'Roles',
        data: 'roles',
        name: 'roles',
        searchable: false,
        render: function (data, type, row) {
            if (type !== 'display') {
                return data
            }

            if (!data) {
                return '';

            }
            return (data.map((item) => item.name).join(", "))
        }
    },
    {
        defaultContent: "Aksi",
        data: 'action',
        name: 'action',
        searchable: false,
        sortable: false,
        responsivePriority: 1
    }
]

const datatable = createDatatable('table', {
    handleColumnSearchField: false,
    responsive: false,
    serverSide: true,
    processing: true,
    columnDefs: [{ targets: [3], width: 128 }],
    ajax: {
        url: window.location.href,
        data: function (d) {
        }
    },
    fixedColumns: true,
    scrollX: true,
    scrollY: '48vh',
    scrollCollapse: true,
    lengthChange: false,
    autoWidth: true,
    pageLength: 10,
    columns: columns
})

const searchField = document.querySelector('input[name="search"]')

searchField?.addEventListener('input', debounce(e => {
    datatable.search(e.target.value).draw()
}, 825))

const resetTableButton = document.querySelector('button[type="reset"]')
resetTableButton?.addEventListener('click', () => {
    if (searchField) {
        searchField.value = ''
    }
    datatable.draw()
})
