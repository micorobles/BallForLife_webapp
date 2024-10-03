<?= $this->extend('templates/layout'); ?>

<!-- ADDITIONAL CSS -->

<?= $this->section('css'); ?>


<?= $this->endSection(); ?>

<!-- BODY CONTENT -->

<?= $this->section('content'); ?>

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
                    <li><span class="font-xxl regular-text" style="line-height: 1;"><span class="semi-bold-text">Ball</span > For Life</span></li>
                    <li> <span class="font-md text-secondary mt-0 light-text">A life in <strong>Ball</strong>-ance</span></li>
                </ul>
            </div>
        </div>
        <form id="frmLogin" action="<?= base_url('login') ?>" method="post">
            <div class="input-group has-validation mt-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">@</span>
                </div>
                <input id="username" name="username" type="text" class="form-control" required>
                <div class="invalid-feedback">
                    Please choose a username.
                </div>
            </div>
            <div class="input-group has-validation mt-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">*</span>
                </div>
                <input id="password" name="password" type="text" class="form-control" required>
                <div class="invalid-feedback">
                    Please enter password.
                </div>
            </div>

            <div class="checkbox checkbox-css mt-3">
                <input type="checkbox" id="remember_checkbox" class="rounded-sm">
                <label for="remember_checkbox" class="text-secondary font-sm light-text" style="display: inline-block; vertical-align: middle; margin-left: 2px;">
                    <small>Remember Me</small>
                </label>
            </div>

            <div class="mt-2">
                <input id="btnLogin" type="submit" class="btn btn-primary btn-md btn-block" style="background-color: #a39d98; border: #a39d98d2;" value="Login"></input>
            </div>

            <div class="font-sm text-secondary mt-3 light-text">
                <small>Not a member yet? Click <a href="/" style="color:white;">here</a> to register.</small>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>

<!-- ADDITIONAL JS -->

<?= $this->section('js'); ?>

<?= load_js('Login/login.js'); ?>
<?= load_js('global/ajax.js'); ?>

<?= $this->endSection(); ?>