import axios from 'axios';
import { Modal } from 'bootstrap';
import Swal from 'sweetalert2';

const monitoringProgressTable = document.querySelector('#progress-monitoring-table')
const monitoringProgressChildModalElement = document.querySelector('#monitoring-progress-chid-modal');
const monitoringProgressChildModal = new Modal(monitoringProgressChildModalElement);
const monitoringProgressChildModalTitle = monitoringProgressChildModalElement.querySelector('.modal-title');
const monitoringProgressChildTable = monitoringProgressChildModalElement.querySelector('#monitoring-progress-chid-table');
const monitoringProgressChildTableBody = monitoringProgressChildTable.querySelector('tbody');

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
    const unitsColumn = monitoringProgressTable.querySelectorAll('.units');
    unitsColumn.forEach(column => {
        if (column.hasAttribute('data-unit')) {
            column.addEventListener('click', async e => {
                Swal.fire({
                    title: 'Sedang memproses...',
                    allowOutsideClick: false,
                    didOpen: async () => {
                        Swal.showLoading(); // Show loading indicator
                        const param = new URLSearchParams()
                        param.append('unit', column.getAttribute('data-unit'));

                        const response = await axios.get(new URL('/analytics/monitoring-progress-child', window.location.origin).href + '?' + param.toString());
                        const data = response.data;

                        if (response.status == 200) {
                            Swal.close();

                            data.data.forEach(item => {
                                const row = document.createElement('tr')
                                const column = document.createElement('td')
                                column.innerHTML = item.name
                                row.append(column)

                                item.month.forEach(value => {
                                    const column = document.createElement('td')
                                    column.innerHTML = value ? parseInt(value) + '%' : '0%'

                                    if (value >= 75) {
                                        column.classList.add('bg-success-transparent')
                                    } else if (value >= 40) {
                                        column.classList.add('bg-warning-transparent')
                                    }

                                    row.append(column)
                                })

                                monitoringProgressChildTableBody.append(row)
                            })

                            monitoringProgressChildModal.show()
                        } else {
                            Swal.fire({
                                icon: 'error',
                                text: data.message
                            })
                        }
                    }
                });

                monitoringProgressChildModal.show()
                monitoringProgressChildModalTitle.textContent = 'Monitoring Progress ' + column.innerHTML
            })
        }
    })

    monitoringProgressChildModalElement.addEventListener('hide.bs.modal', () => {
        monitoringProgressChildTableBody.innerHTML = ''
    })
}