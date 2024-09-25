<?= $this->extend('templates/layout'); ?>

<?= $this->section('css'); ?>

<link rel="stylesheet" href="<?= base_url('css/global.css');?>">

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

    <div class="container">
        <h1>TEST PAGE</h1>
    </div>
    
<?= $this->endSection(); ?>