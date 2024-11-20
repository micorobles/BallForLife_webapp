<?= $this->extend('templates/layout'); ?>

<!-- ADDITIONAL CSS -->

<?= $this->section('css'); ?>

<?= load_css('Schedule/schedules.css'); ?>

<?= $this->endSection(); ?>

<!-- BODY CONTENT -->

<?= $this->section('content'); ?>

<div class="schedules-container border">
    <div class="schedules-body p-3">
        <div class="row">
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <div class="card-heading d-flex align-items-center justify-content-between">
                            <h4 class="card-title mb-0">1st Event</h4>
                            <span class="max-players font-xs text-muted regular-text me-1">20 <i class="fa-solid fa-people-group fa-1x text-muted"></i></span>

                        </div>
                        <div class="card-content">
                            <h5 class="card-venue text-muted"><i class="fa-solid fa-location-dot fa-1x me-2"></i>Uncle Drew Covered Court</h5>
                            <h5 class="card-description regular-text mb-2 text-muted"><i class="fa-solid fa-align-left fa-1x me-2"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatum nisi dicta officia magnam, molestiae voluptatem beatae fuga. Nulla fuga explicabo, ut nam totam omnis. Molestiae doloremque possimus quam. Laborum, quam.</h5>
                            <p class="card-note"><i class="fa-solid fa-comment-dots fa-1x text-muted me-2"></i>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam esse ipsa in quae. Quibusdam repellendus laborum perspiciatis fugit cum velit, amet laudantium, dolor blanditiis maiores at consequatur assumenda! Alias, reiciendis.</p>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="card-link">Preview</a>
                            <a href="#" class="card-link">Another link</a>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<!-- ADDITIONAL JS -->

<?= $this->section('js'); ?>

<?= load_js('global/global-functions.js'); ?>

<?= $this->endSection(); ?>