<?= $this->extend('templates/layout'); ?>

<!-- ADDITIONAL CSS -->

<?= $this->section('css'); ?>

<?= load_css('global/datatables.min.css') ?>
<?= load_css('Masters/usersMaster.css') ?>
<?= load_css('Profile/profile.css') ?>

<?= $this->endSection(); ?>

<!-- BODY CONTENT -->

<?= $this->section('content'); ?>

<div class="container-fluid buttons-container">
    <div class="row">
        <div class="col-6 col-md-4 col-lg-3">
            <button id="btnModifyUser" class="crud-buttons btn font-sm text-white" style="background-color: #800000" data-bs-toggle="modal" data-bs-target="#modifyUserModal" data-toggle="tooltip" data-bs-placement="bottom" title="Modify Status / Password" disabled>
                <i class="fa-regular fa-pen-to-square me-1"></i>
                Modify
            </button>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <button id="btnDeleteUser" class="crud-buttons btn btn-danger font-sm me-2" disabled><i class="fa-regular fa-trash-can me-1"></i>Delete</button>
        </div>
        <div class="col-6 mt-2 col-md-4 mt-md-0 col-lg-3 mt-lg-0">
            <button id="btnView" class="crud-buttons btn btn-secondary font-sm" data-bs-toggle="modal" data-bs-target="#viewProfileModal" disabled><i class="fa-regular fa-eye me-1"></i> View</button>
        </div>
    </div>
    <!-- <button class="btn btn-primary"></button> -->
</div>
<div class="container-fluid border-top mt-2">
    <table id="tblUser">
        <thead>
            <tr>
                <th>ID</th>
                <th>E-mail Address</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Position</th>
                <th>Status</th>
                <th>Update Date</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>


<!-- View Profile Modal -->
<div class="modal fade" id="viewProfileModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title medium-text" id="viewProfileModalLabel">View Profile</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="cover-photo rounded">
                        <img id="coverPhoto" src="" alt="">
                    </div>

                    <div class="profile-picture">
                        <div class="status d-flex align-items-center">
                            <span>Status: &nbsp;</span>
                            <span id='txtStatus' class="status-text"><?= ucfirst(session()->get('status')) ?></span>
                        </div>
                        <img id='profilePic' src="<?= base_url(session()->get('profilePic')) ?>" alt="">
                        <div class="profile-buttons">
                            <!-- <button class="btn btn-custom-color text-white font-sm light-text" data-bs-toggle="modal" data-bs-target="#viewProfileModal">
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="modifyUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modifyUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title medium-text" id="modifyUserModalLabel">Edit Profile</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id='frmUserProfile' action="">

                    <div class="information-body">
                        <div class="row">
                            <div class="col-6 col-md-6 col-xl-6 d-flex flex-column">
                                <label>First Name</label>
                                <input type="text" id="modal-firstname" class="form-control" name="modal-firstname" disabled>
                                <span id="firstname"></span>
                            </div>
                            <div class="col-6 col-md-6 col-xl-6 d-flex flex-column">
                                <label>Last Name</label>
                                <input type="text" id="modal-lastname" class="form-control" name="modal-lastname" disabled>
                            </div>
                            <div class="col-6 col-md-6 col-xl-6 d-flex flex-column mt-3">
                                <label>Phone</label>
                                <input type="text" id="modal-contactnum" class="form-control" name="modal-contactnum" disabled>
                            </div>
                            <div class="col-6 col-md-6 col-xl-6 d-flex flex-column mt-3">
                                <label>Email</label>
                                <input type="text" id="modal-email" class="form-control" name="modal-email" disabled>
                            </div>
                            <div class="col-12 col-md-12 col-xl-6 mt-3">
                                <label>Status</label>
                                <div class="border pt-2 d-flex justify-content-center rounded ">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="modal-status" id="modal-status-active" value="Active">
                                        <label class="form-check-label" for="modal-status-active">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="modal-status" id="modal-status-inactive" value="Inactive">
                                        <label class="form-check-label" for="modal-status-inactive">Inactive</label>

                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="modal-status" id="modal-status-pending" value="Pending">
                                        <label class="form-check-label" for="modal-status-ban">Pending</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="modal-status" id="modal-status-ban" value="Ban">
                                        <label class="form-check-label" for="modal-status-ban">Ban</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-xl-6 d-flex flex-column mt-3">
                                <label>Password</label>
                                <div class="input-group mb-3 password-input-group">
                                    <input type="text" id="modal-password" class="form-control" name="modal-password" readonly>
                                    <span class="input-group-text" id="shuffle-icon"><i class="fa-solid fa-shuffle fa-1x"></i></span>
                                    <i id="pwCopy" class="fa-solid fa-copy fa-1x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id='btnSaveUser' type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>

<!-- ADDITIONAL JS -->

<?= $this->section('js'); ?>

<?= load_js('global/datatables.min.js') ?>
<?= load_js('Profile/profile.js'); ?>
<?= load_js('Masters/userMaster.js'); ?>

<?= $this->endSection(); ?>