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
        <div class="row">
            <div class="col-auto d-flex align-items-center pr-0">
                <i class="fa-solid fa-basketball fa-3x"></i>
            </div>
            <div class="col-auto d-flex align-items-center">
                <ul style="list-style-type:none; padding:0; margin:0;">
                    <li><span class="font-xxxl regular-text" style="line-height: 1;"><span
                                class="semi-bold-text">Ball</span> For Life</span></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container bg-secondary rounded p-3" style="max-width: 400px;">
        <div class="row">
            <div class="col d-flex">
                <ul style="list-style-type:none; padding:0; margin:0;">
                    <li><span class="font-xxl regular-text" style="line-height: 1;">Be a member!</span></li>
                </ul>
            </div>
        </div>
        <form id="frmRegister" action="<?= base_url('register') ?>" method="post">
            <div class="input-group has-validation mt-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">@</span>
                </div>
                <input id="email" name="email" type="email" class="form-control" placeholder="name@example.com"
                    required>
                <div class="invalid-feedback">
                    Please choose an email.
                </div>
            </div>
            <div class="input-group has-validation mt-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">-</span>
                </div>
                <input id="firstname" name="firstname" type="text" class="form-control" placeholder="First name"
                    required>
            </div>
            <div class="input-group has-validation mt-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">-</span>
                </div>
                <input id="lastname" name="lastname" type="text" class="form-control" placeholder="Last name" required>
            </div>
            <!-- <div class="input-group has-validation mt-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">-</span>
                </div>
                <input id="birthday" name="birthday" type="text" class="form-control" placeholder="Birthdate" required>
            </div> -->
            <div class="input-group has-validation mt-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">-</span>
                </div>
                <input id="contactNum" name="contactNum" type="text" class="form-control" placeholder="Contact number"
                    pattern="\d{11}" title="Please enter an 11-digit contact number" required>
            </div>
            <div id="show_hide_password" class="input-group has-validation mt-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">*</span>
                </div>
                <input id="password" name="password" type="password" class="form-control"
                    placeholder="Create a password" minlength="8" required>
                <div class="input-group-addon d-flex justify-content-center align-items-center" style="width: 30px;">
                    <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                </div>
                <div class="invalid-feedback">
                    Please enter password.
                </div>
            </div>
            <div id="show_hide_password" class="input-group has-validation mt-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">*</span>
                </div>
                <input id="confirm-password" name="confirm-password" type="password" class="form-control"
                    placeholder="Confirm password" minlength="8" required>
                <div class="input-group-addon d-flex justify-content-center align-items-center" style="width: 30px;">
                    <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                </div>
                <div class="invalid-feedback">
                    Please enter password.
                </div>
            </div>

            <div class="mt-4">
                <input id="btnRegister" type="submit" class="btn btn-primary btn-md btn-block btn-custom-color"
                    value="Register"></input>
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
            <div class="col">
                <button class="btn btn-block" style="background-color: #ffffffe6; border: gray;  ">Sign in with
                    Google</button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <a href="<?= base_url('logout') ?>" class="btn btn-custom-color btn-block mt-4">Logout</a>
            </div>
        </div>

        <div class="font-sm text-secondary mt-2 light-text">
            <small>Already a member? Click <a href="<?= base_url('/') ?>" style="color:white;">here</a> to
                login.</small>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>

<!-- ADDITIONAL JS -->

<?= $this->section('js'); ?>

<?= load_js('global/global-functions.js'); ?>

<?= $this->endSection(); ?>