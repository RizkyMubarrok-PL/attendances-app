@include('template/admin/admin')

<!-- Content Wrapper -->
<div class="content-wrapper mt-5">
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
                  @if ($users->isNotEmpty())
                  @foreach ($users as $user)
                  <tr>
                    <td>#</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal">
                          Update
                      </button> 
                          |
                      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                          Delete
                      </button>
                    </td>

                    <!-- Update Modal -->
                    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                      aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Update Kelas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form>
                              <div class="form-group">
                                <label for="editName">Name :</label>
                                <input type="text" class="form-control" name="name" id="editName"
                                  placeholder="Enter name">
                              </div>
                              <div class="form-group">
                                <label for="editEmail">Email :</label>
                                <input type="email" class="form-control" name="email" id="editEmail"
                                  placeholder="Enter email">
                              </div>
                              <div class="form-group">
                                <label for="editEmail">Level :</label>
                                <select name="" id="" class="form-select">
                                  <option value="bk">Guru BK</option>
                                  <option value="walas">Guru Walas</option>
                                  <option value="siswa">Guru Siswa</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="editEmail">Kelas :</label>
                                <div class="custom-dropdown">
                                  <select name="" id="" class="form-select">
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
                            </form>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-ijo">Update</button>
                          </div>
                        </div>
                      </div>
                    </div>
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
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Create Kelas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="editName">Name :</label>
              <input type="text" class="form-control" name="name" id="editName" placeholder="Enter name">
            </div>
            <div class="form-group">
              <label for="editEmail">Email :</label>
              <input type="email" class="form-control" name="email" id="editEmail" placeholder="Enter email">
            </div>
            <div class="form-group">
              <label for="editEmail">Level :</label>
              <select name="" id="" class="form-select">
                <option value="bk">Guru BK</option>
                <option value="walas">Guru Walas</option>
                <option value="siswa">Guru Siswa</option>
              </select>
            </div>
            <div class="form-group">
              <label for="editEmail">Kelas :</label>
              <select name="" id="" class="form-select">
                @if ($classes->isNotEmpty())
                @foreach ($classes as $class)
                <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                @endforeach
                @else
                <option value="">Data Kelas Kosong</option>
                @endif
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-ijo">Create</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Modal -->
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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

  @include('template/admin/adminfooter')