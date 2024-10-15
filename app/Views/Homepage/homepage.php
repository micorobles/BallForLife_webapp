<?= $this->extend('templates/layout'); ?>

<!-- ADDITIONAL CSS -->

<?= $this->section('css'); ?>

<?= load_css('Homepage/homepage.css') ?>

<?= $this->endSection(); ?>

<!-- BODY CONTENT -->

<?= $this->section('content'); ?>

<div class="panel border">
    <div class="panel-header">
        <span class="page-header regular-text">Homepage</span>
    </div>
    <div class="panel-body">
        Panel body
    </div>
</div>

<?= $this->endSection(); ?>

<!-- ADDITIONAL JS -->

<?= $this->section('js'); ?>

<?= load_js('global/global-functions.js'); ?>
<?= load_js('Homepage/homepage.js'); ?>

<?= $this->endSection(); ?>