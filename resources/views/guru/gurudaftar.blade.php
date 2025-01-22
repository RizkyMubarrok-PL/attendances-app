@include('template/user/user')

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="font bungkus-judul-utama"><h1 class="m-0" style="color: #2A8579;">Daftar Absensi</h1></div>
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
            <div class="col-lg-12 mt-3">
                <div class="table-responsive mt-3">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Brian Mubarok Farel</td>
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

<div class="modal fade" id="popupModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <select id="statusSelect" class="form-select" name="status">
              <option value="">Pilih Status</option>
              <option value="hadir">Hadir</option>
              <option value="ijin">Ijin</option>
              <option value="sakit">Sakit</option>
              <option value="alpha">Alpha</option>
            </select>
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

document.addEventListener('DOMContentLoaded', function() {
    // Ambil elemen yang dibutuhkan
    const statusSelect = document.getElementById('statusSelect');
    const keteranganContainer = document.getElementById('keteranganContainer');
    const keteranganTextarea = document.getElementById('keterangan');
    const attendanceForm = document.getElementById('attendanceForm');

    // Event listener untuk perubahan status
    statusSelect.addEventListener('change', function() {
        const selectedStatus = this.value;
        
        // Tampilkan textarea keterangan hanya jika status ijin atau sakit
        if (selectedStatus === 'ijin' || selectedStatus === 'sakit') {
            keteranganContainer.style.display = 'block';
            keteranganTextarea.setAttribute('required', 'required');
        } else {
            keteranganContainer.style.display = 'none';
            keteranganTextarea.removeAttribute('required');
            keteranganTextarea.value = ''; // Reset nilai textarea
        }
    });

    // Event listener untuk form submission
    attendanceForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const status = statusSelect.value;
        const keterangan = keteranganTextarea.value;

        // Validasi form
        if (!status) {
            alert('Silakan pilih status kehadiran');
            return;
        }

        if ((status === 'ijin' || status === 'sakit') && !keterangan.trim()) {
            alert('Silakan isi keterangan');
            return;
        }

        // Di sini Anda bisa menambahkan kode untuk mengirim data ke server
        console.log('Status:', status);
        console.log('Keterangan:', keterangan);
        
        // Tutup modal setelah submit
        const modal = bootstrap.Modal.getInstance(document.getElementById('popupModal'));
        modal.hide();
    });
});

const selectStatus = document.getElementById('statusSelect');
const statusLabel = document.getElementById('statusLabel');

statusLabel.innerHTML = selectStatus.value || 'Status';

selectStatus.addEventListener('change', function() {  
    statusLabel.innerHTML = this.value || 'Status';  
});

</script>

@include('template/user/userfooter')