import './bootstrap';
import "../../public/plugins/custom/iconify/iconify.min.js";

import.meta.glob([
    '../media/**',
])

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

