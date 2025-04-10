import axios from 'axios';
import 'bootstrap';
import './themes/main';
import '@tabler/icons-webfont/dist/tabler-icons.min.css';
import Swal from 'sweetalert2';
import Choices from 'choices.js';
import { defaultConfigChoices } from './components/helper';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

window.alert_message = (state, title, message) => {
    state = state == 'danger' ? 'error' : state
    Swal.fire({
        icon: state,
        title: title,
        text: message,
    })
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('#role-select').addEventListener('change', (e) => {
        axios.post('/change-role', { role: e.target.value })
            .then(response => {
                window.location.reload();
            });
    });

    const changeUnitForm = document.querySelector('#changeUnitForm')
    const changeUnitSelect = changeUnitForm.querySelector('select[name="unit_target"]')
    new Choices(changeUnitSelect, defaultConfigChoices)

});

