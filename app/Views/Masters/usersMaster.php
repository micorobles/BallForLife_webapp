<?= $this->extend('templates/layout'); ?>

<!-- ADDITIONAL CSS -->

<?= $this->section('css'); ?>

<?= load_css('global/datatables.min.css') ?>
<?= load_css('Masters/usersMaster.css') ?>

<?= $this->endSection(); ?>

<!-- BODY CONTENT -->

<?= $this->section('content'); ?>

<div class="container-fluid">
    <table id="tblUser">
        <thead>
            <tr>
                <!-- <th hidden>ID</th> -->
                <th>E-mail Address</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Position</th>
                <th>Update Date</th>
            </tr>
        </thead>
        <tbody>
           
        </tbody>
    </table>
</div>


<?= $this->endSection(); ?>

<!-- ADDITIONAL JS -->

<?= $this->section('js'); ?>

<?= load_js('global/datatables.min.js') ?>
<?= load_js('Masters/userMaster.js'); ?>

<?= $this->endSection(); ?>