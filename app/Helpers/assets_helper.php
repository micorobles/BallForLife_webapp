<?php

if (!function_exists('load_bundle_css')) {
    function load_bundle_css()
    {
        return '
            <link rel="stylesheet" href="' . base_url('css/global/bootstrap.min.css') . '">
            <link rel="stylesheet" href="' . base_url('css/global/global-styles.css') . '">
            <link rel="stylesheet" href="' . base_url('css/global/iziToast.min.css') . '">
            <link rel="stylesheet" href="' . base_url('css/global/select2.min.css') . '">
            <link rel="stylesheet" href="' . base_url('css/templates/header.css') . '">
            <link rel="stylesheet" href="' . base_url('css/templates/sidebar.css') . '">
            
        ';
    }
}

if (!function_exists('load_bundle_js')) {
    function load_bundle_js()
    {
        return '
            <script src="' . base_url('js/global/jquery-3.7.1.min.js') . '" crossorigin="anonymous"></script>
            <script src="' . base_url('js/global/bootstrap.bundle.min.js') . '" crossorigin="anonymous"></script>
            <script src="https://kit.fontawesome.com/9ee5e62459.js" crossorigin="anonymous"></script>
            <script src="' . base_url('js/global/iziToast.min.js') . '" crossorigin="anonymous"></script>
            <script src="' . base_url('js/global/select2.min.js') . '" crossorigin="anonymous"></script>
            <script type="module" src="' . base_url('js/global/global-functions.js') . '" crossorigin="anonymous"></script>
            <script src="' . base_url('js/templates/sidebar.js') . '" crossorigin="anonymous"></script>
            <script src="' . base_url('js/templates/header.js') . '" crossorigin="anonymous"></script>
        ';
    }
}

if (!function_exists('load_css')) {
    function load_css($filename)
    {
        return '<link rel="stylesheet" href="' . base_url("css/$filename") . '">';
    }
}

if (!function_exists('load_js')) {
    function load_js($filename)
    {
        return '<script type="module" src="' . base_url("js/$filename") . '"></script>';
    }
}
