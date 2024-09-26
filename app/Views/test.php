<?= $this->extend('templates/layout'); ?>

<?= $this->section('css'); ?>

<?= load_css('global.css'); ?>

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

    <div class="container-fluid row">
        <h1>TEST PAGE</h1>
    </div>
    
<?= $this->endSection(); ?>