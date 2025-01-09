@include('template/siswa/header')

<main>

    <div class="home-siswa mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-konten-siswa">
                        <h3>Absensi Saya</h3>
                    </div>
                    <div class="content-home-siswa bg-white shadow-sm rounded mt-5">
                        <div class="pembungkus-home-siswa p-3">
                            <div class="tombol-absen d-flex">
                                <div class="search-container col-lg-8 col-sm-4">
                                    <i class="fa fa-search"></i>
                                    <input type="search" name="keyword" id="search" class="form-control" placeholder="Search ..." autofocus>
                                    <!-- <i class="fa fa-times"></i> -->
                                </div>
                                <div class="filter-container col-lg-4">
                                    <select name="" id="" class="form-select">
                                        <option value="">-- Pilih Filter --</option>
                                        <option value="minggu">Lihat per-minggu</option>
                                        <option value="hari">Lihat per-hari</option>
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-stripped mt-3">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Hari</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>23-03-2024</td>
                                        <td>Sabtu</td>
                                        <td>Parahmen Brandon</td>
                                        <td>
                                            Alpha
                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#popupModal">
                                              <i class="fa fa-info-circle"></i> 
                                              <i class="info-tulisan">info</i>
                                            </button>
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
    </div>

</main>

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
      <!-- <div class="modal-footer">
        <button type="submit" class="btn btn-ijo">Create</button>
      </div> -->
    </div>
  </div>
</div>

@include('template/siswa/footer')