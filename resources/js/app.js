import axios from 'axios';
import './bootstrap';
import './themes/main';
import '@tabler/icons-webfont/dist/tabler-icons.min.css';

document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('#role-select').addEventListener('change', (event) => {
        axios.post('/', { role: event.target.value })
            .then(response => {
                window.location.reload();
            });
    });
});