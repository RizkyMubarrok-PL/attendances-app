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
                <a href="kelas" class="moreinfo-buset box-footer small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                <a href="user" class="moreinfo-buset box-footer small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-12 col-12">
              <div class="box-konten small-box">
                <div class="inner">
                  <h3 style="color: #2A8579; font-weight: bold;" class="font text-center fs-3 mt-2">Status Absensi Siswa</h3><hr>
                  <div class="row mt-3">
                    <div class="col-lg-4 col-12">
                      <div class="tulisan-konten d-flex align-items-center">
                        <i class="laporan-icon bi bi-check-circle text-success me-2"></i>
                        <div>
                          <h3 class="fk font text-success">Total Kehadiran</h3>
                          <p class="jumlah-konten text-success">{{ $totalClasses }}</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4 col-12">
                      <div class="tulisan-konten d-flex align-items-center">
                        <i class="laporan-icon bi bi-exclamation-circle text-warning me-2"></i>
                        <div>
                          <h3 class="fk font text-warning">Total Izin</h3>
                          <p class="jumlah-konten text-warning">{{ $totalClasses }}</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4 col-12">
                      <div class="tulisan-konten d-flex align-items-center">
                        <i class="laporan-icon bi bi-x-circle text-danger me-2"></i>
                        <div>
                          <h3 class="fk font text-danger">Total Alpha</h3>
                          <p class="jumlah-konten text-danger">{{ $totalClasses }}</p>
                        </div>
                      </div>
                    </div>                    
                  </div>
                </div>
                <a href="laporan" class="moreinfo-buset box-footer small-box-footer">View more <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>  
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

@include('template/admin/adminfooter')
