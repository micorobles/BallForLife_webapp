import { ajaxRequest, showToast, togglePassword } from "../global/global-functions.js";

"use strict";
$(function () {
    const Registration = function () {
        return new Registration.init();
    }
    Registration.init = function () {
        this.frmID = '#frmRegister';
    }
    Registration.prototype = {
        registerUser: async function () {
            var self = this;

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

            const url = $(self.frmID).attr('action');
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

            return this;
        }
    }

    Registration.init.prototype = Registration.prototype;

    $(document).ready(function () {
        var _R = Registration();

        $('#frmRegister').parsley();

        // Bind form submission
        $('#frmRegister').on('submit', function (e) {
            e.preventDefault();
            _R.registerUser();
        });

        // Bind password toggle
        $('#show_hide_password a').on('click', togglePassword);
    });
});
