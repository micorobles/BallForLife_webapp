
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
                reject(new Error(`AJAX error: ${xhr.status} - ${xhr.statusText} - ${error}`));
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

export var isIziToastActive = false;

export function showQuestionToast({ title, message, onYes, onNo }) {
    
    iziToast.question({
        timeout: 20000,
        close: false,
        overlay: true,
        displayMode: 'once',
        id: 'question',
        zindex: 999999,
        title: title || 'Confirm',  // Default title if not provided
        message: message,
        position: 'center',
        buttons: [
            ['<button><b>YES</b></button>', async function (instance, toast) {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                // Call the onYes callback when "Yes" is clicked
                if (typeof onYes === 'function') {
                    await onYes(instance, toast);
                }
                isIziToastActive = false;  
            }, true],
            ['<button>NO</button>', function (instance, toast) {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                // Call the onNo callback when "No" is clicked
                if (typeof onNo === 'function') {
                    onNo(instance, toast);
                }
            }],
        ],
        onOpening: function() {
            isIziToastActive = true; // Set flag to true when iziToast is shown
        },
        onClosing: function() {
            isIziToastActive = false;  // Reset flag when iziToast is hidden
        }
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

// Population helper

export function setTextIfExists(selector, text) {
    const element = $(selector);
    if (element.length) {
        element.text(text);
    }
}

export function setValueIfExists(selector, value) {
    const element = $(selector);
    if (element.length) {
        element.val(value);
    }
}

export function setSrcIfExists(selector, src) {
    const element = $(selector);
    if (element.length) {
        element.attr('src', src);
    }
}

export function clearSelectIfExists(selector) {
    const element = $(selector);
    if (element.length) {
        element.empty();
    }
}

export function addOptionsIfExists(selector, options, selectedOptions = []) {
    const element = $(selector);
    if (element.length) {
        options.forEach(option => {
            const selected = selectedOptions.includes(option) ? 'selected' : '';
            element.append(`<option value="${option}" ${selected}>${option}</option>`);
        });
    }
}

