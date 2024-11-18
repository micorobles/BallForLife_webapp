<?= $this->extend('templates/layout'); ?>

<!-- ADDITIONAL CSS -->

<?= $this->section('css'); ?>

<?= load_css('global/tempus-dominus.min.css') ?>
<?= load_css('global/global-styles.css') ?>
<?= load_css('Masters/scheduleMaster.css') ?>

<?= $this->endSection(); ?>

<!-- BODY CONTENT -->

<?= $this->section('content'); ?>


<div id="calendar"></div>

<!-- Modal -->
<div class="modal fade" id="createSchedModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createSchedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title medium-text" id="createSchedModalLabel">Create Schedule</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id='frmCreateSchedule' action="<?= base_url('createSchedule') ?>">
                    <div class="row">
                        <div class="col-12 col-md-6 col-xl-6 d-flex flex-column">
                            <label>Schedule Title</label>
                            <input type="text" id="modal-schedTitle" class="form-control" name="modal-schedTitle" required>
                        </div>
                        <div class="col-12 col-md-6 col-xl-6  d-flex flex-column">
                            <label>Venue</label>
                            <input type="text" id="modal-schedVenue" class="form-control" name="modal-schedVenue" required>
                        </div>
                        <div class="col-12 col-md-10 col-xl-10 mt-3 d-flex flex-column">
                            <label>Description</label>
                            <input type="text" id="modal-schedDescription" class="form-control" name="modal-schedDescription">
                        </div>
                        <div class="col-12 col-md-2 col-xl-2 mt-3 d-flex flex-column">
                            <label>Max Players</label>
                            <input type="number" id="modal-schedMaxPlayer" class="form-control" name="modal-schedMaxPlayer" required>
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
                <button id='btnCreateSchedule' type="submit" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>

<!-- ADDITIONAL JS -->

<?= $this->section('js'); ?>

<!-- fullCalendar js -->
<script src="<?= base_url('js/global/index.global.min.js') ?>"></script>

<script src="<?= base_url('js/global/moment.min.js') ?>"></script>
<script src="<?= base_url('js/global/popper.min.js') ?>"></script>
<script src="<?= base_url('js/global/tempus-dominus.min.js') ?>"></script>
<?= load_js('Masters/scheduleMaster.js'); ?>

<?= $this->endSection(); ?>