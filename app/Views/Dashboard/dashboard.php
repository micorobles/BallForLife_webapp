<?= $this->extend('templates/layout'); ?>

<!-- ADDITIONAL CSS -->

<?= $this->section('css'); ?>

<?= load_css('global/global-styles.css') ?>
<?= load_css('Dashboard/dashboard.css') ?>

<?= $this->endSection(); ?>

<!-- BODY CONTENT -->

<?= $this->section('content'); ?>

<div class="row">

    <?php if (session()->get('userRole') === 'Admin'): ?>
        <!-- ADMIN DASHBOARD -->
        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
            <div class="stats-card bg-info border">
                <div class="stats-info">
                    <span class="font-sm">TOTAL USERS</span>
                    <h2><?= $totalUsers; ?></h2>
                    <div class="stats-icon">
                        <i class="fa-solid fa-users fa-3x"></i>
                    </div>
                </div>
                <div class="stats-link">
                    <a href="<?= base_url('userMaster') ?>">
                        View Detail
                        <i class="fa-solid fa-circle-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4 col-sm-6 mt-sm-0 col-lg-4 col-xl-3">
            <div class="stats-card bg-warning border">
                <div class="stats-info">
                    <span class="font-sm">PENDING USERS</span>
                    <h2><?= $pendingUsers; ?></h2>
                    <div class="stats-icon">
                        <i class="fa-solid fa-user-clock fa-3x"></i>
                    </div>
                </div>
                <div class="stats-link">
                    <a href="<?= base_url('userMaster') ?>">
                        View Detail
                        <i class="fa-solid fa-circle-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4 col-sm-6 col-lg-4 mt-lg-0 col-xl-3">
            <div class="stats-card bg-success border">
                <div class="stats-info">
                    <span class="font-sm">TOTAL SCHEDULES</span>
                    <h2><?= $totalSchedules; ?></h2>
                    <div class="stats-icon">
                        <i class="fa-regular fa-calendar-days fa-3x"></i>
                    </div>
                </div>
                <div class="stats-link">
                    <a href="<?= base_url('scheduleMaster') ?>">
                        View Detail
                        <i class="fa-solid fa-circle-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4 col-sm-6 col-lg-4 col-xl-3 mt-xl-0">
            <div class="stats-card bg-danger border">
                <div class="stats-info">
                    <span class="font-sm">UPCOMING SCHEDULES</span>
                    <h2><?= $upcomingSchedules; ?></h2>
                    <div class="stats-icon">
                        <i class="fa-solid fa-calendar-day fa-3x"></i>
                    </div>
                </div>
                <div class="stats-link">
                    <a href="<?= base_url('scheduleMaster') ?>">
                        View Detail
                        <i class="fa-solid fa-circle-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4 col-sm-6 col-lg-4 col-xl-3">
            <div class="stats-card border" style="background-color: #6c757d;">
                <div class="stats-info">
                    <span class="font-sm">APPOINTMENT REQUESTS</span>
                    <h2><?= $appointmentRequests; ?></h2>
                    <div class="stats-icon">
                        <i class="fa-solid fa-person-circle-question fa-3x"></i>
                    </div>
                </div>
                <div class="stats-link">
                    <a href="<?= base_url('scheduleMaster?focus=appointments-widget') ?>">
                        View Detail
                        <i class="fa-solid fa-circle-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- USER DASHBOARD -->
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="stats-card bg-info border">
                <div class="stats-info">
                    <span class="font-sm">UPCOMING SCHEDULES</span>
                    <h2><?= $upcomingSchedules; ?></h2>
                    <div class="stats-icon">
                        <i class="fa-solid fa-calendar-day fa-3x"></i>
                    </div>
                </div>
                <div class="stats-link">
                    <a href="<?= base_url('schedules') ?>">
                        View Detail
                        <i class="fa-solid fa-circle-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4 col-sm-6 mt-sm-0 col-lg-4">
            <div class="stats-card bg-warning border">
                <div class="stats-info">
                    <span class="font-sm">APPOINTMENT PENDING</span>
                    <h2><?= $appointmentPending; ?></h2>
                    <div class="stats-icon">
                        <i class="fa-regular fa-calendar-minus fa-3x"></i>
                    </div>
                </div>
                <div class="stats-link">
                    <a href="<?= base_url('schedules') ?>">
                        View Detail
                        <i class="fa-solid fa-circle-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4 col-sm-6 col-lg-4 mt-lg-0">
            <div class="stats-card bg-success border">
                <div class="stats-info">
                    <span class="font-sm">APPOINTMENT JOINED</span>
                    <h2><?= $appointmentJoined; ?></h2>
                    <div class="stats-icon">
                        <i class="fa-regular fa-calendar-check fa-3x"></i>
                    </div>
                </div>
                <div class="stats-link">
                    <a href="<?= base_url('schedules') ?>">
                        View Detail
                        <i class="fa-solid fa-circle-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
       
    <?php endif; ?>
</div>
<?= $this->endSection(); ?>

<!-- ADDITIONAL JS -->

<?= $this->section('js'); ?>

<?= load_js('global/global-functions.js'); ?>
<?= load_js('Dashboard/dashboard.js'); ?>

<?= $this->endSection(); ?>