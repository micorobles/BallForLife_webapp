$(function () {
    // Get the current page URL
    const currentUrl = window.location.href;

    // Highlight the active link in the sidebar
    highlightActiveLink(currentUrl);

    // Handle submenu toggling
    $('.sidebar .nav > li > a').on('click', handleMenuClick);

    // Handle sidebar minify button click
    $('.sidebar-minify-btn').on('click', toggleSidebarMinify);

});

// Function to highlight the active link
function highlightActiveLink(url) {
    $('.sidebar .nav > li > a, .sidebar .nav .sub-menu > li > a').each(function () {
        if (this.href === url) {
            $(this).parent('li').addClass('active');

            // Expand submenu if the link is inside one
            if ($(this).closest('.sub-menu').length) {
                $(this).closest('.has-sub').addClass('expand');
                $(this).closest('.sub-menu').slideDown(0); // Ensure the submenu is visible
            }
        }
    });
}

// Function to handle menu item clicks
function handleMenuClick(e) {
    const $parentLi = $(this).parent('li');

    // Skip sidebar-minify button
    if ($(this).hasClass('sidebar-minify-btn')) {
        return;
    }

    if ($parentLi.hasClass('has-sub')) {
        e.preventDefault(); // Prevent default behavior for submenus
        toggleSubMenu($parentLi);
    } else {
        // Handle regular menu item clicks
        setActiveLink($parentLi);
    }
}

// Function to toggle the visibility of a submenu
function toggleSubMenu($parentLi) {
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
}

// Function to set the active link
function setActiveLink($parentLi) {
    $('.sidebar .nav > li').removeClass('active');
    $parentLi.addClass('active');
}

// Function to toggle sidebar minification
function toggleSidebarMinify() {
    $('body').toggleClass('page-sidebar-minified');
    $('.sidebar-minify-btn i').toggleClass('fa-angle-double-left fa-angle-double-right');
}

// Close all submenus when clicking on a regular menu item
$('.sidebar .nav > li > a').on('click', function () {
    if (!$(this).parent('li').hasClass('has-sub')) {
        closeAllSubMenus();
    }
});

// Function to close all submenus
function closeAllSubMenus() {
    $('.sidebar .has-sub').removeClass('expand').addClass('closed');
    $('.sub-menu').slideUp(300);
}
