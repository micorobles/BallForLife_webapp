<?= $this->extend('templates/layout'); ?>

<?= $this->section('css'); ?>

<?= load_css('global.css'); ?>

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<div class="container-fluid row">
    <ul>
        <li><h1>TEST PAGE</h1></li>
        <li><h1><?= $username ?></h1></li>
        <li><h1><?= $password ?></h1></li>
    </ul>


</div>

<?= $this->endSection(); ?>