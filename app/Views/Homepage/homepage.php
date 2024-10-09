<?= $this->extend('templates/layout'); ?>

<!-- ADDITIONAL CSS -->

<?= $this->section('css'); ?>

<?= load_css('Login/login.css') ?>

<?= $this->endSection(); ?>

<!-- BODY CONTENT -->

<?= $this->section('content'); ?>

<div
    class="container-fluid min-vh-100 min-vw-100 d-flex flex-column justify-content-center align-items-center bg-primary text-white">
    <div class="container mb-3 d-flex justify-content-center" style="max-width: 400px;">
        
        <div class="row mt-2">
            <div class="col">
                <button id='btnLogout' class="btn btn-custom-color btn-block mt-4 text-white" >Logout</button>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>

<!-- ADDITIONAL JS -->

<?= $this->section('js'); ?>

<?= load_js('global/global-functions.js'); ?>
<?= load_js('Homepage/homepage.js'); ?>

<?= $this->endSection(); ?>