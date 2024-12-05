<?php
include_once VIEWS . 'component/jam-card.php';
?>
<h1>Selamat Datang, Admin <strong><?= ucwords($data['user']->adminApa->value) ?></strong></h1>
<br>
<div class="d-flex flex-row" style="gap: 32px; flex-wrap: wrap;">
    <div class="d-flex flex-column">
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
    <?php include_once VIEWS . 'admin/template/jam-card.php'; ?>
</div>

<?php include_once VIEWS . 'admin/template/dashboard-script.php'; ?>