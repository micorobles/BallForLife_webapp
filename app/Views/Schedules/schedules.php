<?= $this->extend('templates/layout'); ?>

<!-- ADDITIONAL CSS -->

<?= $this->section('css'); ?>

<?= load_css('global/global-styles.css'); ?>
<?= load_css('Schedules/schedules.css'); ?>

<?= $this->endSection(); ?>

<!-- BODY CONTENT -->

<?= $this->section('content'); ?>

<div class="schedules-container">
    <div class="schedules-body p-3 border">
        <div class="row">

            <!-- <div class="col-12 mt-4 col-lg-6 col-xxl-4">
                <div id="scheduleCard" class="card">
                    <div class="card-body">
                        <div class="card-heading border-bottom pb-2">
                            <div class="row">
                                <div class="col-10">
                                    <h3 id='schedTitle' class="card-title mb-0 text-nowrap text-truncate">Game of the Fucking Yearfadsfasdfsdafasfasdfsdaasfsadfds</h3>
                                </div>
                                <div class="col-2 p-0 d-flex justify-content-end">
                                    <span id='schedMaxPlayer' class="max-players font-xs text-muted regular-text me-2">20 <i class="fa-solid fa-people-group fa-1x text-muted"></i></span>
                                </div>
                                <div class="col-12 d-flex align-items-center mt-1">
                                    <i class="fa-solid fa-location-dot fa-1x text-muted font-xs me-2"></i>
                                    <span id='schedVenue' class="card-venue semi-bold-text text-muted font-xs">Uncle Drew Covered Court</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="row ">
                                <div class="col-12 mt-2 col-lg-6 d-flex align-items-center">
                                    <i class="fa-solid fa-calendar-day text-muted me-2"></i>
                                    <span id='schedDate' class="card-venue regular-text text-muted">November 20, 2024</span>
                                </div>
                                <div class="col-12 mt-2 col-lg-6 d-flex align-items-center">
                                    <i class="fa-solid fa-clock text-muted me-2"></i>
                                    <span id="schedTime" class="card-venue regular-text text-muted">8:00 AM - 10:00 AM</span>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col d-flex">
                                    <i class="fa-solid fa-align-left fa-1x text-muted me-2" style="margin-top: 5px;"></i>
                                    <span id="schedDescription" class="card-description regular-text text-muted font-sm">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Corrupti aliquam repellat itaque ipsa laborum iusto, dicta aut, eum blanditiis amet consequatur velit, voluptate voluptatem placeat suscipit est quibusdam debitis deleniti!</span>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col d-flex">
                                    <i class="fa-solid fa-comment-dots fa-1x text-muted me-2" style="margin-top: 5px;"></i>
                                    <p id="schedNotes" class="card-note medium-text text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam esse ipsa in quae. Quibusdam repellendus laborum perspiciatis fugit cum velit</p>
                                </div>
                            </div>
                        </div>

                        <div class="card-footerr border-top d-flex justify-content-center gap-2">
                            <button id="btnJoinSchedule" class="btn btn-md btn-custom-color w-100 text-white font-sm light-text"> Join <i class="fa-solid fa-user-plus ms-1 fa-1x"></i></button>
                            <button id="btnPreviewSchedule" class="btn btn-md btn-custom-color w-100 text-white font-sm light-text"> Preview <i class="fa-solid fa-arrow-right-to-bracket ms-1 fa-1x"></i></button>
                        </div>
                    </div>
                </div>
            </div> -->

        </div>
    </div>
</div>

<!-- Schedule Modal -->
 <!-- Create Schedule Modal -->
<div class="modal fade" id="previewScheduleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="previewScheduleModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title medium-text" id="previewScheduleModalLabel"></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id='frmSchedule' action="<?= base_url('createSchedule') ?>">
                    <div class="row">
                        <div class="col-12 col-md-6 col-xl-6 d-flex flex-column">
                            <label>Schedule Title</label>
                            <input type="text" id="modal-schedTitle" class="form-control" name="modal-schedTitle" required>
                        </div>
                        <div class="col-12 col-md-6 col-xl-6 mt-3 mt-md-0 d-flex flex-column">
                            <label>Venue</label>
                            <input type="text" id="modal-schedVenue" class="form-control" name="modal-schedVenue" required>
                        </div>
                        <div class="col-12 col-md-12 col-xl-12 mt-3 d-flex flex-column">
                            <label>Description</label>
                            <input type="text" id="modal-schedDescription" class="form-control" name="modal-schedDescription">
                        </div>
                        <div class="col-12 col-md-6 col-xl-6 mt-3 d-flex flex-column">
                            <label>Start Date</label>
                            <div class="input-group">
                                <input type="text" id="modal-schedStartDate" class="form-control datetimepicker" name="modal-schedStartDate" required>
                                <span class="input-group-text" id="calendar-icon"><i class="fa-solid fa-calendar fa-1x"></i></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-6 mt-3 d-flex flex-column">
                            <label>End Date</label>
                            <div class="input-group">
                                <input type="text" id="modal-schedEndDate" class="form-control datetimepicker" name="modal-schedEndDate" required>
                                <span class="input-group-text" id="calendar-icon"><i class="fa-solid fa-calendar fa-1x"></i></span>
                            </div>
                        </div>
                        <div class="col-6 d-flex flex-column mt-3">
                            <label>Event Color</label>
                            <div id="colorPicker" class="colorPreview border form-control"></div>
                            <input type="text" class="form-control" id="modal-schedColor" name="modal-schedColor" hidden>
                            <input type="text" class="form-control" id="modal-schedTextColor" name="modal-schedTextColor" hidden>
                        </div>
                        <div class="col-6 col-md-6 col-xl-6 mt-3 d-flex flex-column">
                            <label>Max Players</label>
                            <input type="number" id="modal-schedMaxPlayer" class="form-control" name="modal-schedMaxPlayer" required>
                        </div>
                        <div class="col-12 d-flex flex-column mt-4">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="modal-schedNotes" name="modal-schedNotes" style="height: 100px"></textarea>
                                <label for="modal-schedNotes">Notes</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button id="btnJoinSchedule" class="btn btn-custom-color text-white"> Join <i class="fa-solid fa-user-plus ms-1 fa-1x"></i></button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<!-- ADDITIONAL JS -->

<?= $this->section('js'); ?>

<script src="<?= base_url('js/global/moment.min.js') ?>"></script>
<?= load_js('global/global-functions.js'); ?>
<?= load_js('Schedules/schedules.js'); ?>

<?= $this->endSection(); ?>