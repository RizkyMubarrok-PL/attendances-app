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
                            <div class="tombol-absen d-flex justify-content-between align-items-center">
                                <form action="" method="POST" id="filterForm" class="search-container">
                                    @csrf
                                    <input type="date" name="date" id="tanggal" class="form-control border"
                                        onchange="inputOnchange('filterForm', '{{ route('absensiDate') }}')">
                                    <input type="month" name="month" id="bulanan" class="form-control border" style="display: none;"
                                        onchange="inputOnchange('filterForm', '{{ route('absensiMonths') }}')">
                                </form>
                                <div class="filter-container">
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
                                            <th>Nama Guru</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (session('attendances'))
                                            @foreach (session('attendances') as $attendance)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($attendance->Attendance_Created_Date)->format('d-m-Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($attendance->Attendance_Created_Date)->locale('id')->translatedFormat('l'); }}</td>
                                                <td>{{ $attendance->Teacher_Name == null ? '-' : $attendance->Teacher_Name }}</td>
                                                <td>
                                                    
                                                    <button class="btn {{ $attendance->Attendance_Status == 'Izin' ? 'btn-warning' : ($attendance->Attendance_Status == 'Alpha' ? 'btn-danger' : 'btn-success') }}" disabled>
                                                        {{ $attendance->Attendance_Status }}
                                                    </button>

                                                    @if ($attendance->Attendance_Status == 'Izin')
                                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                        data-bs-target="#descModal" data-desc="{{ $attendance->Attendance_description }}">
                                                        <i class="fa fa-info-circle"></i>
                                                        <i class="info-tulisan">info</i>
                                                    </button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            
                                        @endif
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

<div class="modal fade" id="descModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Keterangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p style="color: #2A8579;" id="desc">                    
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    // function filterChange(dateInput, monthInput, filterForm, filterSelect) {
    //     const date = document.getElementById(dateInput);        
    //     const month = document.getElementById(monthInput);
    //     const filter = document.getElementById(filterSelect);

    //     const filterVal = filter.value;

    //     date.style.display = 'none';        
    //     month.style.display = 'none';

    //     if (filterVal == 'date') {
    //         date.style.display = 'block';
    //     } else {
    //         month.style.display = 'block';
    //     }
    // }
    // function inputOnchange(filterForm, actionRoute) {
    //     const form = document.getElementById(filterForm);

    //     form.action = actionRoute;
    //     form.submit();
    // }
    document.addEventListener('DOMContentLoaded', function() {
        // Set tanggal otomatis ke hari ini
        const today = new Date();
        const todayFormatted = today.toISOString().split('T')[0]; // Format YYYY-MM-DD
        document.getElementById('tanggal').value = todayFormatted;

        // Set bulan otomatis ke bulan ini
        const currentYear = today.getFullYear();
        const currentMonth = (today.getMonth() + 1).toString().padStart(2, '0'); // Tambahkan 0 jika satu digit
        const thisMonthFormatted = `${currentYear}-${currentMonth}`; // Format YYYY-MM
        document.getElementById('bulanan').value = thisMonthFormatted;
    });

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

    document.addEventListener('DOMContentLoaded', function() {
        const descMoodal = document.getElementById('descModal');
        descMoodal.addEventListener('show.bs.modal', function(event) {
            // Button that triggered the modal
            const button = event.relatedTarget;
            
            // Extract info from data-* attributes
            const description = button.getAttribute('data-desc');            
            
            // Update the modal's content
            const modal = this;
            modal.querySelector('#desc').value = description;
        });
    });
</script>

@include('template/siswa/footer')