<?php
include_once VIEWS . 'component/jam-card.php';
?>
<h1>Selamat Datang, Admin <strong><?= ucwords($data['user']->adminApa->value) ?></strong></h1>
<br>
<div class="row">
    <div class="col">
        <?= statusCard(
            'card-status',
            'Status Pengumpulan',
            [
                [
                    'type' => 'warning',
                    'icon' => Icons::Document,
                    'title' => '<span id="status-menunggu">Loading...</span>',
                    'subtitle' => 'Dokumen pending',
                    'href' => ''
                ],
                [
                    'type' => 'good',
                    'icon' => Icons::Document,
                    'title' => '<span id="status-diverifikasi">Loading...</span>',
                    'subtitle' => 'Dokumen diverifikasi',
                    'href' => ''
                ],
                [
                    'type' => 'bad',
                    'icon' => Icons::Document,
                    'title' => '<span id="status-ditolak">Loading...</span>',
                    'subtitle' => 'Dokumen ditolak',
                    'href' => ''
                ]
            ]
        ) ?>
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
                const data = JSON.parse(response);
                const total = data.menunggu + data.diverifikasi + data.ditolak;
                document.getElementById("status-menunggu").innerHTML = data.menunggu;
                document.getElementById("status-diverifikasi").innerHTML = data.diverifikasi;
                document.getElementById("status-ditolak").innerHTML = data.ditolak;
            },
            error: function (response) {
                console.error("Error fetching count status: ", response);
            }
        });
    }

    updateStatusCard();

    setInterval(updateStatusCard, 60000); 
</script>