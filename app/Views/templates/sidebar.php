 <!-- Sidebar -->
 <nav id="sidebar" class="bg-dark text-white">
     <div class="sidebar-heading text-center py-4">
         <i class="fas fa-user-circle"></i>
         <span>My Sidebar</span>
     </div>
     <ul class="nav flex-column">
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
     </ul>
     <button class="btn btn-secondary mt-3" id="toggleSidebar">Toggle Sidebar</button>
 </nav>