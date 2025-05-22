import './custom';
import './menu';

const html = document.querySelector("html");
document.addEventListener('DOMContentLoaded', function () {
    html.setAttribute("loader", "enable");

    html.setAttribute("data-width", "fullwidth");
    html.setAttribute("data-header-position", "fixed");
    html.setAttribute("data-menu-position", "fixed");
})

window.addEventListener("DOMContentLoaded", () => {
    const loader = document.getElementById("loader");
    setTimeout(() => {
        loader.style.visibility = 'hidden';
        loader.style.opacity = '0';
        loader.style.transition = 'visibility 0s 1.365s, opacity 1.365s linear';
    }, 665);
});