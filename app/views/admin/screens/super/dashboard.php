<?php
include_once VIEWS . 'component/jam-card.php';
?>

<style>
    .card-status {
        flex: 1;
    }
</style>

<h1>Selamat Datang, Admin <strong><?= ucwords($data['user']->adminApa->value) ?></strong></h1>
<br>
<div class="d-flex flex-column" style="gap: 32px;">
    <?php include_once VIEWS . 'admin/template/jam-card.php'; ?>
    <div class="d-flex flex-row flex-wrap align-items-center justify-content-center" style="gap: 32px;">
        <?php
        $urlJurusanSuccess = 'screen?screen=super%2Fpengumpulan_jurusan&filter=selesai';
        $urlJurusanPending = 'screen?screen=super%2Fpengumpulan_jurusan&filter=baru';
        $urlJurusanDanger = 'screen?screen=super%2Fpengumpulan_jurusan&filter=tertanggung';

        $urlPusatSuccess = 'screen?screen=super%2Fpengumpulan_pusat&filter=selesai';
        $urlPusatPending = 'screen?screen=super%2Fpengumpulan_pusat&filter=baru';
        $urlPusatDanger = 'screen?screen=super%2Fpengumpulan_pusat&filter=tertanggung';

        statusCard(
            'card-status-jurusan',
            'Status Pengumpulan Jurusan',
            [
                [
                    'type' => 'success',
                    'icon' => Icons::Check,
                    'title' => '<span id="jurusan-status-diverifikasi">Loading...</span>',
                    'subtitle' => 'Dokumen diverifikasi',
                    'href' => $urlJurusanSuccess
                ],
                [
                    'type' => 'warning',
                    'icon' => Icons::Question,
                    'title' => '<span id="jurusan-status-menunggu">Loading...</span>',
                    'subtitle' => 'Dokumen pending',
                    'href' => $urlJurusanPending
                ],
                [
                    'type' => 'danger',
                    'icon' => Icons::Close,
                    'title' => '<span id="jurusan-status-ditolak">Loading...</span>',
                    'subtitle' => 'Dokumen ditolak',
                    'href' => $urlJurusanDanger
                ]
            ]
        );

        statusCard(
            'card-status-pusat',
            'Status Pengumpulan Pusat',
            [
                [
                    'type' => 'success',
                    'icon' => Icons::Check,
                    'title' => '<span id="pusat-status-diverifikasi">Loading...</span>',
                    'subtitle' => 'Dokumen diverifikasi',
                    'href' => $urlPusatSuccess
                ],
                [
                    'type' => 'warning',
                    'icon' => Icons::Question,
                    'title' => '<span id="pusat-status-menunggu">Loading...</span>',
                    'subtitle' => 'Dokumen pending',
                    'href' => $urlPusatPending
                ],
                [
                    'type' => 'danger',
                    'icon' => Icons::Close,
                    'title' => '<span id="pusat-status-ditolak">Loading...</span>',
                    'subtitle' => 'Dokumen ditolak',
                    'href' => $urlPusatDanger
                ]
            ]
        );
        ?>

    </div>
</div>

<?php
include_once VIEWS . 'admin/template/dashboard-script.php';
?>