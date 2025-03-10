import axios from 'axios';
import 'bootstrap';
import './themes/main';
import '@tabler/icons-webfont/dist/tabler-icons.min.css';
import Swal from 'sweetalert2';

window.alert_message = (state, title, message) => {
    state = state == 'danger' ? 'error' : state
    Swal.fire({
        icon: state,
        title: title,
        text: message,
    })
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('#role-select').addEventListener('change', (event) => {
        axios.post('/', { role: event.target.value })
            .then(response => {
                window.location.reload();
            });
    });

});

