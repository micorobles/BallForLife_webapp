export function ajaxRequest(url, data) {
    return new Promise ((resolve, reject) => {
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            dataType: 'json',
            success: function(response) {               
                resolve(response);
            },
            error: function(xhr, status, error) {
                reject(xhr, status, error);
            }
        })
    })
}