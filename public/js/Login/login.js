import { ajaxRequest, showToast, togglePassword } from "../global/global-functions.js";

$(function () {
    console.log('document is ready!');

    $('#frmLogin').parsley();

    // Get flash data if auth fails
    const flashMessage = $('#flash-data').text().trim() ?? '';

    if (flashMessage !== '') {
        showToast('error', 'Error: ', flashMessage);
    }

    // Bind form submission
    $('#frmLogin').on('submit', handleLogin);

    // Bind password toggle
    $('#show_hide_password a').on('click', togglePassword);


    function onSignIn(googleUser) {
        const id_token = googleUser.credential;
    
        console.log('ID TOKEN: ', id_token);
    
        // Send the ID token to your server for verification using jQuery
        $.ajax({
            url: baseURL + '/google',
            type: 'POST',
            data: { id_token: id_token },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            success: function (response) {
                if (response.success) {
                    console.log('response: ', response);
                    document.cookie = `authToken=${response.data}; path=/; max-age=3600`;

                    window.location.href = baseURL + '/homepage'; 
                    
                } else {
                    console.error("Failed to login with Google: ", response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("Failed to login with Google: ", error);
            },
        });
    }
    
    function loadGoogleAPI(callback) {
        if (typeof google === "undefined") {
            const script = document.createElement('script');
            script.src = "https://accounts.google.com/gsi/client";
            script.async = true;
            script.defer = true;
            script.onload = callback; // Call the callback when the script loads
            document.body.appendChild(script);
        } else {
            callback(); // If google is already defined, directly call the callback
        }
    }
    
    // Initialize Google Sign-In
    function startApp() {
        loadGoogleAPI(function() {
            // Google Sign-In Initialization
            google.accounts.id.initialize({
                client_id: '242089388933-osq14fn5jc01gpu49d13a90546ghs5g7.apps.googleusercontent.com', // Replace with your Google client ID
                callback: onSignIn,
            });
    
            // Render the Google Sign-In button
            google.accounts.id.renderButton(
                $('#googleSignInBtn')[0], // Use jQuery to select the element and get the DOM node
                {
                    theme: 'outline',
                    size: 'large',
                    width: 370,
                }
            );
        });
    }

    $(document).ready(function() {
        startApp();
    });
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

        document.cookie = `authToken=${loginUser.data}; path=/; max-age=3600`;
        window.location.href = window.location.origin + '/homepage';

    } catch (error) {
        // Handle any errors that occurred during the AJAX request
        showToast('error', 'Error: ', 'An error occurred while processing your request from login.js.');
        console.error('Errors: ', error);
    };
}
