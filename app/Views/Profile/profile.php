<?= $this->extend('templates/layout'); ?>

<!-- ADDITIONAL CSS -->

<?= $this->section('css'); ?>

<?= load_css('Profile/profile.css') ?>

<?= $this->endSection(); ?>

<!-- BODY CONTENT -->

<?= $this->section('content'); ?>

<div class="container">
    <div class="cover-photo rounded">
        <img src="<?= base_url('images/cover_photo2.png') ?>" alt="">
    </div>

    <div class="profile-picture">
        <div class="status d-flex align-items-center">
            <span>Status: &nbsp;</span>
            <span id='txtStatus' class="status-text">Active</span>
        </div>
        <img src="<?= base_url(session()->get('profilePic')) ?>" alt="">
        <div class="profile-buttons">
            <button class="btn btn-custom-color text-white font-sm light-text" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Edit Profile <i class="fa-solid fa-user-pen fa-1x"></i>
            </button>
        </div>

    </div>
    <div class="general-information">
        <div class="information-header">
            <i class="fa fa-circle-info me-2"></i>
            <span>General Information</span>
        </div>
        <div class="information-body">
            <div class="row">
                <div class="col-5 col-md-4 col-xl-3 d-flex flex-column">
                    <label>First Name</label>
                    <span id="firstname">Mico</span>
                </div>
                <div class="col-7 col-md-4 col-xl-3 d-flex flex-column">
                    <label>Last Name</label>
                    <span id="firstname">Robles</span>
                </div>
                <div class="col-5 col-md-4 col-xl-3 d-flex flex-column">
                    <label>Phone</label>
                    <span id="firstname">09230853051</span>
                </div>
                <div class="col-7 col-md-4 col-xl-3 d-flex flex-column">
                    <label>Email</label>
                    <span id="firstname">micholrobles@gmail.com</span>
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
                <div class="col-4 d-flex flex-column">
                    <label>Position</label>
                    <span id="firstname">Member</span>
                </div>
                <div class="col-4 d-flex flex-column">
                    <label>Height</label>
                    <span id="firstname">5'2</span>
                </div>
                <div class="col-4 d-flex flex-column">
                    <label>Weight</label>
                    <span id="firstname">90 lbs</span>
                </div>
                <div class="col-0 d-flex flex-column">

                </div>
                <div class="col-12 col-xl-6 d-flex flex-column mt-4">
                    <label>Skills</label>
                    <div class="skills-input-container">
                        <select id="skills-select-display" class="skills-select" multiple="multiple" style="width: 100%;" disabled>
                            <option selected value="Dribbling">Dribbling</option>
                            <option value="Passing">Passing</option>
                            <option value="Defense">Defense</option>
                            <option value="Rebounding">Rebounding</option>
                            <option value="Footwork">Footwork</option>
                            <option value="Ball-Handling">Ball Handling</option>
                            <option value="Jumping">Jumping</option>
                            <option value="Teamwork">Teamwork</option>
                            <option value="Shooting">Shooting</option>
                            <option value="Perimeter">Perimeter</option>
                            <option value="Low-Post">Low Post</option>
                            <option value="Pullups">Pullups</option>
                            <option value="Coast-to-Coast">Coast to Coast</option>
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
                <form id='frmProfile' action="<?= base_url('edit-profile') ?>">
                    <div class="row">
                        <div class="col-12 form-header">
                            <span>General Information</span>
                        </div>
                        <div class="col-6">
                            <label for="firstname">First Name:</label>
                            <input type="text" id="firstname" class="w-100" name="firstname">
                        </div>
                        <div class="col-6">
                            <label for="lastname">Last Name:</label>
                            <input type="text" id="lastname" class="w-100" name="lastname">
                        </div>
                        <div class="col-6">
                            <label for="phone">Phone:</label>
                            <input type="number" id="phone" class="w-100" name="phone">
                        </div>
                        <div class="col-6">
                            <label for="email">Email:</label>
                            <input type="email" id="email" class="w-100" name="email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 form-header mt-4">
                            <span>Technical Information</span>
                        </div>
                        <div class="col-6">
                            <label for="position">Position:</label>
                            <input type="text" id="position" class="w-100" name="position">
                        </div>
                        <div class="col-6">
                            <label for="height">Height:</label>
                            <input type="number" id="height" class="w-100" name="height">
                        </div>
                        <div class="col-6">
                            <label for="weight">Weight:</label>
                            <input type="number" id="weight" class="w-100" name="weight">
                        </div>
                        <div class="col-12">
                            <label >Skills:</label>
                            <div class="skills-input-container">
                                <select id="skills-select" class="skills-select" multiple="multiple" style="width: 100%; z-index:999;">
                                    <option selected value="Dribbling">Dribbling</option>
                                    <option value="Passing">Passing</option>
                                    <option value="Defense">Defense</option>
                                    <option value="Rebounding">Rebounding</option>
                                    <option value="Footwork">Footwork</option>
                                    <option value="Ball-Handling">Ball Handling</option>
                                    <option value="Jumping">Jumping</option>
                                    <option value="Teamwork">Teamwork</option>
                                    <option value="Shooting">Shooting</option>
                                    <option value="Perimeter">Perimeter</option>
                                    <option value="Low-Post">Low Post</option>
                                    <option value="Pullups">Pullups</option>
                                    <option value="Coast-to-Coast">Coast to Coast</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
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