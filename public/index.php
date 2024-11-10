<?php
if (isset($_POST['loginkan'])) {
    require_once '../app/core/App.php';
    require_once '../app/core/Controller.php';
    $app = new App();
    exit;
}
?>

<!DOCTYPE html>
<html data-bs-theme="dark">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="../assets/js/jquery-3.7.1.js"></script>
    <link
        rel="stylesheet"
        type="text/css"
        media="screen"
        href="../assets/css/bootstrap-5.3.3.css" />
    <script src="../assets/js/bootstrap-5.3.3.js"></script>
    <link
        rel="stylesheet"
        type="text/css"
        media="screen"
        href="../assets/css/index.css" />
    <title>Landing Page</title>
</head>

<body class="custom-container" style="padding: 24px 0px">
    <div id="banner-wrapper">
        <div id="baner-bg-top">
            <div class="banner-bg"></div>
        </div>
        <a
            id="code-on-github"
            href="https://github.com/sukinnamz/Sistem-Informasi-Bebas-Tanggungan-TA">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="52"
                height="52"
                viewBox="0 0 24 24">
                <path
                    fill="currentColor"
                    d="M12 2A10 10 0 0 0 2 12c0 4.42 2.87 8.17 6.84 9.5c.5.08.66-.23.66-.5v-1.69c-2.77.6-3.36-1.34-3.36-1.34c-.46-1.16-1.11-1.47-1.11-1.47c-.91-.62.07-.6.07-.6c1 .07 1.53 1.03 1.53 1.03c.87 1.52 2.34 1.07 2.91.83c.09-.65.35-1.09.63-1.34c-2.22-.25-4.55-1.11-4.55-4.92c0-1.11.38-2 1.03-2.71c-.1-.25-.45-1.29.1-2.64c0 0 .84-.27 2.75 1.02c.79-.22 1.65-.33 2.5-.33s1.71.11 2.5.33c1.91-1.29 2.75-1.02 2.75-1.02c.55 1.35.2 2.39.1 2.64c.65.71 1.03 1.6 1.03 2.71c0 3.82-2.34 4.66-4.57 4.91c.36.31.69.92.69 1.85V21c0 .27.16.59.67.5C19.14 20.16 22 16.42 22 12A10 10 0 0 0 12 2" />
            </svg>
            <h4 class="fw-bolder">Code on Github &lt;/&gt;</h4>
        </a>

        <div id="banner">
            <div id="banner-left">
                <img class="container" src="../assets/imgs/KawaiiLogoV1.svg" />
                <h5>
                    x Basis Data Lanjut x Manajemen Proyek x PBO x<br />x Desain dan
                    Pemrograman web x
                </h5>
                <a href="#login-go" class="button-go" id="bawa-aku-login">
                    <h6>Bawa Aku ke Login Tuan</h6>
                    <svg
                        fill="white"
                        xmlns="http://www.w3.org/2000/svg"
                        width="32"
                        height="18"
                        viewBox="0 0 16 9">
                        <path
                            fill="currentColor"
                            d="M12.5 5h-9c-.28 0-.5-.22-.5-.5s.22-.5.5-.5h9c.28 0 .5.22.5.5s-.22.5-.5.5" />
                        <path
                            fill="currentColor"
                            d="M10 8.5a.47.47 0 0 1-.35-.15c-.2-.2-.2-.51 0-.71l3.15-3.15l-3.15-3.15c-.2-.2-.2-.51 0-.71s.51-.2.71 0l3.5 3.5c.2.2.2.51 0 .71l-3.5 3.5c-.1.1-.23.15-.35.15Z" />
                    </svg>
                </a>
            </div>

            <div id="banner-right">
                <div class="container card">
                    <div class="card-body" id="members">
                        <h5 class="card-title">Anggota Kelompok</h5>
                        <div class="member">
                            <div class="member-picture">
                                <img src="../assets/imgs/anggota/Raruu.webp" />
                            </div>
                            <div class="member-info">
                                <h6>Beryl Funky Mubarok</h6>
                                <h6>xxxxxxxxxxxxx</h6>
                            </div>
                        </div>

                        <div class="member">
                            <div class="member-picture">
                                <img src="../assets/imgs/anggota/Raruu.webp" />
                            </div>
                            <div class="member-info">
                                <h6>Candra Ahmad Dani</h6>
                                <h6>xxxxxxxxxxxx</h6>
                            </div>
                        </div>

                        <div class="member">
                            <div class="member-picture">
                                <img src="../assets/imgs/anggota/Raruu.webp" />
                            </div>
                            <div class="member-info">
                                <h6>Hidayat Widi Saputra</h6>
                                <h6>2341720157</h6>
                            </div>
                        </div>

                        <div class="member">
                            <div class="member-picture">
                                <img src="../assets/imgs/anggota/Raruu.webp" />
                            </div>
                            <div class="member-info">
                                <h6>Innama Maesa Putri</h6>
                                <h6>23417202035</h6>
                            </div>
                        </div>

                        <div class="member">
                            <div class="member-picture">
                                <img src="../assets/imgs/anggota/Raruu.webp" />
                            </div>
                            <div class="member-info">
                                <h6>Muhammad Nur Aziz</h6>
                                <h6>2341720237</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container" id="what-they-can-do">
        <h1 class="fw-bolder">What they can do?</h1>
        <div class="container-fluid" id="what-they-card-wrapper">
            <div class="card">
                <h3 class="fw-bold">User</h3>
                <ul>
                    <li>
                        Menampilkan Tanggungan:
                        <ul>
                            <li>Perpustakaan</li>
                            <li>Laporan Tugas Akhir atau skripsi</li>
                            <li>Akademik Pusat (UKT, SKKM)</li>
                            <li>Kompensasi</li>
                        </ul>
                    </li>
                    <li>Laporan magang</li>
                    <li>Sertifikat TOEIC</li>
                    <li>Formulir online</li>
                    <li>Pemantauan Status Pengajuan</li>
                    <li>Notifikasi Real-Time</li>
                    <li>Unduh Surat Keterangan Bebas Tanggungan</li>
                </ul>
            </div>

            <div class="card">
                <h3 class="fw-bold">Admin</h3>
                <ul>
                    <li>
                        Manajemen Data Tanggungan, Mengelola data:
                        <ul>
                            <li>Peminjaman dan Pengembalian Perpustakaan</li>
                            <li>Laporan Tugas Akhir dan magang</li>
                            <li>Data Pembayaran, Tagihan, dan Keringanan Biaya</li>
                            <li>Data Sertifikat TOEIC</li>
                        </ul>
                    </li>
                    <li>Verifikasi Pengajuan Surat Bebas Tanggungan</li>
                    <li>Pengelolaan Data Mahasiswa</li>
                    <li>Pengelolaan Dokumen Bebas Tanggungan</li>
                    <li>Manajemen Akun Admin</li>
                    <li>Integrasi Data dan Notifikasi</li>
                </ul>
            </div>
        </div>

        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <button class="button-go" id="login-go" type="submit" name="loginkan">
                <svg
                    fill="transparent"
                    xmlns="http://www.w3.org/2000/svg"
                    width="32"
                    height="1"
                    viewBox="0 0 16 9"></svg>Login
                <svg
                    fill="white"
                    xmlns="http://www.w3.org/2000/svg"
                    width="32"
                    height="18"
                    viewBox="0 0 16 9">
                    <path
                        fill="currentColor"
                        d="M12.5 5h-9c-.28 0-.5-.22-.5-.5s.22-.5.5-.5h9c.28 0 .5.22.5.5s-.22.5-.5.5" />
                    <path
                        fill="currentColor"
                        d="M10 8.5a.47.47 0 0 1-.35-.15c-.2-.2-.2-.51 0-.71l3.15-3.15l-3.15-3.15c-.2-.2-.2-.51 0-.71s.51-.2.71 0l3.5 3.5c.2.2.2.51 0 .71l-3.5 3.5c-.1.1-.23.15-.35.15Z" />
                </svg>
            </button>
        </form>


        <div id="baner-bg-bottom">
            <div class="banner-bg"></div>
        </div>
    </div>
</body>

</html>