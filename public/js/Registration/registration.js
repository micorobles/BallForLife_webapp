import { ajaxRequest, showToast, togglePassword } from "../global/global-functions.js";

$(function () {

    // Bind form submission
    $('#frmRegister').on('submit', handleRegistration);

    // Bind password toggle
    $('#show_hide_password a').on('click', togglePassword);

});


async function handleRegistration(e) {
    e.preventDefault();

    const password = $('#password').val();
    const confirmPassword = $('#confirm-password').val();

    if (password !== confirmPassword) {
        showToast('warning', 'Warning: ', 'Password mismatch');
        return;
    }

    const registrationData = {
        email: $('#email').val(),
        firstname: $('#firstname').val(),
        lastname: $('#lastname').val(),
        contactNum: $('#contactNum').val(),
        password: password,
    };

    const url = $(this).attr('action');
    const registerUser = await ajaxRequest('POST', url, registrationData);

    try {

        if (!registerUser.success) {
            showToast('error', 'Error: ', registerUser.message);
            return;
        }

        showToast('success', '', registerUser.message);
        console.log(registerUser);

        // Redirect after 2 seconds (2000 milliseconds)
        setTimeout(function () {
            window.location.href = window.location.origin + '/';
        }, 2000);

    } catch (error) {
        // Handle any errors that occurred during the AJAX request
        showToast('error', 'Error: ', 'An error occurred while processing your request.');
        console.error('Errors: ', error);
    }

}