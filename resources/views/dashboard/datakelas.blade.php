@include('template/admin/admin')

<!-- Content Wrapper -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="font bungkus-judul-utama">
        <h1 class="m-0" style="color: #2A8579;">Daftar Kelas</h1>
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

          @if (session('status'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <p>{{ session('msg') }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif
          @error('user_id')
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p>{{ $message }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @enderror

          <div class="col-12 mt-3">
            <button class="btn btn-ijo" data-bs-toggle="modal" data-bs-target="#createModal">Create</button>
          </div>
          <div class="col-lg-12">
            <div class="table-responsive mt-3">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($classes->isNotEmpty())
                  @foreach ($classes as $class)
                  <tr>
                    <td>#</td>
                    <td>{{ $class->class_name }}</td>
                    <td>
                      <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal"
                        data-bs-target="#updateModal"  data-id="{{ $class->id }}" data-name="{{ $class->class_name }}">Update</button> |
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                        data-id="{{ $class->id }}" data-name="{{ $class->class_name }}">
                        Delete
                      </button>
                    </td>
                  </tr>
                  @endforeach
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

  <!-- Create Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{ route('createClass') }}" method="POST" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Create Kelas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          @csrf
          <div class="form-group">
            <label for="createName">Name :</label>
            <input type="text" class="form-control" name="kelas" id="createName" placeholder="Enter name">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-ijo">Create</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Update Modal -->
  <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{ route('updateClass') }}" method="POST" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Kelas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          @csrf
          @method('PATCH')
          <input type="hidden" name="class_id" id="updateClassId">
            <div class="form-group">
              <label for="updateClassName">Name :</label>
              <input type="text" class="form-control" name="kelas" id="updateClassName" placeholder="Enter name">
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-ijo">Ubah</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Delete Modal -->
  <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{ route('deleteClass') }}" method="POST" id="deleteForm" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Peringatan!</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          @csrf
          @method('DELETE')
          <input type="hidden" name="class_id" value="" id="deleteClassId">
          <p>Anda yakin ingin menghapus <b id="deleteClassName"></b>?</p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Iya</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateModal = document.getElementById('updateModal');
        updateModal.addEventListener('show.bs.modal', function(event) {
            // Button that triggered the modal
            const button = event.relatedTarget;
            
            // Extract info from data-* attributes
            const classId = button.getAttribute('data-id');
            const className = button.getAttribute('data-name');
            
            // Update the modal's content
            const modal = this;
            modal.querySelector('#updateClassId').value = classId;
            modal.querySelector('#updateClassName').value = className;
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function(event) {
            // Button that triggered the modal
            const button = event.relatedTarget;
            
            // Extract info from data-* attributes
            const classId = button.getAttribute('data-id');
            const className = button.getAttribute('data-name');
            
            // Update the modal's content
            const modal = this;
            modal.querySelector('#deleteClassId').value = classId;
            modal.querySelector('#deleteClassName').innerHTML = className;
        });
    });
  </script>

  @include('template/admin/adminfooter')