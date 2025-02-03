import createDatatable from "js/components/datatable"
import { decodeHtml } from "js/components/helper"

const dashboardFilter = document.querySelector('#dashboard-filter')
const selectYear = dashboardFilter.querySelector('select[name="year"]')
const topRiskDatatable = createDatatable('#top-risk-table', {
    handleColumnSearchField: false,
    responsive: false,
    serverSide: true,
    ordering: false,
    processing: true,
    ajax: {
        url: '/risk-process/top-risk/get-for-dashboard',
        data: function (d) {
            d.year = selectYear.value
        }
    },
    scrollX: true,
    fixedColumns: true,
    lengthChange: false,
    pageLength: -1,

    scrollY: '48vh',
    columns: [
        {
            sortable: true,
            data: 'worksheet_number',
            name: 'worksheet_number',
            width: '64px'
        },
        {
            sortable: true,
            data: 'sub_unit_name',
            name: 'sub_unit_name',
            width: '256px',
            render: function (data, type, row) {
                if (type !== 'display') {
                    return data
                }

                return `[${row.personnel_area_code}] ${row.sub_unit_name}`
            }
        },
        {
            sortable: true,
            data: 'risk_chronology_body',
            name: 'risk_chronology_body',
            width: '256px',
            render: function (data, type, row) {
                if (type !== 'display') {
                    return data
                }

                if (!data) {
                    return ''
                }

                const decodeData = decodeHtml(decodeHtml(data))
                const parsedData = new DOMParser().parseFromString(decodeData, 'text/html')

                return parsedData.body ? parsedData.body.innerHTML : ''
            }
        },
        {
            sortable: true,
            data: 'risk_cause_body',
            name: 'risk_cause_body',
            width: '256px',
            render: function (data, type, row) {
                if (type !== 'display') {
                    return data
                }

                if (!data) {
                    return ''
                }

                const decodeData = decodeHtml(decodeHtml(data))
                const parsedData = new DOMParser().parseFromString(decodeData, 'text/html')

                return parsedData.body ? parsedData.body.innerHTML : ''
            }
        },
        {
            sortable: true,
            data: 'mitigation_plan',
            name: 'mitigation_plan',
            width: '256px',
            render: function (data, type, row) {
                if (type !== 'display') {
                    return data
                }

                if (!data) {
                    return ''
                }

                const decodeData = decodeHtml(decodeHtml(data))
                const parsedData = new DOMParser().parseFromString(decodeData, 'text/html')

                return parsedData.body ? parsedData.body.innerHTML : ''
            }
        },
        {
            sortable: true,
            data: 'inherent_risk_level',
            name: 'inherent_risk_level',
            width: '100px',
        },
        {
            sortable: true,
            data: 'inherent_risk_scale',
            name: 'inherent_risk_scale',
            width: '100px',
        },
        {
            sortable: true,
            data: 'residual_1_risk_level',
            name: 'residual_1_risk_level',
            width: '100px',
        },
        {
            sortable: true,
            data: 'residual_2_risk_level',
            name: 'residual_2_risk_level',
            width: '100px',
        },
        {
            sortable: true,
            data: 'residual_3_risk_level',
            name: 'residual_3_risk_level',
            width: '100px',
        },
        {
            sortable: true,
            data: 'residual_4_risk_level',
            name: 'residual_4_risk_level',
            width: '100px',
        },
        {
            sortable: true,
            data: 'residual_1_risk_scale',
            name: 'residual_1_risk_scale',
            width: '100px',
        },
        {
            sortable: true,
            data: 'residual_2_risk_scale',
            name: 'residual_2_risk_scale',
            width: '100px',
        },
        {
            sortable: true,
            data: 'residual_3_risk_scale',
            name: 'residual_3_risk_scale',
            width: '100px',
        },
        {
            sortable: true,
            data: 'residual_4_risk_scale',
            name: 'residual_4_risk_scale',
            width: '100px',
        },
        {
            sortable: true,
            data: 'actual_risk_scale',
            name: 'actual_risk_scale',
            width: '100px',
        },
        {
            sortable: true,
            data: 'actual_risk_level',
            name: 'actual_risk_level',
            width: '100px',
        }
    ],
})

selectYear.addEventListener('change', e => {
    topRiskDatatable.draw()
})