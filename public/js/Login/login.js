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

        // Store token in local storage
        localStorage.setItem('authToken', loginUser.token);
        console.log(loginUser);

        // AJAX redirection to homepage
        $.ajax({
            url: window.location.origin + '/homepage',
            type: 'GET',
            headers: {
                'Authorization': 'Bearer ' + loginUser.token,
            },
            cache: false,
            success: function (response) {
                 // Handle the successful response
                 if (response.success) {
                    // Update the window URL and prevent re-sending of the token
                    window.location.href = window.location.origin + '/homepage';
                } else {
                    showToast('error', 'Error: ', response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Failed to load homepage:', error);
                showToast('error', 'Error: ', 'Failed to load homepage. Please try again.');
            }
        });

        // window.location.href = window.location.origin + '/homepage';

    } catch (error) {
        // Handle any errors that occurred during the AJAX request
        showToast('error', 'Error: ', 'An error occurred while processing your request from login.js.');
        console.error('Errors: ', error);
    };
}
