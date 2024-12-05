<style>
    #page-content-atas {
        gap: 24px;
        margin-bottom: 30px;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    #page-content-bawah {
        gap: 24px;
        margin-bottom: 30px;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    #status-lulus {
        background-color: var(--bs-body-bg);
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 32px;
        padding: 24px 50px;
        border-radius: 12px;
        width: fit-content;
        height: 300px;
    }
</style>
<div class="d-flex flex-column align-items-start justify-content-center">
    <div class="d-flex flex-row align-items-center justify-content-start" id="page-content-atas">
        <?php
        statusCard(
            'status-toeic',
            'Status Toeic',
            [
                [
                    'type' => 'good',
                    'icon' => Icons::Close,
                    'title' => ' ',
                    'subtitle' => '<p id="dokumen-upload-scan-toeic">',
                    'href' => ''
                ]
            ]
        );
        ?>

        <?php
        statusCard(
            'status-kompen',
            'Status Kompen',
            [
                [
                    'type' => 'good',
                    'icon' => Icons::Check,
                    'title' => ' ',
                    'subtitle' => '<p id="dokumen-surat-bebas-kompen">',
                    'href' => ''
                ]
            ]
        );
        ?>
        <?php
        statusCard(
            'status-ukt',
            'Status Akademik',
            [
                [
                    'type' => 'good',
                    'icon' => Icons::Check,
                    'title' => ' ',
                    'subtitle' => '<p id="dokumen-surat-bebas-tanggungan-akademik-pusat">',
                    'href' => ''
                ]
            ]
        );

        ?>
        <?php
        statusCard(
            'status-ta',
            'Status Tugas Akhir',
            [
                [
                    'type' => 'good',
                    'icon' => Icons::Check,
                    'title' => ' ',
                    'subtitle' => '<p id="dokumen-laporan-skripsi-/-tugas-akhir">',
                    'href' => ''
                ]
            ]
        );
        ?>
        <?php
        statusCard(
            'status-perpus',
            'Status Perpustakaan',
            [
                [
                    'type' => 'good',
                    'icon' => Icons::Check,
                    'title' => ' ',
                    'subtitle' => '<p id="dokumen-surat-bebas-pustaka-dari-perpustakaan-polinema">',
                    'href' => ''
                ]
            ]
        );
        ?>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-start" id="page-content-bawah">
        <div class="d-flex flex-row align-items-center justify-content-start" id="status-perpus">
            <?php
            statusCard(
                'status-perpus',
                'Status Dokumen',
                [
                    [
                        'type' => 'good',
                        'icon' => Icons::Document,
                        'title' => 'Dokumen',
                        'subtitle' => 'terverifikasi',
                        'href' => ''
                    ],
                    [
                        'type' => 'warning',
                        'icon' => Icons::Document,
                        'title' => 'Dokumen',
                        'subtitle' => 'Pending',
                        'href' => ''
                    ],
                    [
                        'type' => 'bad',
                        'icon' => Icons::Document,
                        'title' => 'Dokumen',
                        'subtitle' => 'Ditolak',
                        'href' => ''
                    ]
                ]
            );
            ?>
        </div>
        <div class="d-flex flex-row align-items-center justify-content-start" id="status-lulus">
            <div>
                <h2>Lulus</h2>
                <ul>
                    <li>Surat Rekomendasi Ambil Ijasah</li>
                    <li>lengkap</li>
                    <li>ambil</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    function updateDokumenStatus() {
        $.ajax({
            type: "POST",
            url: "statusDokumen", // Sesuaikan URL dengan controller Anda
            success: function (response) {
                const data = JSON.parse(response);
                // console.log(data)
                // Perbarui status dokumen berdasarkan nama
                data.forEach(dokumen => {
                    const id = `dokumen-${dokumen.nama_dokumen.replace(/\s+/g, '-').toLowerCase()}`;
                    const element = document.getElementById(id);

                    if (element) {
                        // Hanya tampilkan status
                        element.innerText = dokumen.status;

                        // Tambahkan kelas CSS berdasarkan status
                        element.classList.remove('status-good', 'status-warning', 'status-bad');
                        element.classList.add(`status-${dokumen.status.toLowerCase()}`);
                    }
                    // else {
                    //     console.warn(`Element with ID "${id}" not found.`);
                    // }
                });
            },
            error: function (response) {
                console.error("Error fetching dokumen status: ", response);
            }
        });
    }

    // Panggil fungsi pertama kali dan ulangi setiap 60 detik
    updateDokumenStatus();
    setInterval(updateDokumenStatus, 60000);
</script>