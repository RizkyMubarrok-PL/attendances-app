<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teacher Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha3/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('style/home.css') }}">
</head>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=Edu+AU+VIC+WA+NT+Pre:wght@400..700&display=swap');


  .font {
    font-family: "Comfortaa", sans-serif;
    margin: 0;
    margin-top: 5px;
  }

  .main-sidebar{
      background-color: white;
  }

  .sidebar {
      background-color: white;
      height: 100vh;
      left: 0;
      top: 0;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      display: flex;
      flex-direction: column;
  }

  .halo{
    max-height: 100vh;
  }

  .brand-link{
      background-color: #2A8579;
  }

  .guru{
      font-size: 10px;
  }

  .tombol-dashboard {
      background-color: #2A8579; /* Warna latar belakang */
      color: white; /* Warna teks */
      border-radius: 10px; /* Membuat sudut melengkung */
      text-decoration: none; /* Hilangkan garis bawah pada teks */
      transition: 500ms;
  }

  .tombol-dashboard:hover {
      background-color: #256F66; /* Warna latar saat hover */
  }

  .tombol-dashboard i {
      font-size: 18px; /* Ukuran ikon */
  }

  .logout-section {

          margin-top: auto;
          border-top: 1px solid #eee;
          margin-bottom: 4rem ;
      }

      .btn-logout {
          background-color: #2A8579;
          color: white;
          width: 100%;
          border-radius: 10px;
          padding: 0.75rem;
          transition: all 0.3s;
      }

      .btn-logout:hover {
          background-color: #256F66;
          color: white;
      }
</style>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

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

      <a href="#" class="brand-link">
        <img class="brand-image img-circle elevation-2" src="{{ asset('img/logohaloges1.png') }}" alt="">
        <span class="font brand-text" style="color: white;">SiHadir</span>
      </a>

      <div class="sidebar">
        <!-- User Panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{ asset('img/anime.png') }}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">Administrator</a>
            <a href="#" class="guru">Admin</a>
          </div>
        </div>

        <div class="menu-section">
          <ul class="halo nav nav-pills nav-sidebar flex-column" role="menu">
            <li class="nav-item">
              <a href="{{ route('dashboard') }}" class="tombol-dashboard nav-link" style="border-radius: 10px;">
                <i class="nav-icon fas fa-home"></i>
                <p style="position: relative; left: 10px;">Dashboard</p>
              </a>
            </li>
            <div class="konten mt-4">
              <div class="brand-text" style="opacity: 50%; font-family: 'Comfortaa', sans-serif;">
                <h4 style="margin-left: 1rem;">Menu Utama</h4>
              </div>
              <li class="nav-item">
                <a href="{{ route('guruAbsen') }}" class="nav-link">
                  <i style="margin-left: 4px;" class="nav-icon fas fa-home"></i>
                  <p style="margin-left: 2.5px; letter-spacing: 2px;">Absensi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('daftar') }}" class="nav-link">
                  <i style="margin-left: 4px;" class="nav-icon fas fa-home"></i>
                  <p style="margin-left: 2.5px; letter-spacing: 2px;">DaftarAbsensi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('rekap') }}" class="nav-link">
                  <i style="margin-left: 4px;" class="nav-icon fas fa-home"></i>
                  <p style="margin-left: 2.5px; letter-spacing: 2px;">Rekap</p>
                </a>
              </li>
            </div>
          </ul>
        </div>

        <div class="logout-section">
          <ul class="nav nav-pills nav-sidebar flex-column">
          <li class="nav-item tombol-logout">
            <a href="#" class="tombol-dashboard nav-link" style="border-radius: 10px;">
              <i class="nav-icon fas fa-sign-out-alt" style="position: relative; right: 1.5px;"></i>
              <p style="position: relative; left: 10px;">Logout</p>
            </a>
          </li>
          </ul>
        </div>

      </div>

    </aside>
    <!-- /.sidebar -->