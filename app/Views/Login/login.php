<?= $this->extend('templates/layout'); ?>

<!-- ADDITIONAL CSS -->

<?= $this->section('css'); ?>

<?= load_css('Login/login.css')?>

<?= $this->endSection(); ?>

<!-- BODY CONTENT -->

<?= $this->section('content'); ?>

<!-- Embed flash data in HTML -->
<div id="flash-data" class="d-none"><?= session()->getFlashdata('authMessage') ?></div>

<div class="container-fluid min-vh-100 min-vw-100 d-flex justify-content-center align-items-center bg-primary text-white">
    <div class="container bg-secondary rounded p-3" style="max-width: 400px;">
        <div class="row">
            <div class="col-2 offset-10  d-flex justify-content-end">
                <i class="fa-solid fa-lock fa-1x"></i>
            </div>
            <div class="col-2 d-flex align-items-center">
                <i class="fa-solid fa-basketball fa-3x"></i>
            </div>
            <div class="col-10  d-flex ">
                <ul style="list-style-type:none; padding:0; margin:0;">
                    <li><span class="font-xxl regular-text" style="line-height: 1;"><span class="semi-bold-text">Ball</span> For Life</span></li>
                    <li> <span class="font-sm text-secondary mt-0 light-text">A life in <strong>Ball</strong>-ance</span></li>
                </ul>
            </div>
        </div>
        <form id="frmLogin" class="font-xs" action="<?= base_url('login') ?>" method="post" data-parsley-validate>
            <div class="input-group has-validation mt-4">
                <div class="input-group-prepend">
                    <span class="input-group-text font-md">@</span>
                </div>
                <input id="email" name="email" type="email" class="form-control" placeholder="name@example.com" required data-parsley-trigger="change" data-parsley-type="email" data-parsley-errors-container="#err-email" >
                <div id="err-email" class="errMsg mb-4">

                </div>
            </div>
            <div id="show_hide_password" class="input-group has-validation">
                <div class="input-group-prepend">
                    <span class="input-group-text font-md">*</span>
                </div>
                <input id="password" name="password" type="password" class="form-control" placeholder="********" required data-parsley-trigger="change" data-parsley-minlength="8" data-parsley-errors-container="#err-password">
                <div class="input-group-addon d-flex justify-content-center align-items-center" style="width: 30px;">
                    <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                </div>
                <div id="err-password" class="errMsg mb-4">
                </div>
            </div>

            <!-- <div class="checkbox checkbox-css">
                <input type="checkbox" name="rememberMe" id="rememberMe" class="rounded-sm">
                <label for="rememberMe" class="text-secondary font-xs light-text" style="display: inline-block; vertical-align: middle; margin-left: 2px;">
                    <small>Remember Me</small>
                </label>
            </div> -->

            <div class="mt-1 d-grid">
                <input id="btnLogin" type="submit" class="btn btn-primary btn-md btn-custom-color font-sm regular-text" style="height: 35px;" value="Login"></input>
            </div>


        </form>

        <div class="row mt-2">
            <div class="col">
                <hr style="border-top: 1px solid white;">
            </div>
            <div class="col-1 d-flex justify-content-center align-items-center text-secondary">or</div>
            <div class="col">
                <hr style="border-top: 1px solid white;">
            </div>
        </div>

        <div class="row mt-2">
            <!-- <div class="col d-grid">
                <button class="btn font-sm regular-text" style="background-color: #ffffffe6; border:gray; height: 35px; ">Sign in with Google</button>
            </div> -->
            <div id="gSignInWrapper" class="d-flex justify-content-center">
                <!-- <span class="label">Sign in with Google</span> -->
                <div id="googleSignInBtn"></div>
            </div>
        </div>

        <div class="font-xs text-secondary mt-2 light-text">
            <small>Not a member yet? Click <a href="<?= base_url('registration') ?>" style="color:white;">here</a> to register.</small>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<!-- ADDITIONAL JS -->

<?= $this->section('js'); ?>

<script src="https://accounts.google.com/gsi/client" async defer></script>
<?= load_js('Login/login.js'); ?>
<?= load_js('global/global-functions.js'); ?>

<?= $this->endSection(); ?>