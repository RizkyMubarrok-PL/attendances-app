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
                        <thead id="tableHead">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <tr>
                                <td>1</td>
                                <td>Depa</td>
                                <td class="text-center">
                                  <button type="button" class="btn btn-info show-status-modal" data-bs-toggle="modal" data-bs-target="#popupModal">
                                    <i class="fa fa-info-circle"></i> 
                                    <i class="info-tulisan" id="statusLabel">Status</i>
                                  </button>                                  
                                </td>
                            </tr>
                            <tr>
                              <td>2</td>
                              <td>Haloges1</td>
                              <td class="text-center">
                                <button type="button" class="btn btn-info show-status-modal" data-bs-toggle="modal" data-bs-target="#popupModal">
                                  <i class="fa fa-info-circle"></i> 
                                  <i class="info-tulisan" id="statusLabel">Status</i>
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
  <!-- /.content-wrapper -->

  <div class="modal fade" id="popupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
              <textarea id="keterangan" name="komentar" rows="4" class="form-control" placeholder="Tulis keterangan Anda di sini">
              </textarea>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

<script>

document.addEventListener('DOMContentLoaded', function () {
  // Ambil elemen filter
  const filterType = document.getElementById('filterType');
  const inputPerHari = document.getElementById('input-perhari');
  const inputPerBulan = document.getElementById('input-perbulan');
  const inputPerSemester = document.getElementById('input-persemester');
  const filterDate = document.getElementById('filterDate');
  const filterMonth = document.getElementById('filterMonth');
  const filterSemester = document.getElementById('filterSemester');

  // Fungsi untuk menyembunyikan semua input filter
  function resetFilters() {
    inputPerHari.classList.add('d-none');
    inputPerBulan.classList.add('d-none');
    inputPerSemester.classList.add('d-none');
  }

  // Set tanggal hari ini
  function setDefaultValues() {
    const today = new Date();

    // Tanggal hari ini
    const todayDate = today.toISOString().split('T')[0]; // Format YYYY-MM-DD
    filterDate.value = todayDate;

    // Bulan saat ini
    const currentMonth = today.getMonth() + 1; // Januari dimulai dari 0
    filterMonth.value = currentMonth;

    // Semester saat ini
    const currentSemester = today.getMonth() < 6 ? 1 : 2; // Semester 1 (Jan-Jun), Semester 2 (Jul-Des)
    filterSemester.value = currentSemester;
  }

  // Pilih filter "Per Hari" secara default
  function setDefaultFilter() {
    filterType.value = 'perhari'; // Set pilihan default
    inputPerHari.classList.remove('d-none'); // Tampilkan input "Per Hari"
  }

  // Event listener untuk perubahan filter
  filterType.addEventListener('change', function () {
    resetFilters(); // Sembunyikan semua input

    // Tampilkan input sesuai dengan pilihan
    const selectedValue = filterType.value;
    if (selectedValue === 'perhari') {
      inputPerHari.classList.remove('d-none');
    } else if (selectedValue === 'perbulan') {
      inputPerBulan.classList.remove('d-none');
    } else if (selectedValue === 'persemester') {
      inputPerSemester.classList.remove('d-none');
    }
  });

  // Tambahkan logika untuk menangani filter (opsional)
  filterDate?.addEventListener('change', function () {
    console.log('Filter Per Hari:', this.value);
    // Implementasi logika filter per hari
  });

  filterMonth?.addEventListener('change', function () {
    console.log('Filter Per Bulan:', this.value);
    // Implementasi logika filter per bulan
  });

  filterSemester?.addEventListener('change', function () {
    console.log('Filter Per Semester:', this.value);
    // Implementasi logika filter per semester
  });

  // Inisialisasi awal
  setDefaultValues(); // Set nilai default untuk tanggal
  setDefaultFilter(); // Pastikan filter default adalah "Per Hari"
});

document.addEventListener('DOMContentLoaded', function () {
  const filterType = document.getElementById('filterType');
  const tableHead = document.getElementById('tableHead');
  const tableBody = document.getElementById('tableBody');

  // Data dummy untuk contoh
  const dummyData = [
    { name: 'Brian Mubarok Farel', hadir: 20, ijin: 5, sakit: 3, alpha: 2 },
    { name: 'Liana Kartika', hadir: 18, ijin: 4, sakit: 2, alpha: 1 },
    { name: 'Andi Saputra', hadir: 22, ijin: 3, sakit: 1, alpha: 0 },
  ];

  // Fungsi untuk merender tabel berdasarkan filter
  function renderTable(filterType) {
    // Kosongkan tabel
    tableHead.innerHTML = '';
    tableBody.innerHTML = '';

    if (filterType === 'perhari') {
      // Header untuk Per Hari
      tableHead.innerHTML = `
        <tr>
          <th>No</th>
          <th>Name</th>
          <th class="text-center">Status</th>
        </tr>
      `;

      // Data dummy untuk Per Hari
      dummyData.forEach((data, index) => {
        tableBody.innerHTML += `
          <tr>
            <td>${index + 1}</td>
            <td>${data.name}</td>
            <td class="text-center">
              <button type="button" class="btn btn-info show-status-modal" data-bs-toggle="modal" data-bs-target="#popupModal">
                <i class="fa fa-info-circle"></i> Status
              </button>
            </td>
          </tr>
        `;
      });
    } else {
      // Header untuk Per Bulan / Per Semester
      tableHead.innerHTML = `
        <tr>
          <th>No</th>
          <th>Name</th>
          <th>Hadir</th>
          <th>Ijin</th>
          <th>Sakit</th>
          <th>Alpha</th>
        </tr>
      `;

      // Data dummy untuk Per Bulan / Per Semester
      dummyData.forEach((data, index) => {
        tableBody.innerHTML += `
          <tr>
            <td>${index + 1}</td>
            <td>${data.name}</td>
            <td>${data.hadir}</td>
            <td>${data.ijin}</td>
            <td>${data.sakit}</td>
            <td>${data.alpha}</td>
          </tr>
        `;
      });
    }
  }

  // Event listener untuk perubahan filter
  filterType.addEventListener('change', function () {
    renderTable(this.value);
  });

  // Render tabel default (Per Hari)
  renderTable('perhari');
});

</script>

@include('template/user/userfooter')
