<?= $this->extend('templates/layout'); ?>

<!-- ADDITIONAL CSS -->

<?= $this->section('css'); ?>

<?= load_css('Profile/profile.css') ?>

<?= $this->endSection(); ?>

<!-- BODY CONTENT -->

<?= $this->section('content'); ?>

    <div class="container p-0">
        <div class="cover-photo rounded">
            <img src="<?= base_url('images/cover_photo.jpg') ?>" alt="">
        </div>

        <div class="profile-picture">
            <img src="<?= base_url(session()->get('profilePic')) ?>" alt="">
            <div class="profile-buttons">
                <button class="btn btn-custom-color text-white font-sm light-text">Edit Profile <i class="fa-solid fa-user-pen fa-1x"></i></button>
            </div>
        </div>
    </div>

<?= $this->endSection(); ?>

<!-- ADDITIONAL JS -->

<?= $this->section('js'); ?>

<?= load_js('global/global-functions.js'); ?>
<?= load_js('Profile/profile.js'); ?>

<?= $this->endSection(); ?>