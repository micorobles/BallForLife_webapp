<?= $this->extend('templates/layout'); ?>

<!-- ADDITIONAL CSS -->

<?= $this->section('css'); ?>


<?= $this->endSection(); ?>

<!-- BODY CONTENT -->

<?= $this->section('content'); ?>

<div class="container-fluid min-vh-100 min-vw-100 d-flex justify-content-center align-items-center bg-primary text-white">
    <div class="container bg-secondary w-25 rounded p-3">
        <div class="row">
            <div class="col-lg-2 col-md-4 order-2 border d-flex align-items-center">
                <i class="fa-solid fa-basketball fa-3x"></i>
            </div>
            <div class="col-lg-10 col-md-8 order-3 border p-0">
                <!-- <div class="row">
                    <div class="col-12 border">
                        <span class="font-xxl" style="line-height: 1;"><strong>Ball</strong> For Life</span>
                    </div>
                    <div class="col-12 border">
                        <span class="font-md text-secondary mt-0">A life in <strong>Ball</strong>-ance</span>
                    </div>
                </div> -->
                <ul style="list-style-type:none; padding:0; margin:0;">
                    <li><span class="font-xxl" style="line-height: 1;"><strong>Ball</strong> For Life</span></li>
                    <li> <span class="font-md text-secondary mt-0">A life in <strong>Ball</strong>-ance</span></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-2 order-1 offset-md-10 border d-flex justify-content-end">
                <i class="fa-solid fa-lock fa-1x"></i>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<!-- ADDITIONAL JS -->

<?= $this->section('js'); ?>

<?= load_js('Login/login.js'); ?>

<?= $this->endSection(); ?>