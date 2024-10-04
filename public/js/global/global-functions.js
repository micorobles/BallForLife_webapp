
export function ajaxRequest(url, data) {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            dataType: 'json',
            success: function (response) {
                resolve(response);
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