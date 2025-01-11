<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Siswa</title>
  <!-- <link rel="shortcut icon" href="Aset/logoemsremove.png" type="image/jpg"> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('style/siswa.css') }}">
  <link rel="stylesheet" href="{{ asset('style/siswa.css') }}">
</head>
<body>
  
<header>
    <nav class="navbar navbar-expand-lg bg-white shadow-sm">
        <div class="container-fluid">
          <a class="navbar-brand me-auto font" href="#" style="color: #2A8579;">SiHadir</a>
          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasNavbarLabel" style="color: #2A8579;">SiHadir</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                <li class="nav-item">
                  <a class="nav-link max-lg-2" aria-current="page" href="/siswa">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link max-lg-2" href="{{ route('siswaAbsen') }}">Absensi</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="profile-user">
            <img src="{{ asset('img/anime.png') }}" alt="Profile Picture" class="rounded-circle" width="50" height="50" onclick="toggleMenu()">
          </div>

          <div class="sub-menu-wrap" id="subMenu">
            <div class="sub-menu shadow-sm">
              <div class="user-info">
                <img src="img/anime.png" alt="">
                <h2>Stelle</h2>
              </div>
              <hr>
              <a href="" class="sub-menu-link">
                  <i class="fas fa-sign-out-alt" style="color: #2A8579;"></i>
                  <p>LogOut</p>
                  <span class="fas fa-chevron-right"></span>
              </a>
            </div>
          </div>

          <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
          <span class="navbar-toggler-icon"></span>
        </button>
        </div>
      </nav>
</header>

</body>
</html>