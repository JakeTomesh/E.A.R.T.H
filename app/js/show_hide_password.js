"use strict";

const getElement = document.getElementById.bind(document);
const togglePassword = getElement('toggle_password');
const passwordReset = getElement('reset_password');
const passwordConfirm = getElement('confirm_password');

document.addEventListener('DOMContentLoaded', () => {
    togglePassword.addEventListener('change', togglePasswordVisibility);
});

function togglePasswordVisibility() {

    const type = passwordReset.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordReset.setAttribute('type', type);
    passwordConfirm.setAttribute('type', type);
}