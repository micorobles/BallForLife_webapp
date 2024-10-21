import { ajaxRequest, showToast, togglePassword } from "../global/global-functions.js";

$(function () {
    console.log('document is ready!');

    // Get flash data if auth fails
    const flashMessage = $('#flash-data').text().trim() ?? '';
    
    if (flashMessage !== '') {
        showToast('error', 'Error: ', flashMessage);
    }
        

    // Bind form submission
    $('#frmLogin').on('submit', handleLogin);

    // Bind password toggle
    $('#show_hide_password a').on('click', togglePassword);


});

async function handleLogin(e) {
    e.preventDefault();

    // Collect form data
    const loginData = {
        email: $('#email').val(),
        password: $('#password').val().trim(),
        rememberMe: $('#rememberMe').is(':checked')
    };

    const url = $(this).attr('action');
    const loginUser = await ajaxRequest('POST', url, loginData);

    try {

        if (!loginUser.success) {
            showToast('error', 'Error: ', loginUser.message);
            console.error(loginUser.message);
            return;
        }

        // showToast('success', '', loginUser.message);

        // Store token in local storage
        console.log(loginUser);

        document.cookie = `authToken=${loginUser.token}; path=/; max-age=3600`;
        window.location.href = window.location.origin + '/homepage';

    } catch (error) {
        // Handle any errors that occurred during the AJAX request
        showToast('error', 'Error: ', 'An error occurred while processing your request from login.js.');
        console.error('Errors: ', error);
    };
}
