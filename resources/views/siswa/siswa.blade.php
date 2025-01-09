@include('template/siswa/header')

<main>

    <div class="home-siswa mt-lg-5 mt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="content-home-siswa bg-white shadow-sm rounded">
                        <div class="pembungkus-home-siswa d-flex">
                            <div class="img-siswa m-lg-5 me-lg-0">
                                <img src="img/smkn10.png" alt="">
                            </div>
                            <div class="tulisan-siswa d-flex align-items-center justify-content-center text-center m-lg-5 m-2">
                                <p>Selamat datang di aplikasi absensi siswa SMKN 10 Surabaya!, Aplikasi ini dibuat khusus untuk mempermudah dalam absensi siswa dan mengelola data absensi siswa serta merekap data absensi, Serta dibuat untuk memudahkan para orang tua untuk memantau kehadiran siswa</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid" id="tulisan-content-atas">
                  <div class="row m-lg-5 m-3">
                    <div class="tulisan-atas">
                      <h2>Tentang Aplikasi Absensi SiHadir</h2>
                      <p class="mt-3">Apikasi Absensi SiHadir, dibuat oleh siswa SMKN 10 Surabaya yang bertujuan untuk mempermudah orang tua untuk mengawasi absensi siswa. Orang tua dapat, memantau kehadiran siswa selama perminggu atau perhari.</p>
                    </div>
                    <div class="tombol-content-atas mt-3">
                      <a class="haloges1" href="absensisiswa" class="tombol-contect-atas">
                        Lihat Absensi Siswa
                        <span class="spans fas fa-chevron-right"></span>
                      </a>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>

</main>

@include('template/siswa/footer')
