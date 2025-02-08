@include('template/user/user')

<!-- Content Wrapper -->
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
                  {{-- <select class="form-select" id="filterMonth" onchange="">
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
                  </select> --}}
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
                  {{-- {{ dd($classAttendances) }} --}}
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
            <h2>{{ session('message') }}</h2>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

  {{-- <div class="modal fade" id="popupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Keterangan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="attendanceForm">
            <div class="form-group mb-3">
              <label for="statusSelect" class="form-label">Status Kehadiran :</label>
              <input id="statusSelect" type="text" name="status" class="form-control" value="hadir" disabled>
            </div>

            <div class="form-group" id="keteranganContainer" style="display: none;">
              <label for="keterangan" class="form-label">Keterangan :</label>
              <textarea id="keterangan" name="komentar" rows="4" class="form-control"
                placeholder="Tulis keterangan Anda di sini">
              </textarea>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div> --}}

  <script>
    // document.addEventListener('DOMContentLoaded', function () {
  //   // Ambil elemen filter
  //   const filterType = document.getElementById('filterType');
  //   const inputPerHari = document.getElementById('input-perhari');
  //   const inputPerBulan = document.getElementById('input-perbulan');
  //   const inputPerSemester = document.getElementById('input-persemester');
  //   const filterDate = document.getElementById('filterDate');
  //   const filterMonth = document.getElementById('filterMonth');
  //   const filterSemester = document.getElementById('filterSemester');

  //   // Fungsi untuk menyembunyikan semua input filter
  //   function resetFilters() {
  //     inputPerHari.classList.add('d-none');
  //     inputPerBulan.classList.add('d-none');
  //     inputPerSemester.classList.add('d-none');
  //   }

  //   // Set tanggal hari ini
  //   function setDefaultValues() {
  //     const today = new Date();

  //     // Tanggal hari ini
  //     const todayDate = today.toISOString().split('T')[0]; // Format YYYY-MM-DD
  //     filterDate.value = todayDate;

  //     // Bulan saat ini
  //     const currentMonth = today.getMonth() + 1; // Januari dimulai dari 0
  //     filterMonth.value = currentMonth;

  //     // Semester saat ini
  //     const currentSemester = today.getMonth() < 6 ? 1 : 2; // Semester 1 (Jan-Jun), Semester 2 (Jul-Des)
  //     filterSemester.value = currentSemester;
  //   }

  //   // Pilih filter "Per Hari" secara default
  //   function setDefaultFilter() {
  //     filterType.value = 'perhari'; // Set pilihan default
  //     inputPerHari.classList.remove('d-none'); // Tampilkan input "Per Hari"
  //   }

  //   // Event listener untuk perubahan filter
  //   filterType.addEventListener('change', function () {
  //     resetFilters(); // Sembunyikan semua input

  //     // Tampilkan input sesuai dengan pilihan
  //     const selectedValue = filterType.value;
  //     if (selectedValue === 'perhari') {
  //       inputPerHari.classList.remove('d-none');
  //     } else if (selectedValue === 'perbulan') {
  //       inputPerBulan.classList.remove('d-none');
  //     } else if (selectedValue === 'persemester') {
  //       inputPerSemester.classList.remove('d-none');
  //     }
  //   });

  //   // Tambahkan logika untuk menangani filter (opsional)
  //   filterDate?.addEventListener('change', function () {
  //     console.log('Filter Per Hari:', this.value);
  //     // Implementasi logika filter per hari
  //   });

  //   filterMonth?.addEventListener('change', function () {
  //     console.log('Filter Per Bulan:', this.value);
  //     // Implementasi logika filter per bulan
  //   });

  //   filterSemester?.addEventListener('change', function () {
  //     console.log('Filter Per Semester:', this.value);
  //     // Implementasi logika filter per semester
  //   });

  //   // Inisialisasi awal
  //   setDefaultValues(); // Set nilai default untuk tanggal
  //   setDefaultFilter(); // Pastikan filter default adalah "Per Hari"
  // });

  // document.addEventListener('DOMContentLoaded', function () {
  //   const filterType = document.getElementById('filterType');
  //   const tableHead = document.getElementById('tableHead');
  //   const tableBody = document.getElementById('tableBody');

  //   // Data dummy untuk contoh
  //   const dummyData = @json($classAttendances);

  //   // Fungsi untuk merender tabel berdasarkan filter
  //   function renderTable(filterType) {
  //     // Kosongkan tabel
  //     tableHead.innerHTML = '';
  //     tableBody.innerHTML = '';

  //     if (filterType === 'perhari') {
  //       // Header untuk Per Hari
  //       tableHead.innerHTML = `
  //         <tr>
  //           <th>No</th>
  //           <th>Name</th>
  //           <th class="text-center">Status</th>
  //         </tr>
  //       `;

  //       // Data dummy untuk Per Hari
  //       dummyData.forEach((data, index) => {
  //         tableBody.innerHTML += `
  //           <tr>
  //             <td>${index + 1}</td>
  //             <td>${data.Student_Name}</td>
  //             <td class="text-center">
  //               <button type="button" class="btn btn-info show-status-modal" data-bs-toggle="modal" data-bs-target="#popupModal">
  //                 <i class="fa fa-info-circle"></i>${data.Attendance_Status}
  //               </button>
  //             </td>
  //           </tr>
  //         `;
  //       });
  //     } else {
  //       // Header untuk Per Bulan / Per Semester
  //       tableHead.innerHTML = `
  //         <tr>
  //           <th>No</th>
  //           <th>Name</th>
  //           <th>Hadir</th>
  //           <th>Ijin</th>
  //           <th>Sakit</th>
  //           <th>Alpha</th>
  //         </tr>
  //       `;

  //       // Data dummy untuk Per Bulan / Per Semester
  //       dummyData.forEach((data, index) => {
  //         tableBody.innerHTML += `
  //           <tr>
  //             <td>${index + 1}</td>
  //             <td>${data.name}</td>
  //             <td>${data.hadir}</td>
  //             <td>${data.ijin}</td>
  //             <td>${data.sakit}</td>
  //             <td>${data.alpha}</td>
  //           </tr>
  //         `;
  //       });
  //     }
  //   }

  //   // Event listener untuk perubahan filter
  //   filterType.addEventListener('change', function () {
  //     renderTable(this.value);
  //   });

  //   // Render tabel default (Per Hari)
  //   renderTable('perhari');
  // });

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