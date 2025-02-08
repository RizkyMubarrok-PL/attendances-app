@include('template/admin/admin')

  <!-- Content Wrapper -->  
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="font bungkus-judul-utama">
          <h1 class="m-0" style="color: #2A8579; font-weight: bold;">Halaman laporan</h1>
        </div>
        <div class="tanggal-hari-ini" style="font-size: 16px; color: #6c757d;">
          {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
        </div>
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="pembungkus-konten-utama">
          <div class="row">
            <form action="{{ route('reportSearch', ['status' => request('status')]) }}" method="POST" class="search-container col-lg-12 col-12">
              @csrf
              <i class="fa fa-search"></i>              
              <input type="search" name="search" id="search" class="form-control" placeholder="Search ..." value="{{ request('search') }}" autofocus>
            </form>
            <div class="col-lg-12">
              <div class="table-responsive mt-3">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Name</th>
                      <th>Teacher Name</th>
                      <th>Kelas</th>
                      <th>Status</th>
                      <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if ($attendances->isNotEmpty())
                    @foreach ($attendances as $attendance)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $attendance->Student_Name }}</td>
                        <td>{{ $attendance->Teacher_Name == null ? '-' : $attendance->Teacher_Name }}</td>
                        <td>{{ $attendance->Class_Name }}</td>
                        <td>{{ $attendance->Attendance_Status }}</td>
                        <td>
                          <button type="button" class="btn btn-info show-status-modal" data-bs-toggle="modal" data-bs-target="#popupModal">
                            <i class="fa fa-info-circle"></i> 
                            <i class="info-tulisan" id="statusLabel">Status</i>
                          </button>
                        </td>
                      </tr>
                    @endforeach                    
                    @else
                    <tr>
                      <td>Data kosong</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    @endif
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

  <div>
    {{ $attendances->links('pagination::bootstrap-5') }}
  </div>

@include('template/admin/adminfooter')
