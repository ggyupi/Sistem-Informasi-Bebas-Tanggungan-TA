<?php
include_once VIEWS . 'component/jam-card.php';
?>
<h1>Selamat Datang, Admin <strong><?= ucwords($data['user']->adminApa->value) ?></strong></h1>
<br>
<div class="row">
    <div class="col">
        <?php
        $adminTingkat = ucwords($data['user']->adminApa->value);

        if ($adminTingkat === 'Jurusan') {
            echo statusCard(
                'card-status-jurusan',
                'Status Pengumpulan',
                [
                    [
                        'type' => 'warning',
                        'icon' => Icons::Document,
                        'title' => '<span id="jurusan-status-menunggu">Loading...</span>',
                        'subtitle' => 'Dokumen pending',
                        'href' => ''
                    ],
                    [
                        'type' => 'good',
                        'icon' => Icons::Document,
                        'title' => '<span id="jurusan-status-diverifikasi">Loading...</span>',
                        'subtitle' => 'Dokumen diverifikasi',
                        'href' => ''
                    ],
                    [
                        'type' => 'bad',
                        'icon' => Icons::Document,
                        'title' => '<span id="jurusan-status-ditolak">Loading...</span>',
                        'subtitle' => 'Dokumen ditolak',
                        'href' => ''
                    ]
                ]
            );
        } elseif ($adminTingkat === 'Pusat') {
            echo statusCard(
                'card-status-pusat',
                'Status Pengumpulan',
                [
                    [
                        'type' => 'warning',
                        'icon' => Icons::Document,
                        'title' => '<span id="pusat-status-menunggu">Loading...</span>',
                        'subtitle' => 'Dokumen pending',
                        'href' => ''
                    ],
                    [
                        'type' => 'good',
                        'icon' => Icons::Document,
                        'title' => '<span id="pusat-status-diverifikasi">Loading...</span>',
                        'subtitle' => 'Dokumen diverifikasi',
                        'href' => ''
                    ],
                    [
                        'type' => 'bad',
                        'icon' => Icons::Document,
                        'title' => '<span id="pusat-status-ditolak">Loading...</span>',
                        'subtitle' => 'Dokumen ditolak',
                        'href' => ''
                    ]
                ]
            );
        } elseif ($adminTingkat === 'Super') {
            echo statusCard(
                'card-status-super',
                'Status Pengumpulan',
                [
                    [
                        'type' => 'warning',
                        'icon' => Icons::Document,
                        'title' => '<span id="super-status-menunggu">Loading...</span>',
                        'subtitle' => 'Dokumen pending',
                        'href' => ''
                    ],
                    [
                        'type' => 'good',
                        'icon' => Icons::Document,
                        'title' => '<span id="super-status-diverifikasi">Loading...</span>',
                        'subtitle' => 'Dokumen diverifikasi',
                        'href' => ''
                    ],
                    [
                        'type' => 'bad',
                        'icon' => Icons::Document,
                        'title' => '<span id="super-status-ditolak">Loading...</span>',
                        'subtitle' => 'Dokumen ditolak',
                        'href' => ''
                    ]
                ]
            );
        }
        ?>

    </div>
    <div class="col">
        <?= jamCard(
            'jam-card',
            '<span id="clock">Loading...</span>',
            '<span id="date">Loading...</span>'
        ) ?>
        <script>
            function addZero(i) {
                return i < 10 ? "0" + i : i;
            }
            function startTime() {
                const today = new Date();
                const d = today.getDate();
                const mo = today.getMonth() + 1;
                const y = today.getFullYear();
                const h = today.getHours();
                const m = addZero(today.getMinutes());
                const s = addZero(today.getSeconds());
                document.getElementById("clock").innerHTML = `${h}:${m}:${s}`;
                document.getElementById("date").innerHTML = `${d}/${mo}/${y}`;
                setTimeout(startTime, 1000);
            }
            startTime();
        </script>

    </div>
</div>
<br>

<script>
    function updateStatusCard() {
        $.ajax({
            type: "POST",
            url: "AdminController/getCountStatus",
            success: function (response) {
                try {
                    const data = JSON.parse(response);

                    // Variabel yang dirender dari PHP ke JavaScript
                    const adminTingkat = "<?= $adminTingkat ?>";

                    if (adminTingkat === 'Jurusan') {
                        document.getElementById("jurusan-status-menunggu").innerText = data.Jurusan.menunggu || 0;
                        document.getElementById("jurusan-status-diverifikasi").innerText = data.Jurusan.diverifikasi || 0;
                        document.getElementById("jurusan-status-ditolak").innerText = data.Jurusan.ditolak || 0;
                    } else if (adminTingkat === 'Pusat') {
                        document.getElementById("pusat-status-menunggu").innerText = data.Pusat.menunggu || 0;
                        document.getElementById("pusat-status-diverifikasi").innerText = data.Pusat.diverifikasi || 0;
                        document.getElementById("pusat-status-ditolak").innerText = data.Pusat.ditolak || 0;
                    } else {
                        document.getElementById("super-status-menunggu").innerText =
                            (parseInt(data.Pusat.menunggu || 0, 10) + parseInt(data.Jurusan.menunggu || 0, 10));
                        document.getElementById("super-status-diverifikasi").innerText =
                            (parseInt(data.Pusat.diverifikasi || 0, 10) + parseInt(data.Jurusan.diverifikasi || 0, 10));
                        document.getElementById("super-status-ditolak").innerText =
                            (parseInt(data.Pusat.ditolak || 0, 10) + parseInt(data.Jurusan.ditolak || 0, 10));

                    }
                } catch (error) {
                    console.error("Error parsing JSON or processing data: ", error);
                }
            },
            error: function (response) {
                console.error("Error fetching count status: ", response);
            }
        });
    }

    // Panggil fungsi pertama kali dan ulangi setiap 60 detik
    updateStatusCard();
    setInterval(updateStatusCard, 60000);
</script>