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
        verifyEmail: async function () {
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

            console.log('REGISTRATION DATA: ', registrationData);

            const url = $(self.frmID).attr('action');

            console.log('URL: ', url);
            
            const verifyEmail = await ajaxRequest('POST', url, registrationData);


            try {

                if (!verifyEmail.success) {
                    showToast('error', 'Error: ', verifyEmail.message);
                    return;
                }

                // showToast('success', '', verifyEmail.message);
                console.log(verifyEmail);
                self.renderOtpModal(verifyEmail);

                // Redirect after 2 seconds (2000 milliseconds)
                // setTimeout(function () {
                //         window.location.href = window.location.origin + '/';
                // }, 2000);

            } catch (error) {
                // Handle any errors that occurred during the AJAX request
                showToast('error', 'Error: ', 'An error occurred while processing your request.');
                console.error('Errors: ', error);
            }

            return this;
        },
        verifyOTP: async function () {
            var self = this;

            const registerUrl = $('#frmOTP').attr('action');
            let formData = new FormData($('#frmOTP')[0]);

            // for (let [key, value] of formData.entries()) {
            //     console.log(key, value);
            // }

            const registerUser = await ajaxRequest('POST', registerUrl, formData, {
                contentType: false,
                processData: false,
            }).catch(function (error) {
                console.error("AJAX error response:", error.responseText); // Log the response from the server
                throw error;  // Rethrow the error after logging
            });


            
            if (!registerUser.success) {
                showToast('error', 'Error: ', registerUser.message);
                $('#VerificationModal').modal('hide');
                return;
            }

            showToast('success', '', registerUser.message);
            console.log(registerUser);
            // Redirect after 2 seconds (2000 milliseconds)
            setTimeout(function () {
                window.location.href = window.location.origin + '/';
            }, 2000)

            return this;
        },
        renderOtpModal: function (data) {
            var self = this;

            let email = data.data;

            $('#VerificationModal').modal('show');
            $('.description').text(data.message);
            $('#modal-email').val(email);

            return this;
        }
    }

    Registration.init.prototype = Registration.prototype;

    $(document).ready(function () {
        var _R = Registration();

        $('#frmRegister').parsley();
        var prslyFrmOTP = $('#frmOTP').parsley();

        // Bind form submission
        $('#frmRegister').on('submit', function (e) {
            e.preventDefault();
            _R.verifyEmail();
        });

        $('#btnVerifyOtp').on('click', function (e) {
            e.preventDefault();
            console.log('clicked');

            prslyFrmOTP.isValid() ? _R.verifyOTP() : prslyFrmOTP.validate({ focus: 'first' });
        });

        // Bind password toggle
        $('#show_hide_password a').on('click', togglePassword);

        $('#VerificationModal').on('hidden.bs.modal', function () {
            // Reset the form
            $('#frmOTP')[0].reset();

        });
    });
});
