$(function () {

    $('.header-toggle').on('click', function (e) {
        e.stopPropagation(); // Prevent the event from bubbling up to the document
        $('.sidebar, .overlay').toggleClass('show'); // Toggle class to show/hide sidebar
    });

});