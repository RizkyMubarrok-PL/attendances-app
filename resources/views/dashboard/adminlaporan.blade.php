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
            <div class="search-container col-lg-12 col-12">
                <i class="fa fa-search"></i>
                <input type="search" name="keyword" id="search" class="form-control" placeholder="Search ..." autofocus>
            </div>
            <div class="col-lg-12">
              <div class="table-responsive mt-3">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Kelas</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>Halo</td>
                      <td>Mahkotahati12@gmail.com</td>
                      <td>XII RPL 4</td>
                      <td>Alpha</td>
                    </tr>
                    {{-- @endforeach
                    @else
                    <tr>
                      <td>Data kosong</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    @endif --}}
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

@include('template/admin/adminfooter')
