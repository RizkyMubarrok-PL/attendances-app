@include('template/admin/admin')

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="font bungkus-judul-utama"><h1 class="m-0" style="color: #2A8579; font-weight: bold;">Aplikasi Absensi Siswa</h1></div>
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="pembungkus-konten-utama">
          <div class="row">
            <div class="col-lg-4 col-12">
              <div class="box-konten small-box">
                <div class="inner d-flex">
                  <div class="icon-konten"><i class="fa fa-user" style="font-size: 5.5rem; color: #2A8579;  margin-left: 1.4rem;"></i></div>
                  <div class="tulisan-konten">
                    <h3>Total User</h3>
                    <p class="jumlah-konten">{{ $totalUsers }}</p>
                  </div>
                </div>
                <a href="user" class="moreinfo-buset box-footer small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-4 col-12">
              <div class="box-konten small-box">
                <div class="inner d-flex">
                  <div class="icon-konten"><i class="fas fa-school" style="font-size: 5.5rem; color: #2A8579;"></i></div>
                  <div class="tulisan-konten">
                    <h3>Total Kelas</h3>
                    <p class="jumlah-konten">{{ $totalClasses }}</p>
                  </div>
                </div>
                <a href="kelas" class="box-footer small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-4 col-12">
              <div class="box-konten small-box">
                <div class="inner d-flex">
                  <div class="icon-konten"><i class="fa fa-chalkboard-teacher" style="font-size: 5.5rem; color: #2A8579;"></i></div>
                  <div class="tulisan-konten">
                    <h3>Total Guru</h3>
                    <p class="jumlah-konten">{{ $totalTeachers }}</p>
                  </div>
                </div>
                <a href="user" class="box-footer small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

@include('template/admin/adminfooter')
