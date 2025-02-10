@include('template/user/user')

<!-- Content Wrapper -->
{{-- @dd(session('message')) --}}
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="font bungkus-judul-utama">
        <h1 class="m-0" style="color: #2A8579;">Absensi Siswa</h1>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <div class="pembungkus-konten-utama">
        <div class="row">

          <form class="search-container col-lg-12 col-12" id="classForm">
            <i class="fa fa-list"></i>
            <select name="" class="form-select" id="classSelect" onchange="updateActionAndSubmit()">
              <option value="">Pilih Kelas</option>
              @foreach ($allClasses as $class)
              <option value="{{ $class->classData->class_name }}" {{ $class->classData->class_name ==
                request('className') ?
                'selected' : ''
                }}>{{ $class->classData->class_name }}</option>
              @endforeach
            </select>
          </form>
          <div class="col-lg-12 mt-5">
            @if (request('className'))
            <div class="filter d-flex justify-content-between align-items-center">

              <div class="filter-left">
                <select class="form-select" id="filterType" onchange="updateFilterAndFormAction()">
                  <option value="perhari" {{ request('filter')=='tanggal' ? 'selected' : '' }}>Per Hari</option>
                  <option value="perbulan" {{ request('filter')=='bulan' ? 'selected' : '' }}>Per Bulan</option>
                </select>
              </div>

              <form id="filterForm" class="filter-right"
                action="{{ !request('filter') || request('filter') == 'tanggal' ? route('listAbsenPage', ['className' => request('className')]) . '/tanggal/' : route('listAbsenPage', ['className' => request('className')]) . '/bulan/' }}"
                method="POST">
                @csrf
                <div id="input-perhari"
                  style="{{ !request('filter') || request('filter') == 'tanggal' ? 'display: block;' : 'display: none;' }}">
                  <input type="date" class="form-control" id="filterDate"
                    value="{{ request('filter') == 'tanggal' ? request('filterValue') : '' }}"
                    onchange="filterFormActionUpdate(this.value)">
                </div>
                <div id="input-perbulan"
                  style="{{ request('filter') == 'bulan' ? 'display: block;' : 'display: none; ' }}">
                  <input type="month" class="form-control" id="filterMonth"
                    value="{{ request('filter') == 'bulan' ? request('filterValue') : '' }}"
                    onchange="filterFormActionUpdate(this.value)">
                </div>
              </form>
            </div>
            @endif

            @if ($classAttendances->isNotEmpty())
            <div class="table-responsive mt-3">
              <table class="table table-hover">
                <thead id="tableHead">
                  <tr>
                    @if (request('filter') == null || request('filter') == 'tanggal')
                    <th>No</th>
                    <th>Name</th>
                    <th class="text-center">Status</th>
                    @else
                    <th>No</th>
                    <th>Name</th>
                    <th>Hadir</th>
                    <th>Ijin</th>
                    <th>Alpha</th>
                    @endif
                  </tr>
                </thead>
                <tbody id="tableBody">
                  @foreach ($classAttendances as $attendance)
                  <tr>
                    @if (request('filter') == null || request('filter') == 'tanggal')
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $attendance->Student_Name }}</td>
                    <td class="text-center">
                      <button type="button" class="btn btn-info show-status-modal" data-bs-toggle="modal"
                        data-bs-target="#modalKeterangan{{ $attendance->id }}">
                        <i class="fa fa-info-circle"></i>
                        <i class="info-tulisan" id="statusLabel">{{ $attendance->Attendance_Status }}</i>
                      </button>

                    </td>
                    <div class="modal fade" id="modalKeterangan{{ $attendance->id }}" tabindex="-1">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Keterangan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="container">
                              <div class="row mb-2">
                                <label class="col-sm-4 fw-bold">Nama Siswa</label>
                                <label class="col-sm-1">:</label>
                                <div class="col-sm-7">{{ $attendance->Student_Name }}</div>
                              </div>

                              <div class="row mb-2">
                                <label class="col-sm-4 fw-bold">Kelas</label>
                                <label class="col-sm-1">:</label>
                                <div class="col-sm-7">{{ $attendance->Class_Name }}</div>
                              </div>

                              <div class="row mb-2">
                                <label class="col-sm-4 fw-bold">Tanggal</label>
                                <label class="col-sm-1">:</label>
                                <div class="col-sm-7">{{ date('d F Y', strtotime($attendance->Attendance_Created_Date))
                                  }}</div>
                              </div>

                              <div class="row mb-2">
                                <label class="col-sm-4 fw-bold">Status Kehadiran</label>
                                <label class="col-sm-1">:</label>
                                <div class="col-sm-7">
                                  <span
                                    class="badge 
                                            {{ $attendance->Attendance_Status == 'Hadir' ? 'bg-success' : 
                                               ($attendance->Attendance_Status == 'Izin' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                    {{ $attendance->Attendance_Status }}
                                  </span>
                                </div>
                              </div>

                              <div class="row">
                                <label class="col-sm-4 fw-bold">Keterangan:</label>
                                <label class="col-sm-1">:</label>
                                <div class="col-sm-7">{{ $attendance->Attendance_description ?? 'Tidak ada keterangan'
                                  }}</div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    @else
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $attendance->Student_Name }}</td>
                    <td>{{ $attendance->Total_Hadir }}</td>
                    <td>{{ $attendance->Total_Izin }}</td>
                    <td>{{ $attendance->Total_Alpha }}</td>
                    @endif
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            @else
            Data kosong.
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

  <script>
  function updateFilterAndFormAction() {
    const filterSelect = document.getElementById('filterType');
    const filterHarian = document.getElementById('input-perhari');
    const filterBulanan = document.getElementById('input-perbulan');
    const formFilter = document.getElementById('filterForm');

    filterHarian.style.display = 'none';
    filterBulanan.style.display = 'none';

    if (filterSelect.value == 'perhari') {
      filterHarian.style.display = 'block';
      formFilter.action = '{{ route('listAbsenPage') }}/{{ request('className')}}/tanggal/';
    }

    if (filterSelect.value == 'perbulan') {
      filterBulanan.style.display = 'block';
      formFilter.action = '{{ route('listAbsenPage') }}/{{ request('className')}}/bulan/';
    }
  }

  function filterFormActionUpdate(value) {    
    const formFilter = document.getElementById('filterForm');

    formFilter.action = formFilter.action + value;
    formFilter.submit();
  }

  function updateActionAndSubmit() {
        var selectedClass = document.getElementById("classSelect").value;
        if (selectedClass) {
            document.getElementById("classForm").action = "{{ route('listAbsenPage') }}/" + selectedClass;
        } else {
            document.getElementById("classForm").action = "{{ route('listAbsenPage') }}";
        }
        document.getElementById("classForm").submit();
  }

  </script>
  @include('template/user/userfooter')