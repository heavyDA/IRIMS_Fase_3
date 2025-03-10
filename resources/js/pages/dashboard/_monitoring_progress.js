import axios from 'axios';
import { Modal } from 'bootstrap';
import dayjs from 'dayjs';
import createDatatable from '~js/components/datatable';

const dashboardFilter = document.querySelector('#dashboard-filter')
const selectYear = dashboardFilter.querySelector('select[name="year"]')

const monitoringProgressTable = document.querySelector('#progress-monitoring-table')
const monitoringProgressChildModalEl = document.querySelector('#monitoring-progress-chid-modal');
const monitoringProgressChildModal = new Modal(monitoringProgressChildModalEl);
const monitoringProgressChildModalTitle = monitoringProgressChildModalEl.querySelector('.modal-title');
const monitoringProgressChildTableWrapper = monitoringProgressChildModalEl.querySelector('#monitoring-progress-chid-table-wrapper');
const monitoringProgressChildTable = monitoringProgressChildModalEl.querySelector('#monitoring-progress-child-table');

const fetch = async (unit, year) => {
    const param = new URLSearchParams()
    if (unit) {
        param.append('unit', unit);
    }

    if (year) {
        param.append('year', year);
    }
    const response = await axios.get(new URL('/analytics/monitoring-progress-child', window.location.origin).href + '?' + param.toString());
    const data = response.data;

    if (response.status == 200) {
        return data.data
    }

    return []
}

