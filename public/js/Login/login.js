import { ajaxRequest } from "../global/ajax.js";

$(function () {
    console.log('document is ready!');

    $('#frmLogin').on('submit', function (e) {
        e.preventDefault();
        // console.log('clicked!');

        // Collect form data
        var loginData = {
            username: $('#username').val(),
            password: $('#password').val(),
            rememberMe: $('#rememberMe').is(':checked')
        };

        const url = $(this).attr('action');
        const loginUser = ajaxRequest(url, loginData);

        loginUser.then((response) => {
            if (!response.success) {
                console.error('Request error: ', response.message);
                return;
            }
            console.log(response);
        }).catch((error) => {
            console.error('Errors: ', error);
        });

    });
});