@include('template/admin/admin')

  <!-- Content Wrapper -->
  <div class="content-wrapper mt-5">
    <div class="content-header">
      <div class="container-fluid">
        <div class="font bungkus-judul-utama"><h1 class="m-0" style="color: #2A8579;">Daftar Kelas</h1></div>
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>XII RPL 1</td>
                                <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal">Update</button> |
                                    <a href="" class="btn btn-danger text-light rounded">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>X DKV 1</td>
                                <td>
                                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal">
                                    Update
                                  </button>
                                    |
                                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    Delete
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
              <input type="text" class="form-control" name="kelas" id="editName" placeholder="Enter name">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-ijo">Create</button>
      </div>
    </div>
  </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
              <input type="text" class="form-control" name="kelas" id="editName" placeholder="Enter name">
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
