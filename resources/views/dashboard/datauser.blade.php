@include('template/admin/admin')

<!-- Content Wrapper -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="font bungkus-judul-utama">
        <h1 class="m-0" style="color: #2A8579;">Daftar User</h1>
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
            <!-- <i class="fa fa-times"></i> -->
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
          @error('name')
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p>{{ $message }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @enderror
          @error('password')
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p>{{ $message }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @enderror
          @error('email')
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p>{{ $message }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @enderror
          @error('role')
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p>{{ $message }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @enderror
          @error('class')
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p>{{ $message }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @enderror

          {{-- @if ($errors->any())
          {{ dd($errors) }}
          @endif --}}


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
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  {{-- {{ dd($users) }} --}}
                  @if ($users->isNotEmpty())
                  @foreach ($users as $user)
                  <tr>
                    <td>#</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal"
                        data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                        data-role="{{ $user->role }}"
                        data-class="{{ $user->role == 'siswa' ? ($user->class?->class_id ?? '') : '' }}">
                        Update
                      </button>
                      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        Delete
                      </button>
                    </td>
                  </tr>
                  @endforeach
                  @else
                  <tr>
                    <td>Data kosong</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
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

  <div>
    {{ $users->links('pagination::bootstrap-5') }}
  </div>

  <!-- Create Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{ route('createUser') }}" method="POST" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Create New User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="editName">Name :</label>
            <input type="text" class="form-control" name="name" id="editName" placeholder="Enter name" required>
          </div>
          <div class="form-group">
            <label for="editEmail">Email :</label>
            <input type="email" class="form-control" name="email" id="editEmail" placeholder="Enter email" required>
          </div>
          <div class="form-group">
            <label for="editPassword">Password :</label>
            <input type="password" class="form-control" name="password" id="editPassword" placeholder="Enter password"
              required>
          </div>
          <div class="form-group">
            <label for="editRole">Role :</label>
            <select name="role" id="editRole" class="form-select"
              onchange="OpenSecondDropdownChange('editRole', 'kelasDropDown')" required>
              <option value="admin">Admin</option>
              <option value="guru">Guru</option>
              <option value="siswa">Siswa</option>
            </select>
          </div>
          <div class="form-group" id="kelasDropDown" style="display: none;">
            <label for="editKelas">Kelas :</label>
            <div class="custom-dropdown">
              <select name="class" id="editKelas" class="form-select">
                @if ($classes->isNotEmpty())
                @foreach ($classes as $class)
                <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                @endforeach
                @else
                <option value="">Data Kelas Kosong</option>
                @endif
              </select>
            </div>
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
      <form action="{{ route('updateUser') }}" method="POST" class="modal-content">
        @csrf
        @method('PATCH')
        <input type="hidden" name="user_id" id="updateUserId">
        <div class="modal-header">
          <h5 class="modal-title">Update User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="updateName">Name:</label>
            <input type="text" class="form-control" name="name" id="updateName" required>
          </div>
          <div class="form-group">
            <label for="updateEmail">Email:</label>
            <input type="email" class="form-control" name="email" id="updateEmail" required>
          </div>
          <div class="form-group">
            <label for="updatePassword">Password:</label>
            <input type="password" value="" class="form-control" name="password" id="updatePassword"
              placeholder="Leave blank to keep current password">
          </div>
          <div class="form-group">
            <label for="updateRole">Role:</label>
            <select name="role" id="updateRole" class="form-select"
              onchange="OpenSecondDropdownChange('updateRole', 'updateKelasDropDown')" required>
              <option value="admin">Admin</option>
              <option value="guru">Guru</option>
              <option value="siswa">Siswa</option>
            </select>
          </div>
          <div class="form-group" id="updateKelasDropDown" style="display: none;">
            <label for="updateKelas">Kelas:</label>
            <select name="class" id="updateKelas" class="form-select">
              @foreach ($classes as $class)
              <option value="{{ $class->id }}">{{ $class->class_name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-ijo">Update</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Delete Modal -->
  <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Warning!</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure want to delete?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Yes</button>
          <button type="button" class="btn btn-danger">No</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    function OpenSecondDropdownChange(firstDropdown, secondDropdown) {
        const mainDropdown = document.getElementById(firstDropdown);
        const secondaryDropdown = document.getElementById(secondDropdown);

        // Check if the selected value is "Siswa"
        if (mainDropdown.value === "siswa") {
            secondaryDropdown.style.display = "block"; // Show the second dropdown
        } else {
            secondaryDropdown.style.display = "none"; // Hide the second dropdown
        }
    }
  </script>
  <script>
    // Add this to your existing script section
    document.addEventListener('DOMContentLoaded', function() {
        const updateModal = document.getElementById('updateModal');
        updateModal.addEventListener('show.bs.modal', function(event) {
            // Button that triggered the modal
            const button = event.relatedTarget;
            
            // Extract info from data-* attributes
            const userId = button.getAttribute('data-id');
            const userName = button.getAttribute('data-name');
            const userEmail = button.getAttribute('data-email');
            const userRole = button.getAttribute('data-role');
            const userClass = button.getAttribute('data-class');
            
            // Update the modal's content
            const modal = this;
            modal.querySelector('#updateUserId').value = userId;
            modal.querySelector('#updateName').value = userName;
            modal.querySelector('#updateEmail').value = userEmail;
            modal.querySelector('#updateRole').value = userRole.toLowerCase();
            
            // Handle kelas dropdown visibility
            if(userRole.toLowerCase() === 'siswa') {
              modal.querySelector('#updateKelas').value = userClass;
                modal.querySelector('#updateKelasDropDown').style.display = 'block';
            } else {
                modal.querySelector('#updateKelasDropDown').style.display = 'none';
            }
        });
    });
  </script>
  @include('template/admin/adminfooter')