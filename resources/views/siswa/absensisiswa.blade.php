@include('template/siswa/header')

<main>

    <div class="home-siswa mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-konten-siswa">
                        <h3>Absensi Saya</h3>
                    </div>

                    @error('week')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <p>{{ $message }}</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @enderror

                    <div class="content-home-siswa bg-white shadow-sm rounded mt-5">
                        <div class="pembungkus-home-siswa p-3">
                            <div class="tombol-absen d-flex">
                                <form action="" method="POST" id="filterForm"
                                    class="search-container col-lg-8 col-sm-4">
                                    @csrf
                                    <input type="date" name="date" id="tanggal" class="form-control border" style=""
                                        onchange="inputOnchange('filterForm', '{{ route('absensiDate') }}')">
                                    <input type="month" name="month" id="bulanan" class="form-control border"
                                        style="display: none;"
                                        onchange="inputOnchange('filterForm', '{{ route('absensiMonths') }}')">
                                </form>
                                <div class="filter-container col-lg-4">
                                    <select name="filter" id="filter" class="form-select"
                                        onchange="filterChange('tanggal', 'bulanan', 'filterForm', 'filter')">
                                        <option value="date">Tanggal</option>                                        
                                        <option value="months">Bulanan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-stripped mt-3">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Hari</th>
                                            <th>Nama</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>23-03-2024</td>
                                            <td>Sabtu</td>
                                            <td>Parahmen Brandon</td>
                                            <td>
                                                Alpha
                                                <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#popupModal">
                                                    <i class="fa fa-info-circle"></i>
                                                    <i class="info-tulisan">info</i>
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
    </div>

</main>

<div class="modal fade" id="popupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Keterangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p style="color: #2A8579;">
                    Keterangan absensi siswa: hadir, izin, sakit, atau alpa.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    function filterChange(dateInput, monthInput, filterForm, filterSelect) {
        const date = document.getElementById(dateInput);        
        const month = document.getElementById(monthInput);
        const filter = document.getElementById(filterSelect);

        const filterVal = filter.value;

        date.style.display = 'none';        
        month.style.display = 'none';

        if (filterVal == 'date') {
            date.style.display = 'block';
        } else {
            month.style.display = 'block';
        }
    }
    function inputOnchange(filterForm, actionRoute) {
        const form = document.getElementById(filterForm);

        form.action = actionRoute;
        form.submit();
    }
</script>

@include('template/siswa/footer')