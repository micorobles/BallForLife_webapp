<?= $this->extend('templates/layout'); ?>

<!-- ADDITIONAL CSS -->

<?= $this->section('css'); ?>


<?= $this->endSection(); ?>

<!-- BODY CONTENT -->

<?= $this->section('content'); ?>

<h1>SCHEDULE CONTENT</h1>

<?= $this->endSection(); ?>

<!-- ADDITIONAL JS -->

<?= $this->section('js'); ?>

<?= load_js('global/global-functions.js'); ?>

<?= $this->endSection(); ?>