$(function () {

     // Bind logout
    $('#btnLogout').on('click', handleLogout);

    $('.header-toggle').on('click', function (e) {
        e.stopPropagation(); // Prevent the event from bubbling up to the document
        $('.sidebar, .overlay').toggleClass('show'); // Toggle class to show/hide sidebar
    });

});

function handleLogout(e) {
    e.preventDefault();

    // Set the cookie's expiration date to a time in the past to expire
    document.cookie = `authToken=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/;`;

    window.location.href = window.location.origin + '/';
}