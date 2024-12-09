<!-- Header content -->
<!-- <header class="bg-primary text-white text-center"> -->
<header class="header container-fluid px-4 bg-white text-black border-bottom">
    <div class="row">
        <div class="header-brand col-xl-2 col-lg-3 col-md-4 col-sm-12 col-12  logo d-flex align-items-center font-lg p-1">

            <a href="<?= base_url('homepage') ?>" class="header-logo">
                <i class="fa-solid fa-basketball fa-1x me-1"></i>
                <span class="">Ball for Life</span>
            </a>

            <button type="button" class="header-toggle" data-click="sidebar-toggled">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="col-xl-8 col-lg-6 col-md-4 col-sm-7 col-7  d-flex align-items-center justify-content-end">
            <div class="" style="width: 150px;"></div>
        </div>
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-5 col-5 d-flex align-items-center justify-content-end p-1">
            <div class="btn-group">
                <div id='profile' class="profile p-1 px-2 rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">

                    <img id="header-profilePic" src="<?= session()->get('profilePic') ?>" alt="">
                    <span id="header-fullName" class="ms-1 medium-text font-sm regular-text">
                         <?= ucfirst(session()->get('firstname')) . ' ' . ucfirst(session()->get('lastname')) ?>    
                    </span>
                    <!-- <i class="fa-solid fa-caret-down ms-2"></i> -->
                </div>

                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?= base_url('profile/' . session()->get('ID') )?>">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Messages</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a id='btnLogout' class="dropdown-item" href="#" style="display: block !important;">Logout</a></li>
                </ul>

            </div>
        </div>
    </div>
</header>
<!-- </header> -->