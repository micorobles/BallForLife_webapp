<!-- Sidebar -->
<nav id="sidebar" class="text-white sidebar">
    <div class="sidebar-heading py-3">
        <div id='sidebar-profile' class="sidebar-profile p-0 ps-4 rounded d-flex align-items-center">
            <img id="sidebar-profilePic" src="<?= base_url( session()->get('profilePic') )  ?>" alt="">
            <ul class="ms-1" style="list-style-type:none; padding:0; margin:0;">
                <li>
                    <span id='username' class="ms-2 medium-text font-sm semi-bold-text">
                        <?= ucfirst(session()->get('firstname')) . ' ' . ucfirst(session()->get('lastname')) ?>
                    </span>
                </li>
                <li>
                    <span id='position' class="ms-2 regular-text font-xs light-text" style="font-weight: 300">
                        <?= session()->get('position') ?>
                    </span>
                </li>
            </ul>
        </div>
    </div>

    <!-- <ul class="nav">
        <li class="nav-header">Navigation</li>
        <li class="has-sub">
            <a href="javascript:;">
                <b class="caret"></b>
                <i class="fa fa-home"></i>
                <span>Home</span>
            </a>
            <ul class="sub-menu">
                <li class="active"><a href="index.html">Dashboard v1</a></li>
                <li><a href="index_v2.html">Dashboard v2</a></li>
                <li><a href="index_v3.html">Dashboard v3</a></li>
            </ul>
        </li>
    </ul> -->

    <ul class="nav">
        <li class="nav-header">Navigation</li>
        <li class="">
            <a href="<?= base_url('homepage') ?>">
                <i class="fas fa-home fa-1x"></i>
                <span>Home</span>
            </a>
        </li>
        <li>
            <a href="<?= base_url('schedule') ?>">
                <i class="fas fa-calendar-days fa-1x"></i>
                <span>Schedule</span>
            </a>
        </li>
        <li>
            <a href="javascript:;">
                <i class="fas fa-people-line fa-1x"></i>
                <span>Feed</span>
            </a>
        </li>
        <li class="has-sub">
            <a href="javascript:;">
                <b class="caret"></b>
                <i class="fa fa-align-left"></i>
                <span>Menu Level</span>
            </a>
            <ul class="sub-menu">
                <li><a href="javascript:;">s</a></li>
                <!-- <li><a href="javascript:;">Menu 2.2</a></li> -->
                <li><a href="javascript:;">Menu 2.3</a></li>
            </ul>
        </li>
        <li class="has-sub">
            <a href="javascript:;">
                <b class="caret"></b>
                <i class="fa fa-gears"></i>
                <span>Maintenance</span>
            </a>
            <ul class="sub-menu">
                <li><a href="<?= base_url('userMaster') ?>">Users Master</a></li>
                <!-- <li><a href="javascript:;">Menu 2.2</a></li> -->
                <li><a href="javascript:;">Schedules Master</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify">
                <i class="fa fa-angle-double-left" style="font-size: 12px;"></i>
            </a>
        </li>
    </ul>
</nav>