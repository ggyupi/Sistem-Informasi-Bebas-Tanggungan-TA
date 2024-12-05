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
        statusCard(
            'card-status-jurusan',
            'Status Pengumpulan Jurusan',
            [
                [
                    'type' => 'good',
                    'icon' => Icons::Check,
                    'title' => '<span id="jurusan-status-diverifikasi">Loading...</span>',
                    'subtitle' => 'Dokumen diverifikasi',
                    'href' => ''
                ],
                [
                    'type' => 'warning',
                    'icon' => Icons::Question,
                    'title' => '<span id="jurusan-status-menunggu">Loading...</span>',
                    'subtitle' => 'Dokumen pending',
                    'href' => ''
                ],
                [
                    'type' => 'bad',
                    'icon' => Icons::Close,
                    'title' => '<span id="jurusan-status-ditolak">Loading...</span>',
                    'subtitle' => 'Dokumen ditolak',
                    'href' => ''
                ]
            ]
        );

        statusCard(
            'card-status-pusat',
            'Status Pengumpulan Pusat',
            [
                [
                    'type' => 'good',
                    'icon' => Icons::Check,
                    'title' => '<span id="pusat-status-diverifikasi">Loading...</span>',
                    'subtitle' => 'Dokumen diverifikasi',
                    'href' => ''
                ],
                [
                    'type' => 'warning',
                    'icon' => Icons::Question,
                    'title' => '<span id="pusat-status-menunggu">Loading...</span>',
                    'subtitle' => 'Dokumen pending',
                    'href' => ''
                ],
                [
                    'type' => 'bad',
                    'icon' => Icons::Close,
                    'title' => '<span id="pusat-status-ditolak">Loading...</span>',
                    'subtitle' => 'Dokumen ditolak',
                    'href' => ''
                ]
            ]
        );
        ?>

    </div>
</div>

<?php
include_once VIEWS . 'admin/template/dashboard-script.php';
?>