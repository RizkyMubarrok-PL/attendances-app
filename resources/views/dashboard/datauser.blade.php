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

          @include('dashboard.Alert')

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
                      <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal"
                        data-bs-target="#updateModal" id="updateBtn" data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                        data-email="{{ $user->email }}" data-role="{{ $user->role }}"
                        data-class="{{ $user->role == 'siswa' ? ($user->studentClass?->class_id ?? '-') : ($user->role == 'guru' ? $user->teacherClasses->pluck('class_id')->implode(', ') : '-') }}">
                        Update
                      </button>
                      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                        data-id="{{ $user->id }}" data-name="{{ $user->name }}">
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

  <!-- Delete Modal -->
  <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{ route('deleteUser') }}" method="POST" id="deleteForm" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Peringatan!</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          @csrf
          @method('DELETE')
          <input type="hidden" name="user_id" value="" id="deleteUserId">
          <p>Anda yakin ingin menghapus <b id="deleteUserName"></b>?</p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Ya</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Create Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{ route('createUser') }}" method="POST" class="modal-content" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Create New User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        @csrf
        <div class="modal-body">
          {{-- name input --}}
          <div class="form-group">
            <label for="createName">Name :</label>
            <input type="text" class="form-control" name="name" id="createName" placeholder="Enter name" required>
          </div>
          {{-- email input --}}
          <div class="form-group">
            <label for="createEmail">Email :</label>
            <input type="email" class="form-control" name="email" id="createEmail" placeholder="Enter email" required>
          </div>
          {{-- password input --}}
          <div class="form-group">
            <label for="createPassword">Password :</label>
            <input type="password" class="form-control" name="password" id="createPassword" placeholder="Enter password"
              required>
          </div>
          {{-- role select input --}}
          <div class="form-group">
            <label for="createRole">Role :</label>
            <select name="role" id="createRole" class="form-select" onchange="OpenSecondDropdownChange('createRole', 'createSiswaClassDropdown', 'createGuruClassDropdown')"
              required>
              <option value="admin">Admin</option>
              <option value="guru">Guru</option>
              <option value="siswa">Siswa</option>
            </select>
          </div>
          <div class="form-group" id="createGuruClassDropdown" style="display: none;">
            <label for="editKelas">Kelas :</label>
            <div class="custom-dropdown d-flex align-items-center gap-2 mb-3"> 
                <select name="class[]" class="form-select">
                    @if ($classes->isNotEmpty())
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                        @endforeach
                    @else
                        <option value="">Data Kelas Kosong</option>
                    @endif
                </select>
                <button type="button" class="btn-custom btn btn-primary addDropdown"
                    onclick="addDropdownField('createGuruClassDropdown', 'dropdownClass')"><i class="font-custom fa-solid fa-plus"></i>
                </button>
            </div>
          </div>        
          <div class="form-group" id="createSiswaClassDropdown" style="display: none;">
            <label for="editKelas">Kelas :</label>
            <div class="custom-dropdown dropdownClass">
              <select name="class" class="form-select">
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
  <div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
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
            <select name="role" id="updateRole" class="form-select" onchange="OpenSecondDropdownChange('updateRole', 'updateSiswaClassDropdown', 'updateGuruClassDropdown')"
              required>
              <option value="admin">Admin</option>
              <option value="guru">Guru</option>
              <option value="siswa">Siswa</option>
            </select>
          </div>
          <div class="form-group" id="updateGuruClassDropdown" style="display: none;">
            <label for="editKelas">Kelas :</label>
            {{-- add btn dropdown --}}
            <div class="custom-dropdown d-flex align-items-center gap-2 mb-3 dropdownClass">
              <select name="class[]" class="form-select">
                @if ($classes->isNotEmpty())
                @foreach ($classes as $class)
                <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                @endforeach
                @else
                <option value="">Data Kelas Kosong</option>
                @endif
              </select>
              <button type="button" class="btn-custom btn btn-primary addDropdown"
                  onclick="addDropdownField('updateGuruClassDropdown', 'dropdownClass')"><i class="font-custom fa-solid fa-plus"></i>
              </button>
            </div>
          </div>
          <div class="form-group" id="updateSiswaClassDropdown" style="display: none;">
            <label for="editKelas">Kelas :</label>
            {{-- add btn dropdown --}}
            <div class="custom-dropdown dropdownClass">
              <select name="class" class="form-select">
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
          <button type="submit" class="btn btn-ijo">Update</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function OpenSecondDropdownChange(roleSelectId, siswaDropdown, guruDropdown) {
      const roleSelect = document.getElementById(roleSelectId);
      classGuru = document.getElementById(guruDropdown);
      classSiswa = document.getElementById(siswaDropdown);

      classSiswa.style.display = 'none';
      classGuru.style.display = 'none';

      const siswaSelect = classSiswa.querySelector('select');
      const guruSelects = classGuru.querySelectorAll('select');
            
      siswaSelect.removeAttribute('name');
      guruSelects.forEach(select => select.removeAttribute('name'));
      
      if (roleSelect.value === 'guru') {
        classGuru.style.display = 'block';
        guruSelects.forEach(select => select.name = 'class[]');
      }
      
      if (roleSelect.value === 'siswa') {
        classSiswa.style.display = 'block';
        siswaSelect.name = 'class';
      }
    }

    function addDropdownField(classContainer, dropdownClass) {
      console.log(true);
      const container = document.getElementById(classContainer);
      const existingDropdowns = container.querySelectorAll('.'+dropdownClass).length;

      const newDropdown = createDropdown(0, existingDropdowns, dropdownClass);

      container.appendChild(newDropdown);
    }

  const classes = {!! $classes->toJson() !!};
  function createDropdown(value, existingDropdowns, dropdownClass) {

    const newDropdown = document.createElement('div');
    newDropdown.className = 'custom-dropdown d-flex align-items-center gap-2 mb-3 mt-3 additionalDropdown ' + dropdownClass;
    newDropdown.id = `newDropdown${existingDropdowns + 1}`;
    
    const newSelect = document.createElement('select');
    newSelect.name = 'class[]'; 
    newSelect.className = 'form-select';
    
    const classes = {!! $classes->toJson() !!};  
    
    if (classes.length > 0) {
        classes.forEach(classItem => {
            const option = document.createElement('option');
            option.value = classItem.id;
            if (option.value === value.toString()) {
                option.selected = true;
            }
            option.textContent = classItem.class_name;
            newSelect.appendChild(option);
        });
    } else {
        const option = document.createElement('option');
        option.value = '';
        option.textContent = 'Data Kelas Kosong';
        newSelect.appendChild(option);
    }

    const deleteButton = document.createElement('button');
    deleteButton.type = 'button';
    deleteButton.className = 'btn-custom btn btn-danger';
    deleteButton.innerHTML = '<i class="font-custom fa-solid fa-xmark"></i>';
    deleteButton.addEventListener('click', () => {
        newDropdown.remove();
    });

    newDropdown.appendChild(newSelect);
    newDropdown.appendChild(deleteButton);    
    return newDropdown;
  }
        
    // update modal logic
  document.addEventListener('DOMContentLoaded', function() {
    const updateModal = document.getElementById('updateModal');
    updateModal.addEventListener('show.bs.modal', function(event) {
      const button = event.relatedTarget;
      const userId = button.getAttribute('data-id');
      const userName = button.getAttribute('data-name');
      const userEmail = button.getAttribute('data-email');
      const userRole = button.getAttribute('data-role');
      const userClass = button.getAttribute('data-class');      
        
      const modal = this;
      modal.querySelector('#updateUserId').value = userId;
      modal.querySelector('#updateName').value = userName;
      modal.querySelector('#updateEmail').value = userEmail;
      modal.querySelector('#updateRole').value = userRole.toLowerCase();

      siswaClass = modal.querySelector('#updateSiswaClassDropdown');
      guruClass = modal.querySelector('#updateGuruClassDropdown');

      const siswaSelect = siswaClass.querySelector('select');
      const guruSelects = guruClass.querySelectorAll('select');
            
      siswaSelect.removeAttribute('name');
      guruSelects.forEach(select => select.removeAttribute('name'));
      
      if (userRole === 'siswa') {
        siswaClass.style.display = 'block';
        
        siswaSelect.value = userClass;
        siswaSelect.name = 'class';
      }      

      if (userRole === 'guru') {
        console.log(typeof userClass);
        arrayUserClass = JSON.parse("["+userClass +"]");
        console.log(arrayUserClass, typeof arrayUserClass);

        // Show the dropdown for updating classes
        guruClass.style.display = 'block';

        
        classSelect = guruClass.querySelector('select');
        // Remove the first element from arrayUserClass
        guruSelects.forEach(select => select.name = 'class[]');

        if (arrayUserClass.length > 1) {
          console.log(true)
          classSelect.value = arrayUserClass[0];

          arrayUserClass.shift();

          dropdownClass = 'dropdownClass';
          existingDropdowns = guruClass.querySelectorAll('.' + dropdownClass).length;

          listClassSelect = [];        
          
          // Use forEach to iterate over arrayUserClass
          arrayUserClass.forEach((classId) => {
              // Add the created dropdown to the list            
              listClassSelect.push(createDropdown(classId, existingDropdowns, dropdownClass));
          });

          // Append the dropdown elements to guruClass
          listClassSelect.forEach((dropdown) => {
              guruClass.appendChild(dropdown);
          });
        } else {
          classSelect.value = arrayUserClass[0];
        }
      }

    });

    updateModal.addEventListener('hidden.bs.modal', function(event) {
        const button = document.getElementById('updateBtn');
        const userRole = button.getAttribute('data-role');
        const modal = this;
        const guruClass = modal.querySelector('#updateGuruClassDropdown');
        
        if (userRole === 'guru' && guruClass) {            
            const additionalSelects = Array.from(guruClass.querySelectorAll('.additionalDropdown'));
            additionalSelectsLength = additionalSelects.length

            additionalSelects.forEach(select => {
              select.remove();                
            });
        }
    });
  });


  // delete modal logic
  document.addEventListener('DOMContentLoaded', function() {
      const deleteModal = document.getElementById('deleteModal');
      deleteModal.addEventListener('show.bs.modal', function(event) {
          const button = event.relatedTarget;
                    
          const userId = button.getAttribute('data-id');
          const userName = button.getAttribute('data-name');
                    
          const modal = this;
          modal.querySelector('#deleteUserId').value = userId;
          modal.querySelector('#deleteUserName').innerHTML = userName;
      });
  });
  </script>
  @include('template/admin/adminfooter')