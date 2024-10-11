<?= $this->extend('templates/layout'); ?>

<!-- ADDITIONAL CSS -->

<?= $this->section('css'); ?>

<?= load_css('Homepage/homepage.css') ?>

<?= $this->endSection(); ?>

<!-- BODY CONTENT -->

<?= $this->section('content'); ?>
<div class="content">
    <h1>Content area</h1>
    <h2>Content area</h2>
    <h3>Content area</h3>
    <h4>Content area</h4>
    <h5>Content area</h5>
    <h6>Content area</h6>
</div>


<?= $this->endSection(); ?>

<!-- ADDITIONAL JS -->

<?= $this->section('js'); ?>

<?= load_js('global/global-functions.js'); ?>
<?= load_js('Homepage/homepage.js'); ?>

<?= $this->endSection(); ?>