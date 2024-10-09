$(function () {
    console.log('document is ready!');

    // Bind logout
    $('#btnLogout').on('click', handleLogout);

});

function handleLogout(e) {
    e.preventDefault();

    // Set the cookie's expiration date to a time in the past to expire
    document.cookie = `authToken=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/;`;

    window.location.href = window.location.origin + '/';
}