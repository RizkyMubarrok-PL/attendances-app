@include('template/user/user')

<!-- Content Wrapper -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <div class="font bungkus-judul-utama">
        <h1 class="m-0" style="color: #2A8579; font-weight: bold;">Daftar Absensi</h1>
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
          <form action="{{ route('getAbsen') }}" method="POST" class="search-container col-lg-12 col-12">
            @csrf
            <i class="fa fa-search"></i>
            {{-- <input type="search" name="classKeyword" id="searchInput" list="classes" class="form-control"
              placeholder="Search ..." autofocus autocomplete="on"> --}}
            {{-- <datalist id="classes" style="max-height: 50vh; overflow-y: scroll;">
              @foreach ($allClasses as $class)
              <option value="{{ $class->classData->class_name }}">
                @endforeach
            </datalist> --}}

            <select name="class" id="">
              <option value="">Pilih Kelas</option>
              @foreach ($allClasses as $class)
              <option value="{{ $class->classData->id }}">{{ $class->classData->class_name }}</option>
              @endforeach
            </select>
          </form>

          <div class="col-lg-12 mt-3">
            @if (session('classAttendances'))
            <div class="table-responsive mt-3">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th class="no-column">No</th>
                    <th>Name</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <form action="{{ route('updateAbsen') }}" method="POST">
                    @csrf
                    @foreach (session('classAttendances') as $attendances)
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
                                    onchange="selectActivities(this.id, 'statusLabel_{{ $id }}', 'btnClose_{{ $id }}', 'keteranganContainer_{{ $id }}', 'keterangan_{{ $id }}')"
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
                                    oninput="undisabledCloseButton(this.id, 'btnClose_{{ $id }}')">{{ $attendances->Attendance_description }}</textarea>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        {{-- <button type="button" class="btn btn-info show-status-modal" data-bs-toggle="modal"
                          data-bs-target="#popupModal_{{ $id }}">
                          <i class="fa fa-info-circle"></i>
                          <i class="info-tulisan" id="statusLabel_{{ $id }}">Hadir</i>
                        </button> --}}
                        <button type="button" 
                              class="btn btn-success show-status-modal" 
                              data-bs-toggle="modal" 
                              data-bs-target="#popupModal_{{ $id }}"
                              id="attendanceButton_{{ $id }}">
                        <i class="fa fa-info-circle"></i>
                        <i class="info-tulisan" id="statusLabel_{{ $id }}">Hadir</i>
                      </button>
                      </td>
                    </tr>
                    @endforeach
                    <tr>
                      <td><input type="submit" value="Simpan" class="btn btn-info"></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </form>
                </tbody>
              </table>
            </div>
            @else
            {{-- Data kosong --}}
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->


  <script>
    function selectDisabledCloseModal(select, closeBtn) {
      const selectStatus = document.getElementById(select);
      const closeButton = document.getElementById(closeBtn);

      if (selectStatus.value == 'Izin') {
        closeButton.setAttribute('disabled', true)
      } else {
        closeButton.removeAttribute('disabled');
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
    
    function selectActivities (select, label, closeBtn, textAreaContainer, textArea) {
      changeStatusLable(select, label);
      selectDisabledCloseModal(select, closeBtn);
      selectOpenTextArea(select, textAreaContainer, textArea);
    }

    function undisabledCloseButton (textArea, closeBtn) {
      const text = document.getElementById(textArea);
      const closeButton = document.getElementById(closeBtn);

      if (text.value == '') {
        closeButton.setAttribute('disabled', true)
      } else {
        closeButton.removeAttribute('disabled');
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


  </script>
@include('template/user/userfooter')