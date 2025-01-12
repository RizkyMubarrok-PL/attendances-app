@include('template/user/user')

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="font bungkus-judul-utama"><h1 class="m-0" style="color: #2A8579;">Absensi Siswa</h1></div>
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

            <div class="col-lg-12 mt-5">
              <div class="filter d-flex justify-content-between align-items-center">

                <div class="filter-left">
                  <select class="form-select" id="filterType">
                    <option value="perhari">Per Hari</option>
                    <option value="perbulan">Per Bulan</option>
                    <option value="persemester">Per Semester</option>
                  </select>
                </div>

                <div class="filter-right">
                  <div id="input-perhari" class="d-none">
                    <input type="date" class="form-control" id="filterDate">
                  </div>
                  <div id="input-perbulan" class="d-none">
                    <select class="form-select" id="filterMonth">
                      <option value="1">Januari</option>
                      <option value="2">Februari</option>
                      <option value="3">Maret</option>
                      <option value="4">April</option>
                      <option value="5">Mei</option>
                      <option value="6">Juni</option>
                      <option value="7">Juli</option>
                      <option value="8">Agustus</option>
                      <option value="9">September</option>
                      <option value="10">Oktober</option>
                      <option value="11">November</option>
                      <option value="12">Desember</option>
                    </select>
                  </div>
                  <div id="input-persemester" class="d-none">
                    <select class="form-select" id="filterSemester">
                      <option value="1">Semester 1</option>
                      <option value="2">Semester 2</option>
                    </select>
                  </div>
                </div>

              </div>
                <div class="table-responsive mt-3">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Brian Mubarok Farel</td>
                                <td>
                                    <div class="d-flex">
                                        <select class="form-select" name="" id="" disabled>
                                            <option value="">Hadir</option>
                                            <option value="">Sakit</option>
                                            <option value="">Izin</option>
                                        </select>
                                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#popupModal">
                                          <i class="fa fa-info-circle"></i> 
                                          <i class="info-tulisan">info</i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Depa Bintang Yeremi</td>
                                <td>
                                    <a href="" class="btn btn-danger text-light rounded">Delete</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

<!-- Pop up Keterangan -->
<div class="modal fade" id="popupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Keterangan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p style="color: #2A8579;">
          Keterangan absensi siswa: hadir, izin, sakit, atau alpa.
        </p>
      </div>
    </div>
  </div>
</div>

@include('template/user/userfooter')
