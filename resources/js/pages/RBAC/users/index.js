import createDatatable from "js/components/datatable";
console.log("SOMETJIG")
const datatable = createDatatable('table', {
    handleColumnSearchField: false,
    columns: [
        {
            defaultContent: "",
            searchable: false,
            render: function (row, cell) {
                return '<i class="ti ti-plus"></i>'
            }
        },
        {
            title: 'Nama Depan',
            data: 'first_name',
            name: 'first_name'
        },
        {
            title: 'Nama Belakang',
            data: 'last_name',
            name: 'last_name'
        },
        {
            title: 'Email',
            data: 'email',
            name: 'email'
        },
        {
            title: 'Tanggal Dibuat',
            data: 'created_at',
            name: 'created_at',
            fieldType: 'date',
            operator: '>='
        },
        {
            defaultContent: "Aksi",
            data: 'action',
            name: 'action',
            searchable: false,
            sortable: false,
            responsivePriority: 1
        }
    ],
})
