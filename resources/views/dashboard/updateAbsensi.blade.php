@include('template/admin/admin')

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <div class="font bungkus-judul-utama">
        <h1 class="m-0" style="color: #2A8579; font-weight: bold;">Update Absensi</h1>
      </div>

      <div class="tanggal-hari-ini" style="font-size: 16px; color: #6c757d;">
        {{ request('date') != null ? \Carbon\Carbon::parse(request('date'))->locale('id')->translatedFormat('l, d F Y') : \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
      </div>
    </div>
  </div>
  <div class="content">
    <div class="container-fluid">
      <div class="pembungkus-konten-utama">
        <div class="row">
          <form action="" method="GET" class="" id="classForm">
            <div class="search-container col-lg-12 col-12">
            <i class="fa fa-list"></i>
              <select name="" class="form-select-custom form-select" id="classSelect" onchange="updateActionAndSubmit()">
                <option value="">Pilih Kelas</option>
                @foreach ($classData as $class)
                <option value="{{ $class['class']->class_name }}" {{ $class['class']->class_name ==
                  request('className') ?
                  'selected' : ''
                  }}>{{ $class['class']->class_name }}&nbsp; | &nbsp;{{ $class['status'] ? '✔️ Sudah Absen' : '❌ Belum
                  Absen' }}</option>
                @endforeach
              </select>
            </div>

            <div id="input-perhari" class="mt-3"
              style="{{ !request('filter') || request('filter') == 'tanggal' ? 'display: block;' : 'display: none;' }}">
              <input type="date" class="form-control" id="filterDate"
                value="{{ request('date') }}"
                onchange="filterFormActionUpdate(this.value)">
            </div>
          </form>

          <div class="col-lg-12">
            @if (isset($classAttendances) && $classAttendances->isNotEmpty())
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th class="no-column">No</th>
                    <th>Name</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <form action="{{ route('adminUpdateAbsensi') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    @foreach ($classAttendances as $attendances)
                    @php
                    $id = $attendances->Attendance_Id;
                    @endphp
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $attendances->Student_Name }}</td>
                      <td class="text-center">
                        <input type="hidden" name="absensi[{{ $id }}][id]" value="{{ $id }}">

                        <div class="modal fade overflow-hidden h-100" id="popupModal_{{ $id }}"
                          data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                          aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Keterangan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                  id="btnClose_{{ $id }}"></button>
                              </div>
                              <div class="modal-body">
                                <div class="form-group mb-3">
                                  <label for="statusSelect" class="form-label">Status Kehadiran :</label>
                                  <select class="form-select"
                                    onchange="selectActivities(this.id, 'statusLabel_{{ $id }}', 'btnClose_{{ $id }}', 'saveButton_{{ $id }}', 'keteranganContainer_{{ $id }}', 'keterangan_{{ $id }}')"
                                    name="absensi[{{ $id }}][status]" id="statusSelect_{{ $id }}">
                                    <option value="Hadir" {{ $attendances->Attendance_Status == 'Hadir' ? 'selected' :
                                      ''}}>Hadir</option>
                                    <option value="Izin" {{ $attendances->Attendance_Status == 'Izin' ? 'selected' :
                                      ''}}>Izin</option>
                                    <option value="Alpha" {{ $attendances->Attendance_Status == 'Alpha' ? 'selected' :
                                      ''}}>Alpha</option>
                                  </select>
                                </div>

                                <div class="form-group" id="keteranganContainer_{{ $id }}" style="display: none;">
                                  <label for="editName">Keterangan :</label>
                                  <textarea name="absensi[{{ $id }}][keterangan]" rows="4" cols="50"
                                    class="form-control" placeholder="Tulis keterangan Anda di sini"
                                    id="keterangan_{{ $id }}"
                                    oninput="undisabledCloseButton(this.id, 'btnClose_{{ $id }}', 'saveButton_{{ $id }}')">{{ $attendances->Attendance_description }}</textarea>
                                </div>
                              </div>

                              <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="saveButton_{{ $id }}"
                                  data-bs-dismiss="modal">
                                  Simpan Semua
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>

                        <button type="button" class="btn btn-success show-status-modal" data-bs-toggle="modal"
                          data-bs-target="#popupModal_{{ $id }}" id="attendanceButton_{{ $id }}">
                          <i class="fa fa-info-circle"></i>
                          <i class="info-tulisan" id="statusLabel_{{ $id }}">Hadir</i>
                        </button>
                      </td>
                    </tr>
                    @endforeach
                    <div class="tombol-submit mt-3 mb-5">
                      <td class="td-khusus"><input type="submit" value="Simpan" class="btn btn-info"></td>
                    </div>
                  </form>
                </tbody>
              </table>
            </div>
            @elseif (request('className') != null)
            <div class="text-center py-5">
              <i class="fas fa-filter fa-4x text-muted mb-3"></i>
              <div class="mt-3">
                <p class="text-muted">Data kosong</p>
                <p class="text-muted">Tidak ada data absensi untuk kelas "{{ request('className') }}"</p>
              </div>
            </div>
            @else
            <div class="text-center py-5">
              <i class="fas fa-filter fa-4x text-muted mb-3"></i>
              <div class="mt-3">
                <p class="text-muted">Data kosong</p>
                <p class="text-muted">Pilih Kelas untuk menampilkan data</p>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.content-wrapper -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('classSelect');
        const label = document.getElementById('selectedClassLabel');
        
        if (select.value) {
          label.textContent = 'Kelas ' + select.value;
        }
        
        select.addEventListener('change', function() {
          if (this.value) {
            label.textContent = 'Kelas ' + this.value;
          } else {
            label.textContent = '';
          }
        });
      });
  
      function selectDisabledCloseModal(select, closeBtn) {
        const selectStatus = document.getElementById(select);
        const saveButton = document.getElementById(saveBtn);
        const closeButton = document.getElementById(closeBtn);
  
        if (selectStatus.value == 'Izin') {
          closeButton.setAttribute('disabled', true)
          saveButton.setAttribute('disabled', true)
        } else {
          closeButton.removeAttribute('disabled');
          saveButton.removeAttribute('disabled');
        }
      }
  
      function changeStatusLable(select, label) {
        const selectStatus = document.getElementById(select);
        const statusLabel = document.getElementById(label);
      
        statusLabel.innerHTML = selectStatus.value ;    
      }
  
      function selectOpenTextArea (select, textAreaContainer, textArea) {
        const selectStatus = document.getElementById(select);
        const textContainer = document.getElementById(textAreaContainer);
        const text = document.getElementById(textArea);
  
        if (selectStatus.value == 'Izin') {
          textContainer.style.display = 'block';
        } else {
          textContainer.style.display = 'none';
          text.value = '';
        }
      }
      
      function selectActivities (select, label, closeBtn, saveBtn, textAreaContainer, textArea) {
        changeStatusLable(select, label);
        selectDisabledCloseModal(select, closeBtn, saveBtn);
        selectOpenTextArea(select, textAreaContainer, textArea);
      }
  
      function undisabledCloseButton (textArea, closeBtn, saveBtn) {
        const text = document.getElementById(textArea);
        const closeButton = document.getElementById(closeBtn);
        const saveButton = document.getElementById(saveBtn);
  
        if (text.value == '') {
          closeButton.setAttribute('disabled', true)
          saveButton.setAttribute('disabled', true)
        } else {
          closeButton.removeAttribute('disabled');
          saveButton.removeAttribute('disabled');
        }
      }
  
      document.addEventListener("DOMContentLoaded", function () {
      document.querySelectorAll("[id^='statusSelect_']").forEach(function (selectElement) {
          const attendanceId = selectElement.id.split('_')[1]; 
          const statusLabel = document.getElementById(`statusLabel_${attendanceId}`);
          const attendanceButton = document.getElementById(`attendanceButton_${attendanceId}`);
  
          if (statusLabel) {
              statusLabel.innerText = selectElement.value;
          }
  
          // Set button color based on initial status
          setButtonColor(attendanceButton, selectElement.value);
  
          // Menampilkan atau menyembunyikan kolom keterangan jika status "Izin"
          const keteranganContainer = document.getElementById(`keteranganContainer_${attendanceId}`);
          const keteranganTextarea = document.getElementById(`keterangan_${attendanceId}`);
  
          if (selectElement.value === 'Izin') {
              keteranganContainer.style.display = 'block';
              keteranganTextarea.setAttribute('required', 'required');
          } else {
              keteranganContainer.style.display = 'none';
              keteranganTextarea.removeAttribute('required');
              keteranganTextarea.value = '';
          }
  
          // Tambahkan event listener untuk perubahan status secara dinamis
          selectElement.addEventListener('change', function () {
              statusLabel.innerText = this.value;
              setButtonColor(attendanceButton, this.value);
  
              if (this.value === 'Izin') {
                  keteranganContainer.style.display = 'block';
                  keteranganTextarea.setAttribute('required', 'required');
              } else {
                  keteranganContainer.style.display = 'none';
                  keteranganTextarea.removeAttribute('required');
                  keteranganTextarea.value = '';
              }
          });
      });
      });
  
      function setButtonColor(button, status) {
        // Remove all color classes first
        button.classList.remove('btn-success', 'btn-warning', 'btn-danger', 'btn-info');
  
        // Add appropriate color class based on status
        switch(status) {
            case 'Hadir':
                button.classList.add('btn-success');
                break;
            case 'Izin':
                button.classList.add('btn-warning');
                break;
            case 'Alpha':
                button.classList.add('btn-danger');
                break;
            default:
                button.classList.add('btn-info');
        }
      }
  
      function updateActionAndSubmit() {
          var selectedClass = document.getElementById("classSelect").value;
          if (selectedClass) {
              document.getElementById("classForm").action = "{{ route('adminUpdateAbsenPage') }}/" + selectedClass;
          } else {
              document.getElementById("classForm").action = "{{ route('adminUpdateAbsenPage') }}";
          }
          document.getElementById("classForm").submit();
      }

      function filterFormActionUpdate(value) {
        document.getElementById("classForm").action = "{{ route('adminUpdateAbsenPage') }}/{{ request('className') }}/" + value;
        document.getElementById("classForm").submit();
      }
  
</script>

@include('template/admin/adminfooter')