<?= $this->extend('templates/layout'); ?>

<!-- ADDITIONAL CSS -->

<?= $this->section('css'); ?>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2/dist/spectrum.min.css">
<?= load_css('global/tempus-dominus.min.css') ?>
<?= load_css('global/global-styles.css') ?>
<?= load_css('global/datatables.min.css'); ?>
<?= load_css('Masters/scheduleMaster.css') ?>

<?= $this->endSection(); ?>

<!-- BODY CONTENT -->

<?= $this->section('content'); ?>

<div class="scheduleMaster-container d-flex gap-4">
    <div class="widgets-container">
        <div class="widgets-inner-container">
            <div id="appointments-widget" class="float-widget">
                <div class="widget-header">
                    Appointments
                    <i class="fa-solid fa-square-caret-up toggle-widget"></i>
                </div>
                <div class="widget-body">
                    <ul class="list-group">
                    </ul>
                </div>
            </div>
            <div id="players-widget" class="float-widget">
                <div class="widget-header">
                    Players Joined
                    <i class="fa-solid fa-square-caret-up toggle-widget"></i>
                </div>
                <div class="widget-body">
                    <ul class="list-group">
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="calendar-container">
        <div id="calendar">
        </div>
    </div>
</div>

<!-- Create Schedule Modal -->
<div class="modal fade" id="scheduleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="scheduleModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="container receipt-container d-none">
                <div class="imgReceipt">
                    <img id="imgReceipt"
                        src="<?= base_url(' images/uploads/receipts/10_WIN_20240619_18_34_46_Pro.jpg') ?>">
                    <span class="close">&times;</span>
                </div>
            </div>

            <div class="modal-header">
                <h3 class="modal-title medium-text" id="scheduleModalLabel"></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- <div class="container receipt-container">
                    <div class="imgReceipt" style="display: none;">
                        <img src="" alt="Receipt" class="popout-img">
                    </div>
                </div> -->

                <form id='frmSchedule' action="<?= base_url('createSchedule') ?>" data-parsley-validate>
                    <div class="row">
                        <div class="col-12 col-md-6 col-xl-6 d-flex flex-column">
                            <label>Schedule Title <span class="text-danger"> *</span></label>
                            <input type="text" id="modal-schedTitle" class="form-control" name="modal-schedTitle"
                                required data-parsley-required data-parsley-trigger="change"
                                data-parsley-errors-container="#err-title">
                            <div id="err-title" class="errMsg"></div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-6 mt-3 mt-md-0 d-flex flex-column">
                            <label>Venue <span class="text-danger"> *</span></label>
                            <input type="text" id="modal-schedVenue" class="form-control" name="modal-schedVenue"
                                required data-parsley-required data-parsley-trigger="change"
                                data-parsley-errors-container="#err-venue">
                            <div id="err-venue" class="errMsg"></div>
                        </div>
                        <div class="col-12 col-md-12 col-xl-12 mt-3 d-flex flex-column">
                            <label>Description</label>
                            <input type="text" id="modal-schedDescription" class="form-control"
                                name="modal-schedDescription" data-parsley-trigger="change"
                                data-parsley-errors-container="#err-description" data-parsley-maxLength="255">
                            <div id="err-description" class="errMsg"></div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-6 mt-3 d-flex flex-column">
                            <label>Start Date <span class="text-danger"> *</span></label>
                            <div class="input-group">
                                <input type="text" id="modal-schedStartDate" class="form-control datetimepicker"
                                    name="modal-schedStartDate" required data-parsley-trigger="change"
                                    data-parsley-dateorder="#modal-schedEndDate"
                                    data-parsley-notsamedate="#modal-schedEndDate"
                                    data-parsley-errors-container="#err-startDate">
                                <span class="input-group-text" id="calendar-icon"><i
                                        class="fa-solid fa-calendar fa-1x"></i></span>
                            </div>
                            <div id="err-startDate" class="errMsg mb-4"></div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-6 mt-3 d-flex flex-column">
                            <label>End Date <span class="text-danger"> *</span></label>
                            <div class="input-group">
                                <input type="text" id="modal-schedEndDate" class="form-control datetimepicker"
                                    name="modal-schedEndDate" required>
                                <span class="input-group-text" id="calendar-icon"><i
                                        class="fa-solid fa-calendar fa-1x"></i></span>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 d-flex flex-column mt-3">
                            <label>Event Color</label>
                            <div id="colorPicker" class="colorPreview border form-control"></div>
                            <input type="text" class="form-control" id="modal-schedColor" name="modal-schedColor"
                                hidden>
                            <input type="text" class="form-control" id="modal-schedTextColor"
                                name="modal-schedTextColor" hidden>
                        </div>
                        <div class="col-6 col-md-4 col-xl-4 mt-3 d-flex flex-column">
                            <label>Max Players <span class="text-danger"> *</span></label>
                            <input type="number" id="modal-schedMaxPlayer" class="form-control"
                                name="modal-schedMaxPlayer" required data-parsley-trigger="change"
                                data-parsley-type="number" data-parsley-errors-container="#err-maxPlayer">
                            <div id="err-maxPlayer" class="errMsg"></div>
                        </div>
                        <div class="col-6 col-md-4 col-xl-4 mt-3 d-flex flex-column">
                            <label>Game Fee <span class="text-danger"> *</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-peso-sign"></i></span>
                                <input type="number" id="modal-schedGameFee" class="form-control"
                                    name="modal-schedGameFee" required data-parsley-trigger="change"
                                    data-parsley-type="number" data-parsley-errors-container="#err-gameFee">
                                <div id="err-gameFee" class="errMsg"></div>
                            </div>
                        </div>
                        <div class="col-12 d-flex flex-column mt-4">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="modal-schedNotes"
                                    name="modal-schedNotes" style="height: 100px"></textarea>
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
                <button id='btnAppointments' type="submit" class="btn btn-custom-color text-white">Appointments <i
                        class="fa-solid fa-angles-down fa-1x ms-1"></i></button>
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
<?= load_js('global/datatables.min.js'); ?>
<?= load_js('Masters/scheduleMaster.js'); ?>

<?= $this->endSection(); ?>