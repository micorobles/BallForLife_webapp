<?= $this->extend('templates/layout'); ?>

<!-- ADDITIONAL CSS -->

<?= $this->section('css'); ?>

<?= load_css('Homepage/homepage.css') ?>

<?= $this->endSection(); ?>

<!-- BODY CONTENT -->

<?= $this->section('content'); ?>

<div class="header-container d-flex justify-content-end">
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url(); ?>">Home</a>
    </li>
    <?php
    $breadcrumbs = generate_breadcrumbs(); // Get the breadcrumbs
    $last_index = count($breadcrumbs) - 1; // Get the index of the last breadcrumb

    foreach ($breadcrumbs as $index => $breadcrumb) {
        if ($index === $last_index) {
            // If it's the last breadcrumb, display it as plain text
            echo '<li class="breadcrumb-item active" aria-current="page"><a href="javascript:;"> ' . esc($breadcrumb['title']) . '</a></li>';
        } else {
            echo '<li class="breadcrumb-item"><a href="' . esc($breadcrumb['url']) . '">' . esc($breadcrumb['title']) . '</a></li>';
        }
    }
    ?>
</ol>
</div>

<div class="panel border">
    <div class="panel-header">

        <span class="page-header regular-text">Homepage</span>
    </div>
    <div class="panel-body">
        Panel body
    </div>
</div>

<!-- <h1>Content area</h1>
    <h2>Content area</h2>
    <h3>Content area</h3>
    <h4>Content area</h4>
    <h5>Content area</h5>
    <h6>Content area</h6> -->



<?= $this->endSection(); ?>

<!-- ADDITIONAL JS -->

<?= $this->section('js'); ?>

<?= load_js('global/global-functions.js'); ?>
<?= load_js('Homepage/homepage.js'); ?>

<?= $this->endSection(); ?>