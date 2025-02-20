@include('template/admin/admin')

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    @include('template.notif.notif')
    <div class="content-header">
      <div class="container-fluid">
        <div class="font bungkus-judul-utama"><h1 class="m-0" style="color: #2A8579; font-weight: bold;">Sistem Absensi Siswa</h1></div>
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="pembungkus-konten-utama">
          <div class="row">
            <div class="col-lg-4 col-12">
              <div class="box-konten small-box">
                <div class="inner d-flex">
                  <div class="icon-konten"><i class="fa fa-user" style="font-size: 4.5rem; color: #2A8579;  margin-left: 1.4rem;"></i></div>
                  <div class="tulisan-konten">
                    <h3>Total User</h3>
                    <p class="jumlah-konten fw-medium">{{ $totalUsers }}</p>
                  </div>
                </div>
                <a href="user" class="moreinfo-buset box-footer small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-4 col-12">
              <div class="box-konten small-box">
                <div class="inner d-flex">
                  <div class="icon-konten"><i class="fas fa-school" style="font-size: 4.5rem; color: #2A8579;"></i></div>
                  <div class="tulisan-konten">
                    <h3>Total Kelas</h3>
                    <p class="jumlah-konten fw-medium">{{ $totalClasses }}</p>
                  </div>
                </div>
                <a href="kelas" class="moreinfo-buset box-footer small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-4 col-12">
              <div class="box-konten small-box">
                <div class="inner d-flex">
                  <div class="icon-konten"><i class="fa fa-chalkboard-teacher" style="font-size: 4.5rem; color: #2A8579;"></i></div>
                  <div class="tulisan-konten">
                    <h3>Total Guru</h3>
                    <p class="jumlah-konten fw-medium">{{ $totalTeachers }}</p>
                  </div>
                </div>
                <a href="user" class="moreinfo-buset box-footer small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            {{-- Pemisah --}}

            <div class="tanggal-hari-ini mb-3" style="font-size: 16px; color: #6c757d;">
              {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
            </div>
            
            <div class="col-lg-4 col-12">
              <div class="box-konten small-box">
                <div class="inner d-flex">
                  <div class="icon-konten"><i class="fas fa-user-check" style="font-size: 4.5rem; color: #2A8579;  margin-left: 1.4rem;"></i></div>
                  <div class="tulisan-konten">
                    <h3>Total Hadir</h3>
                    <p class="jumlah-konten">{{ $totalHadir }}</p>
                  </div>
                </div>
                <a href="{{ route('report', ['status' => 'Hadir']) }}" class="moreinfo-buset box-footer small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-4 col-12">
              <div class="box-konten small-box">
                <div class="inner d-flex">
                  <div class="icon-konten"><i class="fas fa-envelope" style="font-size: 4.5rem; color: #2A8579;"></i></div>
                  <div class="tulisan-konten">
                    <h3>Total Izin</h3>
                    <p class="jumlah-konten">{{ $totalIzin }}</p>
                  </div>
                </div>
                <a href="{{ route('report', ['status' => 'Izin']) }}" class="moreinfo-buset box-footer small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-4 col-12">
              <div class="box-konten small-box">
                <div class="inner d-flex">
                  <div class="icon-konten"><i class="fas fa-times-circle" style="font-size: 4.5rem; color: #2A8579;"></i></div>
                  <div class="tulisan-konten">
                    <h3>Total Alpha</h3>
                    <p class="jumlah-konten">{{ $totalAlpha }}</p>
                  </div>
                </div>
                <a href="{{ route('report', ['status' => 'Alpha']) }}" class="moreinfo-buset box-footer small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

@include('template/admin/adminfooter')
