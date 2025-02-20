<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha3/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('style/home.css') }}">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=Edu+AU+VIC+WA+NT+Pre:wght@400..700&display=swap');

    .font {
      font-family: "Comfortaa", sans-serif;
      margin: 0;
      margin-top: 5px;
    }

    .nav-link-a {
      color: #2A8579 !important;
      transition: 0.3s ease-in-out !important;
    }

    .nav-link-a:hover {
      color: #256F66 !important;
    }

    .nav-link i {
      width: 22px;
      font-size: 18px;
      text-align: center;
    }

    .main-sidebar {
      background-color: white;
    }

    .sidebar {
      background-color: white;
      height: 100vh;
      left: 0;
      top: 0;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
    }

    .info a {
      color: #2A8579 !important;
      opacity: 80%;
    }

    .menu-sidebar {
      max-height: 100vh;
    }

    .brand-link {
      background-color: #2A8579;
    }

    .guru {
      font-size: 10px;
    }

    .logout-section {

      margin-top: auto;
      margin-bottom: 4rem;
    }

    .active {
      background-color: #2A8579 !important;

    }

    .active:hover {
      background-color: #256F66 !important;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top z-3" style="padding: 9.22px;">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="{{ route('dashboard') }}"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed">

      <a href="#" class="brand-link">
        <img class="brand-image img-circle elevation-2" src="{{ asset('img/logohaloges1.png') }}" alt="">
        <span class="font brand-text" style="color: white;">AbsenceGo</span>
      </a>

      <div class="sidebar">
        <!-- User Panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{ asset('img/profile.png') }}" class="img-circle elevation-2" alt="User Image">
          </div>
          @php
          use Illuminate\Support\Str;
          @endphp          
          <div class="info">
            <a href="#" class="d-block">{{ Str::title(auth()->user()->name) }}</a>
            <a href="#" class="guru">{{ Str::title(auth()->user()->role) }}</a>
          </div>
        </div>

        <div class="menu-section">
          <ul class="menu-sidebar nav nav-pills nav-sidebar flex-column" role="menu">
            <li class="nav-item">
              <a href="{{ route('dashboard') }}" class="nav-link active" style="border-radius: 10px;">
                <i class="nav-icon fas fa-home"></i>
                <p style="position: relative; left: 10px;">Dashboard</p>
              </a>
            </li>
            <div class="konten mt-4">
              <div class="brand-text text-ijo" style="font-family: 'Comfortaa', sans-serif;">
                <h4 style="margin-left: 1rem;">Menu Utama</h4>
              </div>
              <li class="nav-item">
                <a href="{{ route('user') }}" class="nav-link nav-link-a" style="margin-left: 4px;">
                  <i class="nav-icon fas fa-user"></i>
                  <p style="margin-left: 2.5px; letter-spacing: 2px;">DaftarUser</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('adminUpdateAbsenPage') }}" class="nav-link nav-link-a" style="margin-left: 4px;">
                  <i class="nav-icon fas fa-clipboard-list"></i>
                  <p style="margin-left: 2.5px; letter-spacing: 2px;">UpdateAbsensi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('class') }}" class="nav-link nav-link-a" style="margin-left: 4px;">
                  <i class="nav-icon fas fa-school"></i>
                  <p style="margin-left: 2.5px; letter-spacing: 2px;">DaftarKelas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('report', ['status' => '']) }}" class="nav-link nav-link-a" style="margin-left: 4px;">
                  <i class="nav-icon fas fa-file-alt"></i>
                  <p style="margin-left: 2.5px; letter-spacing: 2px;">LaporanKehadiran</p>
                </a>
              </li>
            </div>
          </ul>
        </div>

        <div class="logout-section">
          <ul class="nav nav-pills nav-sidebar flex-column">
            <li class="nav-item tombol-logout">
              <hr>
              <a href="{{ route('logout') }}" class="nav-link active" style="border-radius: 10px;"
                data-bs-toggle="modal" data-bs-target="#logoutmodal">
                <i class="nav-icon fas fa-sign-out-alt" style="position: relative; right: 1.5px;"></i>
                <p style="position: relative; left: 10px;">Logout</p>
              </a>
            </li>
          </ul>
        </div>

      </div>

    </aside>
    <!-- /.sidebar -->

    <div class="modal fade" id="logoutmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              <i class="fa fa-exclamation-triangle text-warning"></i>
              Warning !
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Are you sure to logout?
          </div>
          <div class="modal-footer">
            <a href="{{ route('logout') }}" class="btn btn-primary">Yes</a>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
          </div>
        </div>
      </div>
    </div>