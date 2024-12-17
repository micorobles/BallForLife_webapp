<?php

use CodeIgniter\HTTP\URI;

if (!function_exists('generate_breadcrumbs')) {
    function generate_breadcrumbs() {
        // Get the current URI instance
        $uri = service('uri'); // Use CodeIgniter's service helper for URI
        $segments = $uri->getSegments(); // Get the URL segments

        // Base URL for breadcrumbs
        $baseUrl = base_url();

        // Initialize breadcrumbs array
        $breadcrumbs = [];
        $breadcrumbUrl = $baseUrl; // Start with the base URL

        // Iterate through segments to create breadcrumb items
        foreach ($segments as $segment) {
            $breadcrumbUrl .= '/' . $segment; // Create the full URL

            // Add to breadcrumbs array
            $breadcrumbs[] = [
                'title' => ucfirst($segment), // Capitalize the segment
                'url' => $breadcrumbUrl // Full URL for the breadcrumb link
            ];
        }

        return $breadcrumbs;
    }
}
