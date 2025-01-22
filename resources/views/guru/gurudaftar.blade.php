@include('template/user/user')

<!-- Content Wrapper -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="font bungkus-judul-utama">
        <h1 class="m-0" style="color: #2A8579;">Daftar Absensi</h1>
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
            <input type="search" name="classKeyword" id="searchInput" list="classes" class="form-control"
              placeholder="Search ..." autofocus autocomplete="on">
            <datalist id="classes" style="max-height: 50vh; overflow-y: scroll;">
              @foreach ($allClasses as $class)
              <option value="{{ $class->class_name }}">
                @endforeach
            </datalist>
          </form>

          <div class="col-lg-12 mt-3">
            <div class="table-responsive mt-3">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                @if (session('classAttendances'))
                <tbody>
                  <form action="{{ route('updateAbsen') }}" method="POST">
                    @csrf
                    @foreach (session('classAttendances') as $attendances)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $attendances->Student_Name }}</td>
                      <td>
                        <input type="hidden" name="absensi[{{ $attendances->Attendance_Id }}][id]"
                          value="{{ $attendances->Attendance_Id }}">
                        <div class="d-flex">
                          <select class="form-select" name="absensi[{{ $attendances->Attendance_Id }}][status]" id="">
                            <option value="Hadir" {{ $attendances->Attendance_Status == 'Hadir' ? 'selected' : ''
                              }}>Hadir</option>
                            <option value="Izin" {{ $attendances->Attendance_Status == 'Izin' ? 'selected' : '' }}>Izin
                            </option>
                            <option value="Alpha" {{ $attendances->Attendance_Status == 'Alpha' ? 'selected' : ''
                              }}>Alpha</option>
                          </select>

                          <!-- Pop up Keterangan -->
                          <div class="modal fade" id="popupModal_{{ $attendances->Attendance_Id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Keterangan</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <div class="form-group">
                                    <label for="editName">Keterangan
                                      :</label>
                                    <textarea name="absensi[{{ $attendances->Attendance_Id }}][keterangan]" rows="4"
                                      cols="50" class="form-control" placeholder="Tulis keterangan Anda di sini">{{ $attendances->Attendance_description }}</textarea>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <button type="button" class="btn btn-info" data-bs-toggle="modal"
                            data-bs-target="#popupModal_{{ $attendances->Attendance_Id }}">
                            <i class="fa fa-info-circle"></i>
                            <i class="info-tulisan">info</i>
                          </button>
                        </div>
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
                @else
                @endif
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

  <!-- Pop-up -->
  <div class="popup-container" id="popupContainer">
    <div class="popup-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Keterangan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      </div>
    </div>
  </div>

  @include('template/user/userfooter')