"use strict";
$(function () {
    const Header = function () {
        return new Header.init();
    }
    Header.init = function () {
        // this.profilePicIds = [
        //     { id: '#header-profilePic', name: 'header' },
        //     { id: '#sidebar-profilePic', name: 'sidebar' },
        // ];
    }
    Header.prototype = {
        // renderProfilePictures: function () {
        //     var self = this;

        //     $.each(self.profilePicIds, function (index, image) {
        //         let imgSrc = $(image.id).attr('data-src');

        //         if (imgSrc && !/^https?:\/\//i.test(imgSrc)) {
        //             // If it's a relative URL, prepend the baseURL
        //             imgSrc = baseURL + imgSrc;
        //         }

        //         $(image.id).attr('src', imgSrc);
        //         // console.log(`${image.name}: `, imgSrc);
        //     });

        //     return this;
        // },
        handleLogout: function () {
            // Set the cookie's expiration date to a time in the past to expire
            document.cookie = `authToken=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/;`;

            window.location.href = window.location.origin + '/';

            return this;
        },
    }

    Header.init.prototype = Header.prototype;

    $(document).ready(function () {
        var _Header = Header();

        // _Header.renderProfilePictures();

        // Bind logout
        $('#btnLogout').on('click', _Header.handleLogout);

        $('.header-toggle').on('click', function (e) {
            e.stopPropagation(); // Prevent the event from bubbling up to the document
            $('.sidebar, .overlay').toggleClass('show'); // Toggle class to show/hide sidebar
        });
    });
});
