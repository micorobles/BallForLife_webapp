<?= $this->extend('templates/layout'); ?>

<!-- ADDITIONAL CSS -->

<?= $this->section('css'); ?>

<?= load_css('Profile/profile.css') ?>

<?= $this->endSection(); ?>

<!-- BODY CONTENT -->

<?= $this->section('content'); ?>

<div class="container">
    <div class="cover-photo rounded">
        <img id="coverPhoto" src="" alt="">
    </div>

    <div class="profile-picture border">
        <div class="status d-flex align-items-center">
            <span>Status: &nbsp;</span>
            <span id='txtStatus' class="status-text"><?= ucfirst(session()->get('status')) ?></span>
        </div>
        <img id='profilePic' src="" alt="">
        <div class="profile-buttons border">
            <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-custom-color text-white dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-gear"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="btnGroupDrop1">
                    <li><a class="dropdown-item regular-text font-sm" href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa-solid fa-user-pen fa-1x me-2"></i>Edit Profile </a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item regular-text font-sm" href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal"><i class="fa-solid fa-key fa-1x me-2"></i>Change Password </i></a></li>
                </ul>
            </div>
            <!-- <button class="btn btn-custom-color text-white font-sm light-text" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Change Password <i class="fa-solid fa-key fa-1x"></i>
            </button> -->
            <!-- <button class="btn btn-custom-color text-white font-sm light-text" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Edit Profile <i class="fa-solid fa-user-pen fa-1x"></i>
            </button> -->
        </div>
    </div>

    <div class="general-information">
        <div class="information-header">
            <i class="fa fa-circle-info me-2"></i>
            <span>General Information</span>
        </div>
        <div class="information-body">
            <div class="row">
                <div class="col-6 col-md-4 col-xl-3 d-flex flex-column">
                    <label>First Name</label>
                    <span id="firstname"></span>
                </div>
                <div class="col-6 col-md-4 col-xl-3 d-flex flex-column">
                    <label>Last Name</label>
                    <span id="lastname"></span>
                </div>
                <div class="col-6 col-md-4 col-xl-3 d-flex flex-column">
                    <label>Phone</label>
                    <span id="contactNum"></span>
                </div>
                <div class="col-6 col-md-4 col-xl-3 d-flex flex-column">
                    <label>Email</label>
                    <span id="email"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="technical-information">
        <div class="information-header">
            <i class="fa fa-circle-info me-2"></i>
            <span>Technical Information</span>
        </div>
        <div class="information-body">
            <div class="row">
                <div class="col-6 col-md-4 col-xl-3 d-flex flex-column">
                    <label>Position</label>
                    <span id="_position"></span>
                </div>
                <div class="col-6 col-md-4 col-xl-3 d-flex flex-column">
                    <label>Height</label>
                    <span id="height"></span>
                </div>
                <div class="col-6 col-md-4 mt-md-0 mt-4 col-xl-3 d-flex flex-column">
                    <label>Weight</label>
                    <span id="weight"></span>
                </div>
                <!-- <div class="col-0 d-flex flex-column">

                </div> -->
                <div class="col-12 col-xl-6 d-flex flex-column mt-4">
                    <label>Skills</label>
                    <div class="skills-input-container">
                        <select id="skills-select" class="skills-select" multiple="multiple" style="width: 100%;" disabled>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title medium-text" id="staticBackdropLabel">Edit Profile</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id='frmProfile' action="<?= base_url('editProfile') ?>">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            <img id="coverPhotoPreview" src="" alt="Cover Photo Preview">
                        </div>
                        <div class="col-12">
                            <label for="coverPhotoFile" class="form-label">Upload cover photo</label>
                            <input type="file" class="form-control" id="coverPhotoFile" name="coverPhotoFile" accept=".png, .jpg, .jpeg">
                        </div>
                        <div class="col-12 d-flex justify-content-center mt-4">
                            <img id="profilePreview" src="" alt="Profile Picture Preview">
                        </div>
                        <div class="col-12">
                            <label for="pictureFile" class="form-label">Upload profile picture</label>
                            <input type="file" class="form-control" id="pictureFile" name="pictureFile" accept=".png, .jpg, .jpeg">
                        </div>
                        <div class="col-12 form-header mt-4">
                            <span>General Information</span>
                        </div>
                        <div class="col-6">
                            <label for="firstname">First Name:</label>
                            <input type="text" id="modal-firstname" class="w-100" name="firstname" value="">
                        </div>
                        <div class="col-6">
                            <label for="lastname">Last Name:</label>
                            <input type="text" id="modal-lastname" class="w-100" name="lastname" value="">
                        </div>
                        <div class="col-6">
                            <label for="phone">Phone:</label>
                            <input type="number" id="modal-contactNum" class="w-100" name="phone" value="">
                        </div>
                        <div class="col-6">
                            <label for="email">Email:</label>
                            <input type="email" id="modal-email" class="w-100" name="email" value="" disabled>
                        </div>
                        <div class="col-6">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 form-header mt-4">
                            <span>Technical Information</span>
                        </div>
                        <div class="col-6">
                            <label for="position">Position:</label>
                            <input type="text" id="modal-position" class="w-100" name="position" value="">
                        </div>
                        <div class="col-6">
                            <label for="height">Height:</label>
                            <div class="input-group">
                                <input type="number" id="modal-heightFeet" class="form-control" name="heightFeet" placeholder="Feet" value="">
                                <span class="input-group-text">'</span>
                                <input type="number" id="modal-heightInch" class="form-control" name="heightInches" placeholder="Inches" value="">
                                <span class="input-group-text">"</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="weight">Weight:</label>
                            <div class="input-group">
                                <input type="number" id="modal-weight" class="form-control" name="weight" value="">
                                <span class="input-group-text">lbs</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="skills">Skills:</label>
                            <div class="modal-skills-input-container" style="position:relative;">
                                <select id="modal-skills-select" class="skills-select" name="skills[]" multiple="multiple" style="width: 100%; z-index:999;">
                                </select>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id='btnFrmProfile' type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div id="changePasswordModal-content" class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title medium-text" id="changePasswordModalLabel">Change Password</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id='frmChangePassword' action="<?= base_url('changePassword') ?>">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center flex-column">
                            <label>Current Password</label>
                            <div id="show_hide_password" class="input-group has-validation">
                                <!-- <div class="input-group-prepend">
                                    <span class="input-group-text">*</span>
                                </div> -->
                                <input id="modal-currentPassword" name="modal-currentPassword" type="password" class="form-control"
                                    placeholder="********" minlength="8" required data-parsley-trigger="change" data-parsley-minlength="8"
                                    data-parsley-errors-container="#err-modal-currentPassword">
                                <div class="input-group-addon d-flex justify-content-center align-items-center" style="width: 30px;">
                                    <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                </div>
                                <div id="err-modal-currentPassword" class="errMsg">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-center flex-column mt-3">
                            <label>New Password</label>
                            <div id="show_hide_password" class="input-group has-validation">
                                <!-- <div class="input-group-prepend">
                                    <span class="input-group-text">*</span>
                                </div> -->
                                <input id="modal-newPassword" name="modal-newPassword" type="password" class="form-control"
                                    placeholder="********" minlength="8" required data-parsley-trigger="change" data-parsley-minlength="8" data-parsley-newpassword="#modal-currentPassword"
                                    data-parsley-errors-container="#err-modal-newPassword">
                                <div class="input-group-addon d-flex justify-content-center align-items-center" style="width: 30px;">
                                    <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                </div>
                                <div id="err-modal-newPassword" class="errMsg">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-center flex-column mt-3 mb-3">
                            <label>Confirm New Password</label>
                            <div id="show_hide_password" class="input-group has-validation">
                                <!-- <div class="input-group-prepend">
                                    <span class="input-group-text">*</span>
                                </div> -->
                                <input id="modal-confirmNewPassword" name="modal-confirmNewPassword" type="password" class="form-control"
                                    placeholder="********" minlength="8" required data-parsley-trigger="change" data-parsley-minlength="8" data-parsley-confirmpassword="#modal-newPassword"
                                    data-parsley-newpassword="#modal-currentPassword" data-parsley-errors-container="#err-modal-confirmNewPassword">
                                <div class="input-group-addon d-flex justify-content-center align-items-center" style="width: 30px;">
                                    <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                </div>
                                <div id="err-modal-confirmNewPassword" class="errMsg">
                                </div>
                            </div>
                        </div>

                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id='btnFrmChangePassword' type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<!-- ADDITIONAL JS -->

<?= $this->section('js'); ?>

<?= load_js('global/global-functions.js'); ?>
<?= load_js('Profile/profile.js'); ?>

<?= $this->endSection(); ?>