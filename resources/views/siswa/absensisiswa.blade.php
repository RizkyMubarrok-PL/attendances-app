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
                                <form action="" method="GET" id="filterForm" class="search-container">
                                    <input type="date" name="" id="tanggal" class="form-control border"
                                        onchange="inputOnchange('tanggal', this.value)">
                                </form>
                            </div>

                            @if ( ($attendance != null || $attendance->isNotEmpty()))
                            <div class="col-12 mb-3 mt-3">
                                {{-- harian --}}
                                <div class="card shadow-sm mb-3 mt-3">
                                    <div
                                        class="card-header d-flex justify-content-between align-items-center {{ $attendance->Attendance_Status == 'Izin' ? 'bg-warning text-dark' : ($attendance->Attendance_Status == 'Alpha' ? 'bg-danger  text-white' : 'bg-success  text-white') }}">
                                        <div class="tanggal-halo">
                                            {{
                                            \Carbon\Carbon::parse($attendance->Attendance_Updated_Date)->locale('id')->translatedFormat('l,
                                            d F Y') }}
                                        </div>

                                        <span class="fw-bold">
                                            {{ $attendance->Attendance_Status ? $attendance->Attendance_Status : 'Belum diabsen.' }}
                                        </span>
                                    </div>
                                    <div class="card-body">
                                    @if($attendance->Attendance_Status)
                                        <button type="button" class="btn btn-info text-white" data-bs-toggle="modal"
                                            data-bs-target="#descModal">
                                            <i class="fa fa-info-circle"></i> Selengkapnya
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="tombol-absen d-flex justify-content-between align-items-center">
                                <form action="" method="GET" id="filterForm" class="search-container">
                                    <input type="month" name="" id="bulanan" class="form-control border"
                                        onchange="inputOnchange('bulan', this.value)">
                                </form>
                            </div>
                            <div class="col-12 mb-3 mt-3">
                                {{-- bulanan --}}
                                <div class="card shadow-sm mb-3 mt-3">
                                    <div
                                        class="card-header bg-ijo d-flex text-white justify-content-between align-items-center">
                                        <div class="tanggal-halo">
                                            {{
                                            \Carbon\Carbon::parse(request('filterValue'))->locale('id')->translatedFormat('F
                                            Y') }}
                                        </div>
                                        <div class="keterangan-tanggal opacity-50">
                                            Bulan
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">
                                            <button class="btn btn-success text-white" data-bs-toggle="modal"
                                                data-bs-target="#descModalHadir">
                                                Hadir
                                                <span class="badge bg-light text-dark">{{ $sumAttendance->Total_Hadir ??
                                                    0 }}</span>
                                            </button>
                                            <button class="btn btn-warning text-dark" data-bs-toggle="modal"
                                                data-bs-target="#descModalIzin">
                                                Izin
                                                <span class="badge bg-light text-dark">{{ $sumAttendance->Total_Izin ??
                                                    0 }}</span>
                                            </button>
                                            <button class="btn btn-danger text-white" data-bs-toggle="modal"
                                                data-bs-target="#descModalAlpha">
                                                Alpha
                                                <span class="badge bg-light text-dark">{{ $sumAttendance->Total_Alpha ??
                                                    0 }}</span>
                                            </button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endif
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
            <div
                class="modal-header {{ $attendance->Attendance_Status == 'Hadir' ? 'bg-success' : 
                                     ($attendance->Attendance_Status == 'Izin' ? 'bg-warning text-dark' : 'bg-danger') }}">
                <h5 class="modal-title {{ $attendance->Attendance_Status != 'Izin' ? 'text-white' : 'text-dark' }}"
                    id="exampleModalLabel">Detail</h5>
                <button type="button"
                    class="btn-close {{ $attendance->Attendance_Status != 'Izin' ? 'btn-close-white' : '' }}"
                    data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row mb-2">
                        <label class="col-sm-4 fw-bold">Tanggal</label>
                        <label class="col-sm-1">:</label>
                        <div class="col-sm-7">{{ date('l, d F Y', strtotime($attendance->Attendance_Created_Date))
                            }}</div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-sm-4 fw-bold">Oleh Guru</label>
                        <label class="col-sm-1">:</label>
                        <div class="col-sm-7">{{ $attendance->Teacher_Name }}</div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-sm-4 fw-bold">Status Kehadiran</label>
                        <label class="col-sm-1">:</label>
                        <div class="col-sm-7">
                            <span
                                class="badge 
                                  {{ $attendance->Attendance_Status == 'Hadir' ? 'bg-success' : 
                                     ($attendance->Attendance_Status == 'Izin' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                {{ $attendance->Attendance_Status }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-4 fw-bold">Keterangan:</label>
                        <label class="col-sm-1">:</label>
                        <div class="col-sm-7">{{ $attendance->Attendance_description ?? 'Tidak ada keterangan'
                            }}</div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="descModalHadir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="max-height: 90vh;">
            <div class="modal-header bg-success">
                <h5 class="modal-title {{ $attendance->Attendance_Status != 'Izin' ? 'text-white' : 'text-dark' }}"
                    id="exampleModalLabel">Detail</h5>
                <button type="button"
                    class="btn-close {{ $attendance->Attendance_Status != 'Izin' ? 'btn-close-white' : '' }}"
                    data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body overflow-auto">
                @if ($hadirAttendance->isNotEmpty())
                <table class="table rounded">
                    <thead class="sticky-top table-success">
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        @foreach ($hadirAttendance as $attendance)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{
                                \Carbon\Carbon::parse($attendance->Attendance_Updated_Date)->locale('id')->translatedFormat('l,
                                d F Y') }}</td>
                            <td>{{ $attendance->Attendance_Status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                Data Kosong
                @endif
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- @dd($hadirAttendance) --}}

<div class="modal fade" id="descModalIzin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="max-height: 90vh;">
            <div class="modal-header bg-warning">
                <h5 class="modal-title {{ $attendance->Attendance_Status != 'Izin' ? 'text-white' : 'text-dark' }}"
                    id="exampleModalLabel">Detail</h5>
                <button type="button"
                    class="btn-close {{ $attendance->Attendance_Status != 'Izin' ? 'btn-close-white' : '' }}"
                    data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body oveflow-auto">
                @if ($izinAttendance->isNotEmpty())
                <table class="table rounded">
                    <thead class="sticky-top table-warning">
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        @foreach ($izinAttendance as $attendance)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{
                                \Carbon\Carbon::parse($attendance->Attendance_Updated_Date)->locale('id')->translatedFormat('l,
                                d F Y') }}</td>
                            <td>{{ $attendance->Attendance_Status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                Data Kosong
                @endif
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="descModalAlpha" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="max-height: 90vh;">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-dark" id="exampleModalLabel">Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body overflow-auto">
                @if ($alphaAttendance->isNotEmpty())
                <table class="table rounded">
                    <thead class="sticky-top table-danger">
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        @foreach ($alphaAttendance as $attendance)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{
                                \Carbon\Carbon::parse($attendance->Attendance_Updated_Date)->locale('id')->translatedFormat('l,
                                d F Y') }}</td>
                            <td>{{ $attendance->Attendance_Status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                Data Kosong
                @endif
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     // Set tanggal otomatis ke hari ini
    //     const today = new Date();
    //     const todayFormatted = today.toISOString().split('T')[0]; // Format YYYY-MM-DD
    //     document.getElementById('tanggal').value = todayFormatted;

    //     // Set bulan otomatis ke bulan ini
    //     const currentYear = today.getFullYear();
    //     const currentMonth = (today.getMonth() + 1).toString().padStart(2, '0'); // Tambahkan 0 jika satu digit
    //     const thisMonthFormatted = `${currentYear}-${currentMonth}`; // Format YYYY-MM
    //     document.getElementById('bulanan').value = thisMonthFormatted;
    // });

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

    function inputOnchange(filter, value) {
        const form = document.getElementById('filterForm');

        form.action = '{{ route('siswaAbsen') }}/FILTER/FILTERVALUE'.replace('FILTER', filter).replace('FILTERVALUE', value);

        console.log(form.action);

        form.submit();
    }

    // document.addEventListener('DOMContentLoaded', function() {
    //     const descMoodal = document.getElementById('descModal');
    //     descMoodal.addEventListener('show.bs.modal', function(event) {
    //         // Button that triggered the modal
    //         const button = event.relatedTarget;
            
    //         // Extract info from data-* attributes
    //         const description = button.getAttribute('data-desc');

    //         console.log(description);
            
    //         // Update the modal's content
    //         const modal = this;
    //         desc = modal.querySelector('#desc')
    //         desc.innerHTML = description;
    //         console.log(desc);
    //     });
    // });
</script>

@include('template/siswa/footer')