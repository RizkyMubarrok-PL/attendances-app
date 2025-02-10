@include('template/user/user')

<!-- Content Wrapper -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="font bungkus-judul-utama">
        <h1 class="m-0" style="color: #2A8579;">Rekap Absensi Siswa</h1>
      </div>
    </div>
  </div>
  <div class="content">
    <div class="container-fluid">
      <div class="pembungkus-konten-utama">
        <div class="row mt-4">
          <form class="search-container col-lg-12 col-12" id="classForm" action="" method="GET">
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

          @if (request('className') != null && $classAttendances->isNotEmpty())
          <div class="col-lg-12 mt-4">
            <label for="rekapSelector" class="form-label text-ijo">
              Pilih Jenis Rekap Absensi
            </label>
            <select class="form-select mt-2" id="rekapSelector" onchange="updateInputFilter()">
              <option selected disabled>Pilih Jenis Rekap</option>
              <option value="tanggal" {{ request('filter')=='tanggal' ? 'selected' : '' }}>Per Tanggal</option>
              <option value="bulan" {{ request('filter')=='bulan' ? 'selected' : '' }}>Per Bulan</option>
            </select>
          </div>
          @endif
        </div>

        <!-- Dynamic Dropdown (Hidden by Default) -->
        @if (request('className') != null && $classAttendances->isNotEmpty())
        <form class="row mt-4" id="filterForm" method="GET" action="">
          <div class="col-lg-12" id="inputTanggal"
            style="{{ request('filter') == 'tanggal' ? 'display: block;' : 'display: none;' }}">
            <label for="">Pilih tanggal</label>
            <input class="form-control" type="date" name="" id="" value="{{ request('filterValue') }}"
              onchange="updateFilterForm(this.value)">
          </div>
          <div class="col-lg-12" id="inputBulan"
            style="{{ request('filter') == 'bulan' ? 'display: block;' : 'display: none;' }}">
            <label for="">Pilih bulan</label>
            <input class="form-control" type="month" name="" id="" value="{{ request('filterValue') }}"
              onchange="updateFilterForm(this.value)">
          </div>
        </form>
        @endif

        @if (request('className') && request('filter') && request('filterValue') && $classAttendances->isNotEmpty())
        <button class="btn btn-ijo-submit bottom mt-4">
          <i class="fas fa-file-excel me-2"></i>
          Export
        </button>
        @endif

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
                  <span class="p-2 rounded text-white bg-info">
                    {{ $attendance->Attendance_Status }}
                  </span>
                </td>
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
      </div>
    </div>
  </div>
</div>
<!-- /.content-wrapper -->

<script>
  function updateInputFilter() {
      const inputFilter = document.getElementById('rekapSelector');
      const inputTanggal = document.getElementById('inputTanggal');
      const inputBulan = document.getElementById('inputBulan');
      
      inputTanggal.style.display = 'none';
      inputBulan.style.display = 'none';
      
      if (inputFilter.value == 'tanggal') {
        inputTanggal.style.display = 'block';
        console.log(inputTanggal);
      }
      
      if (inputFilter.value == 'bulan') {
        inputBulan.style.display = 'block';
        console.log(inputBulan);
      }      
    }
    
    function updateFilterForm(filterValue) {
      const inputFilter = document.getElementById('rekapSelector');
      const filterForm = document.getElementById('filterForm');
      
      filterForm.action = '{{ route('rekapGuruPage', ['className' => request('className'), 'filter' => 'FILTER', 'filterValue' => 'FILTERVALUE']) }}'
      .replace('FILTER', inputFilter.value)
      .replace('FILTERVALUE', filterValue);

      
      filterForm.submit();
    }
    
    function updateActionAndSubmit() {
      const classSelect = document.getElementById('classSelect');
      const classForm = document.getElementById('classForm');

      classForm.action = '{{ route('rekapGuruPage') }}/' + classSelect.value;
      console.log(classForm.action);
      classForm.submit();
    }
</script>

@include('template/user/userfooter')