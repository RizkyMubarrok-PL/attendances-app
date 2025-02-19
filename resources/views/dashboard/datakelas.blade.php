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
          <form method="GET" action="" id="searchForm" class="search-container col-lg-12 col-12">
            <i class="fa fa-search"></i>
            <input type="search" id="search" class="form-control" value="{{ request('keyword') }}"
              placeholder="Search ..." autofocus onkeypress="handleSearch(event)">
          </form>

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
            <button class="btn btn-ijo" data-bs-toggle="modal" data-bs-target="#createModal">
              <i class="fa fa-plus-circle"></i>
              Create
            </button>
          </div>
          <div class="col-lg-12">
            @if ($classes->isNotEmpty())
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
                  @php
                  $iteration = request('page') ? (request('page') - 1) * 20 : null;
                  @endphp
                  @foreach ($classes as $class)
                  <tr>
                    <td>{{ request('page') ? ++$iteration : $loop->iteration }}</td>
                    <td>{{ $class->class_name }}</td>
                    <td>
                      <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal"
                        data-bs-target="#updateModal" data-id="{{ $class->id }}" data-name="{{ $class->class_name }}">
                        <i class="fa fa-pen-to-square"></i>
                        Update
                      </button>
                      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                        data-id="{{ $class->id }}" data-name="{{ $class->class_name }}">
                        <i class="fa fa-trash"></i>
                        Delete
                      </button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            @else
            <div class="text-center py-5">
              <i class="fas fa-filter fa-4x text-muted mb-3"></i>
              <div class="mt-3">
                <p class="text-muted">Pencarian tidak menemukan hasil.</p>
                <p class="text-muted">Tidak ada kelas dengan nama "{{ request('keyword') }}".</p>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

  <div>
    {{ $classes->links('pagination::bootstrap-5') }}
  </div>

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
          <button type="submit" class="btn btn-ijo">
            <i class="fa fa-plus-circle"></i>
            Create
          </button>
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
          <button type="submit" class="btn btn-warning text-white">
            <i class="fa fa-pen-to-square"></i>
            Update
          </button>
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
          <h5 class="modal-title" id="staticBackdropLabel">
            <i class="fa fa-exclamation-triangle text-warning"></i>
            Peringatan!
          </h5>
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

    function handleSearch(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            let searchInput = document.getElementById('search').value;
            document.getElementById('searchForm').action = "{{ route('searchClass') }}/" + encodeURIComponent(searchInput);
            document.getElementById('searchForm').submit();
        }
    }
  </script>

  @include('template/admin/adminfooter')