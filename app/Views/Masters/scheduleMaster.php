<?= $this->extend('templates/layout'); ?>

<!-- ADDITIONAL CSS -->

<?= $this->section('css'); ?>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2/dist/spectrum.min.css">
<?= load_css('global/tempus-dominus.min.css') ?>
<?= load_css('global/global-styles.css') ?>
<?= load_css('Masters/scheduleMaster.css') ?>

<?= $this->endSection(); ?>

<!-- BODY CONTENT -->

<?= $this->section('content'); ?>

<div id="calendar"></div>

<!-- Create Schedule Modal -->
<div class="modal fade" id="scheduleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="scheduleModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title medium-text" id="scheduleModalLabel"></h3>
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
                        <div class="col-6 col-md-4 d-flex flex-column mt-3">
                            <label>Event Color</label>
                            <div id="colorPicker" class="colorPreview border form-control"></div>
                            <input type="text" class="form-control" id="modal-schedColor" name="modal-schedColor" hidden>
                            <input type="text" class="form-control" id="modal-schedTextColor" name="modal-schedTextColor" hidden>
                        </div>
                        <div class="col-6 col-md-4 col-xl-4 mt-3 d-flex flex-column">
                            <label>Max Players</label>
                            <input type="number" id="modal-schedMaxPlayer" class="form-control" name="modal-schedMaxPlayer" required>
                        </div>
                        <div class="col-6 col-md-4 col-xl-4 mt-3 d-flex flex-column">
                            <label>Game Fee</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-peso-sign"></i></span>
                                <input type="number" id="modal-schedGameFee" class="form-control" name="modal-schedGameFee" required>
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
                <button id='btnCreateSchedule' type="submit" class="btn btn-success">Create</button>
                <button id='btnEditSchedule' type="button" class="btn btn-primary">Edit</button>
                <button id='btnDeleteSchedule' type="submit" class="btn btn-danger">Delete</button>
                <button id='btnSaveSchedule' type="button" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<!-- ADDITIONAL JS -->

<?= $this->section('js'); ?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2/dist/spectrum.min.js"></script>


<!-- fullCalendar js -->
<script src="<?= base_url('js/global/index.global.min.js') ?>"></script>


<script src="<?= base_url('js/global/moment.min.js') ?>"></script>
<script src="<?= base_url('js/global/popper.min.js') ?>"></script>
<script src="<?= base_url('js/global/tempus-dominus.min.js') ?>"></script>
<?= load_js('Masters/scheduleMaster.js'); ?>

<?= $this->endSection(); ?>