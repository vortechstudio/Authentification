import './bootstrap';
import "../../public/plugins/custom/iconify/iconify.min.js";
import "bootstrap/dist/js/bootstrap.js";
import "bootstrap-select/dist/js/bootstrap-select.js";

import.meta.glob([
    '../media/**',
])

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

