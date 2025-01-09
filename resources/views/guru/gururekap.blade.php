@include('template/user/user')

  <!-- Content Wrapper -->
  <div class="content-wrapper mt-5">
    <div class="content-header">
      <div class="container-fluid">
        <div class="font bungkus-judul-utama"><h1 class="m-0" style="color: #2A8579;">Rekap Absensi Siswa</h1></div>
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="pembungkus-konten-utama">
          <div class="row">
          <div class="search-container col-lg-12 col-12">
                <i class="fa fa-search"></i>
                <input type="search" name="keyword" id="search" class="form-control" placeholder="Search ..." autofocus>
                <!-- <i class="fa fa-times"></i> -->
            </div>
            <div class="container-fluid">
                <div class="row mt-3">
                    <div class="col-md-6 col-6 mb-3">
                        <select class="form-select" id="exampleSelect">
                            <option selected>Pilih Bulan</option>
                            <option value="1">January</option>
                            <option value="1">February</option>
                            <option value="1">March</option>
                            <option value="1">April</option>
                            <option value="1">May</option>
                            <option value="1">June</option>
                            <option value="1">July</option>
                            <option value="1">Agustus</option>
                            <option value="1">Ceptember</option>
                            <option value="1">October</option>
                            <option value="1">Noverber</option>
                            <option value="2">Desember</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-6 mb-3">
                        <select class="form-select" id="exampleSelect">
                            <option selected>Pilih Minggu</option>
                            <option value="1">Opsi 1</option>
                            <option value="2">Opsi 2</option>
                            <option value="3">Opsi 3</option>
                        </select>
                    </div>
                </div>
                <button class="btn btn-ijo-submit bottom mt-auto"><i class="fas fa-file-excel me-2"></i>
                Export</button>          
            </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

@include('template/user/userfooter')
