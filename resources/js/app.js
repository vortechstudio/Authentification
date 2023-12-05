import('@popperjs/core');
import './bootstrap';
import './scripts.bundle.js'
import './widgets.bundle.js'
import '../../vendor/aliqasemzadeh/livewire-bootstrap-modal/resources/js/modals.js';

import.meta.glob([
    '../media/**',
])

grecaptcha.ready(function () {
    if (grecaptcha.getResponse() === "") {
        alert("Please validate the Google reCaptcha.");
    } else {
        alert("Successful validation! Now you can submit this form to your server side processing.");
    }
});
