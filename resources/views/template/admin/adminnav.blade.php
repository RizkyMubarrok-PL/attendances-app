<!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top z-3" style="padding: 9.22px;">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed">
      <a href="#" class="brand-link text-center">
        <span class="font brand-text" style="color: white;">SiHadir</span>
      </a>
      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{ asset('img/anime.png') }}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">Administrator</a>
            <a href="#" class="guru">Admin</a>
          </div>
        </div>
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
            <li class="nav-item ">
              <a href="/homeadmin " class="tombol-dashboard nav-link" style="border-radius: 10px;">
                <i class="nav-icon fas fa-home" style="position: relative; right: 1.5px;"></i>
                <p style="position: relative; left: 10px;">Dashboard</p>
              </a>
            </li>
            <div class="konten mt-4 ">
                <div class="brand-text" style="opacity: 50%; font-family: 'Comfortaa', sans-serif;"><h4 style="margin-left: 1rem;">Menu Utama</h4></div>
                <li class="nav-item" style="">
                  <a href="user" class="nav-link">
                    <i style="margin-left: 4px;" class="nav-icon fas fa-home"></i>
                    <p style="margin-left: 2.5px; letter-spacing: 2px;">DaftarUser</p>
                  </a>
                </li>
                <li class="nav-item" style="">
                  <a href="kelas" class="nav-link">
                    <i style="margin-left: 4px;" class="nav-icon fas fa-home"></i>
                    <p style="margin-left: 2.5px; letter-spacing: 2px;">DaftarKelas</p>
                  </a>
                </li>
                <li class="nav-item" style="">
                  <a href="user" class="nav-link">
                    <i style="margin-left: 4px;" class="nav-icon fas fa-home"></i>
                    <p style="margin-left: 2.5px; letter-spacing: 2px;">DaftarUser</p>
                  </a>
                </li>
            </div>
            <li class="nav-item tombol-logout">
              <a href="#" class="tombol-dashboard nav-link" style="border-radius: 10px;">
                <i class="nav-icon fas fa-sign-out-alt" style="position: relative; right: 1.5px;"></i>
                <p style="position: relative; left: 10px;">Logout</p>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>