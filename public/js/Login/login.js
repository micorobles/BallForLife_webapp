import { ajaxRequest, showToast, togglePassword } from "../global/global-functions.js";

$(function () {
    console.log('document is ready!');

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
    const loginUser = await ajaxRequest(url, loginData);
    
    try {

        if (!loginUser.success) {
            showToast('error', 'Error: ', loginUser.message);
            console.error(loginUser.message);
            return;
        }

        showToast('success', '', loginUser.message);
        console.log(loginUser);

    } catch (error) {
        // Handle any errors that occurred during the AJAX request
        showToast('error', 'Error: ', 'An error occurred while processing your request from login.js.');
        console.error('Errors: ', error);
    };
}
