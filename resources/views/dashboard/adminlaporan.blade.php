@include('template/admin/admin')

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="font bungkus-judul-utama">
          <h1 class="m-0" style="color: #2A8579; font-weight: bold;">Halaman laporan</h1>
        </div>
        <div class="tanggal-hari-ini" style="font-size: 16px; color: #6c757d;">
          {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </div>
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="pembungkus-konten-utama">
          <div class="row">
            
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

@include('template/admin/adminfooter')