if (monitoringProgressTable) {
    const columns = [
        {
            sortable: false,
            data: 'sub_unit_name',
            name: 'sub_unit_name',
            width: '164px',
            render: (data, type, row) => {
                if (type !== 'display') {
                    return data
                }

                const btn = document.createElement('button')
                btn.classList.add('btn', 'btn-sm', 'btn-wave')
                btn.addEventListener('click', e => openChildModal(row.sub_unit_code, `[${row.sub_unit_code_doc}] ${data}`))
                btn.innerHTML = `[${row.sub_unit_code_doc}] ${data}`

                return btn
            }
        },
        {
            sortable: false,
            data: 'm1',
            name: 'm1',
            width: '80px'
        },
        {
            sortable: false,
            data: 'm2',
            name: 'm2',
            width: '80px'
        },
        {
            sortable: false,
            data: 'm3',
            name: 'm3',
            width: '80px'
        },
        {
            sortable: false,
            data: 'm4',
            name: 'm4',
            width: '80px'
        },
        {
            sortable: false,
            data: 'm5',
            name: 'm5',
            width: '80px'
        },
        {
            sortable: false,
            data: 'm6',
            name: 'm6',
            width: '80px'
        },
        {
            sortable: false,
            data: 'm7',
            name: 'm7',
            width: '80px'
        },
        {
            sortable: false,
            data: 'm8',
            name: 'm8',
            width: '80px'
        },
        {
            sortable: false,
            data: 'm9',
            name: 'm9',
            width: '80px'
        },
        {
            sortable: false,
            data: 'm10',
            name: 'm10',
            width: '80px'
        },
        {
            sortable: false,
            data: 'm11',
            name: 'm11',
            width: '80px'
        },
        {
            sortable: false,
            data: 'm12',
            name: 'm12',
            width: '80px'
        }
    ];

    let datatableChild = null

    const datatable = createDatatable(monitoringProgressTable, {
        handleColumnSearchField: false,
        responsive: false,
        serverSide: true,
        ordering: false,
        processing: true,
        paging: false,
        ajax: {
            url: '/analytics/get-monitoring-progress',
            data: function (d) {
                d.year = selectYear.value
            }
        },
        scrollX: true,
        fixedColumns: true,
        lengthChange: false,
        pageLength: -1,
        scrollY: '36vh',
        columns: columns,
        columnDefs: [
            {
                targets: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                createdCell: (td, data, rowData, row, col) => {
                    if (data) {
                        data = parseInt(data)
                        if (data) {
                            if (data >= 1 && data < 55) {
                                td.classList.add('bg-danger-transparent')
                            } else if (data >= 55 && data < 100) {
                                td.classList.add('bg-warning-transparent')
                            } else if (data >= 100) {
                                td.classList.add('bg-success-transparent')
                            }
                        }
                    }
                },
                render: (data, type, row) => {
                    data = data ? data : 0;
                    if (type !== 'display') {
                        return data
                    }

                    return `${data ? parseInt(data) : 0}%`
                }
            }
        ]
    })

    const openChildModal = (unitCode, title) => {
        monitoringProgressChildModal.show()

        monitoringProgressChildModalTitle.innerHTML = `Monitoring Progress ${title}`

        monitoringProgressChildModalEl.addEventListener('shown.bs.modal', e => {
            // Clear the table's HTML content first
            const table = document.createElement('table')
            table.id = 'monitoring-progress-child-table'
            table.classList.add('table', 'table-bordered', 'table-striped', 'display', 'nowrap')
            table.style.width = '100%'

            let months = ''
            for (let i = 1; i <= 12; i++) {
                let month = i < 10 ? '0' + i : i
                months += `<th style="text-align: center !important;">${dayjs(`${selectYear.value}-${month}-01`).format('MMM')}</th>`
            }

            table.innerHTML = `<thead>
                                <tr>
                                <th class="table-dark-custom" rowspan="2" style="text-align: center !important;width: 256px;">Unit</th>
                                <th colspan="12" class="table-dark-custom" style="text-align: center !important;">
                                    Timeline</th>
                                </tr>
                                <tr>${months}</tr>
                            </thead>`

            monitoringProgressChildTableWrapper.innerHTML = ''
            monitoringProgressChildTableWrapper.append(table)
            if (datatableChild) {
                datatableChild.clear()
                datatableChild.destroy()
                datatableChild = null
            }
            setTimeout(
                () => {
                    const childColumns = [
                        {
                            sortable: false,
                            data: 'sub_unit_name',
                            name: 'sub_unit_name',
                            width: '164px',
                            render: (data, type, row) => {
                                if (type !== 'display') {
                                    return data
                                }

                                return `[${row.sub_unit_code_doc}] ${data}`
                            }
                        },
                        {
                            sortable: false,
                            data: 'm1',
                            name: 'm1',
                            width: '80px'
                        },
                        {
                            sortable: false,
                            data: 'm2',
                            name: 'm2',
                            width: '80px'
                        },
                        {
                            sortable: false,
                            data: 'm3',
                            name: 'm3',
                            width: '80px'
                        },
                        {
                            sortable: false,
                            data: 'm4',
                            name: 'm4',
                            width: '80px'
                        },
                        {
                            sortable: false,
                            data: 'm5',
                            name: 'm5',
                            width: '80px'
                        },
                        {
                            sortable: false,
                            data: 'm6',
                            name: 'm6',
                            width: '80px'
                        },
                        {
                            sortable: false,
                            data: 'm7',
                            name: 'm7',
                            width: '80px'
                        },
                        {
                            sortable: false,
                            data: 'm8',
                            name: 'm8',
                            width: '80px'
                        },
                        {
                            sortable: false,
                            data: 'm9',
                            name: 'm9',
                            width: '80px'
                        },
                        {
                            sortable: false,
                            data: 'm10',
                            name: 'm10',
                            width: '80px'
                        },
                        {
                            sortable: false,
                            data: 'm11',
                            name: 'm11',
                            width: '80px'
                        },
                        {
                            sortable: false,
                            data: 'm12',
                            name: 'm12',
                            width: '80px'
                        }
                    ];

                    datatableChild = createDatatable(table, {
                        handleColumnSearchField: false,
                        responsive: false,
                        serverSide: true,
                        ordering: false,
                        processing: true,
                        ajax: {
                            url: '/analytics/get-monitoring-progress',
                            data: function (d) {
                                d.year = selectYear.value
                                d.unit = unitCode
                            }
                        },
                        scrollX: true,
                        fixedColumns: true,
                        lengthChange: false,
                        pageLength: 10,
                        paging: true,
                        scrollCollapse: true,
                        scrollY: '74vh',
                        columns: childColumns,
                        order: [[childColumns.length - 1, 'desc']],
                        columnDefs: [
                            {
                                targets: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                                createdCell: (td, data, rowData, row, col) => {
                                    if (data) {
                                        data = parseInt(data)
                                        if (data) {
                                            let color = 'bg-danger-transparent'
                                            if (data > 30 && data <= 70) {
                                                color = 'bg-warning-transparent'
                                            } else if (data > 70) {
                                                color = 'bg-success-transparent'
                                            }
                                            td.classList.add(color)
                                        }
                                    }
                                },
                                render: (data, type, row) => {
                                    data = data ? data : 0;
                                    if (type !== 'display') {
                                        return data
                                    }

                                    return `${data ? parseInt(data) : 0}%`
                                }
                            }
                        ]
                    })
                }, 275
            )
        })

        monitoringProgressChildModalEl.addEventListener('hidden.bs.modal', e => {
            monitoringProgressChildTableWrapper.innerHTML = ''
            if (datatableChild) {
                datatableChild.clear()
                datatableChild = null
            }
        })
    }
}