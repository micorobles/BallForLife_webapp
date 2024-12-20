<?= $this->extend('templates/layout'); ?>

<!-- ADDITIONAL CSS -->

<?= $this->section('css'); ?>

<?= load_css('global/global-styles.css') ?>
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
        <form id="frmRegister" action="<?= base_url('verifyEmail') ?>" method="post" data-parsley-validate>
            <div class="input-group has-validation mt-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">@</span>
                </div>
                <input id="email" name="email" type="email" class="form-control" placeholder="name@example.com" required
                    required data-parsley-trigger="change" data-parsley-type="email"
                    data-parsley-errors-container="#err-email">
                <div id="err-email" class="errMsg">
                </div>
            </div>
            <div class="input-group has-validation mt-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">-</span>
                </div>
                <input id="firstname" name="firstname" type="text" class="form-control" placeholder="First name"
                    required required data-parsley-trigger="change" data-parsley-pattern="^[a-zA-Z]+$"
                    data-parsley-errors-container="#err-firstname">
                <div id="err-firstname" class="errMsg">
                </div>
            </div>
            <div class="input-group has-validation mt-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">-</span>
                </div>
                <input id="lastname" name="lastname" type="text" class="form-control" placeholder="Last name" required
                    required data-parsley-trigger="change" data-parsley-pattern="^[a-zA-Z]+$"
                    data-parsley-errors-container="#err-lastname">
                <div id="err-lastname" class="errMsg">
                </div>
            </div>
            <div class="input-group has-validation mt-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">-</span>
                </div>
                <input id="contactNum" name="contactNum" type="text" class="form-control" placeholder="Contact number"
                    pattern="\d{11}" title="Please enter an 11-digit contact number" required data-parsley-trigger="change" data-parsley-type="number" data-parsley-pattern="\d{11}"
                    data-parsley-errors-container="#err-contactNum">
                <div id="err-contactNum" class="errMsg">
                </div>
            </div>
            <div id="show_hide_password" class="input-group has-validation mt-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">*</span>
                </div>
                <input id="password" name="password" type="password" class="form-control"
                    placeholder="Create a password" minlength="8" required data-parsley-trigger="change" data-parsley-minlength="8"
                    data-parsley-errors-container="#err-password">
                <div class="input-group-addon d-flex justify-content-center align-items-center" style="width: 30px;">
                    <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                </div>
                <div id="err-password" class="errMsg">
                </div>
            </div>
            <div id="show_hide_password" class="input-group has-validation mt-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">*</span>
                </div>
                <input id="confirm-password" name="confirm-password" type="password" class="form-control"
                    placeholder="Confirm password" minlength="8" required data-parsley-trigger="change" data-parsley-minlength="8"
                    data-parsley-errors-container="#err-confirmPassword">
                <div class="input-group-addon d-flex justify-content-center align-items-center" style="width: 30px;">
                    <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                </div>
                <div id="err-confirmPassword" class="errMsg">
                </div>
            </div>

            <div class="mt-4 d-grid">
                <input id="btnRegister" type="submit" class="btn btn-primary btn-md btn-custom-color"
                    value="Register"></input>
            </div>


        </form>

        <!-- <div class="row mt-2">
            <div class="col">
                <hr style="border-top: 1px solid white;">
            </div>
            <div class="col-1 d-flex justify-content-center align-items-center text-secondary">or</div>
            <div class="col">
                <hr style="border-top: 1px solid white;">
            </div>
        </div> -->

        <!-- <div class="row mt-2">
            <div class="col d-grid">
                <button class="btn" style="background-color: #ffffffe6; border: gray;  ">Sign in with
                    Google</button>
            </div>
        </div> -->

        <div class="font-sm text-secondary mt-2 light-text">
            <small>Already a member? Click <a href="<?= base_url('/') ?>" style="color:white;">here</a> to
                login.</small>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="VerificationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="VerificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title medium-text" id="VerificationModalLabel">OTP Verification</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id='frmOTP' action="<?= base_url('verifyOTP') ?>" data-parsley-validate>

                    <div class="row">
                        <div class="col-12 d-flex flex-column">
                            <p class="description regular-text"></p>
                            <label>Email</label>
                            <input type="email" id="modal-email" class="form-control" name="modal-email" data-parsley-trigger="change"
                            data-parsley-errors-container="#err-email" readonly>
                            <div id="err-email" class="errMsg"></div>
                        </div>
                        <div class="col-12 d-flex flex-column mt-3">
                            <label>OTP</label>
                            <input type="number" id="modal-otp" class="form-control" name="modal-otp" data-parsley-required data-parsley-trigger="change" data-parsley-type="number" data-parsley-pattern="\d{6}"
                            data-parsley-errors-container="#err-otp">
                            <div id="err-otp" class="errMsg"></div>
                        </div>
                     </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id='btnVerifyOtp' type="button" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<!-- ADDITIONAL JS -->

<?= $this->section('js'); ?>

<?= load_js('Registration/registration.js'); ?>
<?= load_js('global/global-functions.js'); ?>

<?= $this->endSection(); ?>