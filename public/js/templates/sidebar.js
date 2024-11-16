$(function () {

    const Sidebar = function () {
        return new Sidebar.init();
    }
    Sidebar.init = function () {
        
    }
    Sidebar.prototype = {
        highlightActiveLink: function (url) {
            var self = this;
            $('.sidebar .nav > li > a, .sidebar .nav .sub-menu > li > a').each(function () {
                if (this.href === url) {
                    $(this).parent('li').addClass('active');

                    // Expand submenu if the link is inside one
                    if ($(this).closest('.sub-menu').length) {
                        $(this).closest('.has-sub').addClass('expand');
                        $(this).closest('.has-sub').addClass('active');
                        $(this).closest('.sub-menu').slideDown(0); // Ensure the submenu is visible
                    }
                }
            });

            return this;
        },
        handleClickOutside: function (e) {
            var self = this;

            // Check if the sidebar is open and the click is outside the sidebar and toggle button
            if ($('#sidebar').hasClass('show') && !$(e.target).closest('#sidebar, .header-toggle').length) {
                $('#sidebar').removeClass('show'); // Hide sidebar
                $('.overlay').removeClass('show'); // Hide overlay (optional)
            }

            return this;
        },
        handleMenuClick: function (e) {
            var self = this;

            const $parentLi = $(e).parent('li');

            // Skip sidebar-minify button
            if ($('body').hasClass('sidebar-minify-btn')) {
                return;
            }

            // console.log(self, e, $parentLi);
            if ($parentLi.hasClass('has-sub')) {
                // e.preventDefault(); // Prevent default behavior for submenus
                self.toggleSubMenu($parentLi);
            } else {
                // Handle regular menu item clicks
                self.setActiveLink($parentLi);
            }

            return this;
        },
        toggleSidebarMinify: function () {
            var self = this;

            $('body').toggleClass('page-sidebar-minified');
            $('.sidebar-minify-btn i').toggleClass('fa-angle-double-left fa-angle-double-right');

            return this;
        },
        toggleSubMenu: function ($parentLi) {
            var self = this;

            const $submenu = $parentLi.find('.sub-menu');

            if ($submenu.is(':visible')) {
                $parentLi.removeClass('expand').addClass('closed');
                $submenu.slideUp(300);
            } else {
                // Close other open submenus
                $('.sidebar .nav > li.has-sub').not($parentLi).removeClass('expand').addClass('closed');
                $('.sidebar .nav > li.has-sub').not($parentLi).find('.sub-menu').slideUp(300);

                // Open the clicked submenu
                $parentLi.removeClass('closed').addClass('expand');
                $submenu.slideDown(300);
            }

            return this;
        },
        setActiveLink: function ($parentLi) {
            var self = this;

            $('.sidebar .nav > li').removeClass('active');
            $parentLi.addClass('active');

            return this;
        },
        closeAllSubMenus: function () {
            var self = this;
            
            $('.sidebar .has-sub').removeClass('expand').addClass('closed');
            $('.sub-menu').slideUp(300);

            return this;
        }
    }

    Sidebar.init.prototype = Sidebar.prototype;

    $(document).ready(function () {
        var _S = Sidebar();
        
        // Get the current page URL
        const currentUrl = window.location.href;

        // Highlight the active link in the sidebar
        _S.highlightActiveLink(currentUrl);

        // Handle submenu toggling
        $('.sidebar .nav > li > a').on('click', function(e) {
            // e.preventDefault();
            _S.handleMenuClick(this);
            
        });

        // Handle sidebar minify button click
        $('.sidebar-minify-btn').on('click', _S.toggleSidebarMinify);

        // Handle breadcrumb clicks
        $('.breadcrumb-item a').on('click', function (e) {
            e.preventDefault(); // Prevent default anchor behavior
            const breadcrumbUrl = this.href; // Get the URL from the clicked breadcrumb
            _S.highlightActiveLink(breadcrumbUrl); // Highlight the corresponding sidebar link
            window.location.href = breadcrumbUrl; // Redirect to the clicked breadcrumb URL
        });

        $('.sidebar .nav > li > a').on('click', function () {
            if (!$(this).parent('li').hasClass('has-sub')) {
                _S.closeAllSubMenus();
            }
        });

        // Close sidebar if clicked outside
        $(document).on('click', function(e) {
            // e.preventDefault();
            _S.handleClickOutside(e);
        });
    });
});