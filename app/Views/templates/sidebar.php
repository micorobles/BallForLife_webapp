<!-- Sidebar -->
<nav id="sidebar" class="text-white sidebar">
    <div class="sidebar-heading py-3">
        <div id='sidebar-profile' class="sidebar-profile p-0 ps-4 rounded d-flex align-items-center">
            <img src="<?= base_url('images/ROBLES.jpg') ?>" alt="">
            <ul class="ms-1" style="list-style-type:none; padding:0; margin:0;">
                <li><span id='username' class="ms-2 medium-text font-sm semi-bold-text">Mico Robles</span></li>
                <li><span id='position' class="ms-2 regular-text font-xs light-text" style="font-weight: 300">Point
                        guard</span></>
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
                <i class="fa fa-align-left"></i>
                <span>Menu Level</span>
            </a>
            <ul class="sub-menu">
                <li><a href="javascript:;">Menu 1.1</a></li>
                <!-- <li><a href="javascript:;">Menu 2.2</a></li> -->
                <li><a href="javascript:;">Menu 2.3</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify">
                <i class="fa fa-angle-double-left" style="font-size: 12px;"></i>
            </a>
        </li>
    </ul>
   


    <!-- <ul class="nav flex-column ps-2">
        <li class="border">
            <a class="text-white" href="<?= base_url('homepage') ?>">
                <i class="fas fa-home fa-1x"></i> <span class="">Home</span>
            </a>
        </li>
        <li class="border">
            <a class="text-white" href="<?= base_url('homepage') ?>">
                <i class="fas fa-people-line fa-1x"></i> <span class="">Feed</span>
            </a>
        </li>
        <li class="border">
            <a class="text-white" href="<?= base_url('homepage') ?>">
                <i class="fas fa-calendar-days fa-1x"></i> <span class="">Schedule</span>
            </a>
        </li>
        <li class="border">
            <a class="text-white" href="#" data-bs-toggle="collapse" data-bs-target="#submenu1"
                aria-expanded="false" aria-controls="submenu1">
                <i class="fas fa-list"></i>
                <span>Menu 1</span>
                <b class="caret"></b>
            </a>
            <div id="submenu1" class="collapse">
                <ul class="nav sub-menu flex-column ms-4">
                    <li class="">
                        <a class="text-white" href="#">
                            <span>Submenu 1.1</span>
                        </a>
                    </li>
                    <li class="">
                        <a class="text-white" href="#">
                            <span>Submenu 1.2</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul> -->





    <!-- <ul class="nav flex-column">
         <li class="nav-item">
             <a class="nav-link text-white" href="#">
                 <i class="fas fa-home"></i> <span>Home</span>
             </a>
         </li>
         <li class="nav-item">
             <a class="nav-link text-white" href="#" data-bs-toggle="collapse" data-bs-target="#submenu1" aria-expanded="false" aria-controls="submenu1">
                 <i class="fas fa-list"></i> <span>Menu 1</span>
             </a>
             <div id="submenu1" class="collapse">
                 <ul class="nav flex-column ms-4">
                     <li class="nav-item">
                         <a class="nav-link text-white" href="#">Submenu 1.1</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link text-white" href="#">Submenu 1.2</a>
                     </li>
                 </ul>
             </div>
         </li>
         <li class="nav-item">
             <a class="nav-link text-white" href="#" data-bs-toggle="collapse" data-bs-target="#submenu2" aria-expanded="false" aria-controls="submenu2">
                 <i class="fas fa-cog"></i> <span>Settings</span>
             </a>
             <div id="submenu2" class="collapse">
                 <ul class="nav flex-column ms-4">
                     <li class="nav-item">
                         <a class="nav-link text-white" href="#">Profile</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link text-white" href="#">Account</a>
                     </li>
                 </ul>
             </div>
         </li>
     </ul> -->
    <!-- <button class="btn btn-secondary mt-3" id="toggleSidebar">Toggle Sidebar</button> -->
</nav>