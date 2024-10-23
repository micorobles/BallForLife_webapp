
export function ajaxRequest(type, url, data, options = {}) {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: type,
            url: url,
            data: data,
            ...options,
            dataType: 'json',
            beforeSend: function() {
                $('#loader').show();
            },
            success: function (response) {
                resolve(response);
                $('#loader').fadeOut(300);
            },
            error: function (xhr, status, error) {
                // reject(xhr, status, error);
                reject(new Error(`AJAX error: ${xhr.status} - ${xhr.statusText}`));
            }
        })
    })
}

export function showToast(type, title, message) {
    iziToast[type]({
        title: title,
        message: message,
    });
}

export function togglePassword(e) {
    e.preventDefault();

    // const passwordField = $('#show_hide_password input');
    // const eyeIcon = $('#show_hide_password a i')

    // Target the closest input field and eye icon when clicked
    const passwordField = $(this).closest('.input-group').find('input');
    const eyeIcon = $(this).find('i');
    
    const isTextType = passwordField.attr('type') === 'text';

    passwordField.attr('type', isTextType ? 'password' : 'text');
    eyeIcon.toggleClass("fa-eye-slash", isTextType);
    eyeIcon.toggleClass("fa-eye", !isTextType);
}

iziToast.settings({
    timeout: 3000,               // Duration in milliseconds
    resetOnHover: true,          // Reset timeout when hovering
    position: 'topRight',        // Default position
    transitionIn: 'bounceInDown',     // Default animation for showing
    transitionOut: 'fadeOutRight',   // Default animation for hiding
    progressBar: true,           // Show progress bar
    onOpening: function () {
        // console.log('Toast is opening');
    },
    onClosing: function () {
        // console.log('Toast is closing');
    }
});

export function ucfirst(str) {
    if (!str) return str;
    return str.charAt(0).toUpperCase() + str.slice(1);
}