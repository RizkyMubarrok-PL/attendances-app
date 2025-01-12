@include('template/user/user')

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="font bungkus-judul-utama"><h1 class="m-0" style="color: #2A8579;">Rekap Absensi Siswa</h1></div>
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="pembungkus-konten-utama">
          <div class="row mt-4">
            <div class="search-container col-lg-12 col-12">
                <i class="fa fa-search"></i>
                <input type="search" name="keyword" id="search" class="form-control" placeholder="Search ..." autofocus>
            </div>
            <div class="col-lg-12 mt-4">
              <label for="rekapSelector" class="form-label text-ijo">Pilih filter rekap</label>
              <select class="form-select mt-2" id="rekapSelector">
                <option selected>Pilih Rekap</option>
                <option value="perBulan">Per Bulan</option>
                <option value="perSemester">Per Semester</option>
              </select>
            </div>
          </div>

          <!-- Dynamic Dropdown (Hidden by Default) -->
          <div id="dynamicDropdown" class="row mt-4" style="display: none;">
            <div class="col-lg-12">
              <label for="dynamicSelector" class="form-label text-ijo" id="dynamicLabel"></label>
              <select class="form-select mt-2" id="dynamicSelector">
                <!-- Options will be populated dynamically -->
              </select>
            </div>
          </div>
          <button class="btn btn-ijo-submit bottom mt-4">
              <i class="fas fa-file-excel me-2"></i>
              Export
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

@include('template/user/userfooter')
