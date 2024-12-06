<?php
include_once VIEWS . 'component/jam-card.php';
?>
<h1>Selamat Datang, Admin <strong><?= ucwords($data['user']->adminApa->value) ?></strong></h1>
<br>
<div class="d-flex flex-column" style="gap: 26px; overflow: auto;">
    <div class="d-flex flex-row" style="gap: 32px; flex-wrap: wrap;">
        <?php
        $adminTingkat = ucwords($data['user']->adminApa->value);

        $urlSuccess = 'screen?screen=pengumpulan&filter=selesai';
        $urlPending = 'screen?screen=pengumpulan&filter=baru';
        $urlDanger = 'screen?screen=pengumpulan&filter=tertanggung';

        if ($adminTingkat === 'Jurusan') {
            echo statusCard(
                'card-status-jurusan',
                'Status Pengumpulan',
                [
                    [
                        'type' => 'success',
                        'icon' => Icons::Check,
                        'title' => '<span id="jurusan-status-diverifikasi">Loading...</span>',
                        'subtitle' => 'Dokumen diverifikasi',
                        'href' =>  $urlSuccess 
                    ],
                    [
                        'type' => 'warning',
                        'icon' => Icons::Question,
                        'title' => '<span id="jurusan-status-menunggu">Loading...</span>',
                        'subtitle' => 'Dokumen pending',
                        'href' => $urlPending
                    ],
                    [
                        'type' => 'danger',
                        'icon' => Icons::Close,
                        'title' => '<span id="jurusan-status-ditolak">Loading...</span>',
                        'subtitle' => 'Dokumen ditolak',
                        'href' => $urlDanger
                    ]
                ]
            );
        } elseif ($adminTingkat === 'Pusat') {
            echo statusCard(
                'card-status-pusat',
                'Status Pengumpulan',
                [

                    [
                        'type' => 'success',
                        'icon' => Icons::Check,
                        'title' => '<span id="pusat-status-diverifikasi">Loading...</span>',
                        'subtitle' => 'Dokumen diverifikasi',
                        'href' => $urlSuccess 
                    ],
                    [
                        'type' => 'warning',
                        'icon' => Icons::Question,
                        'title' => '<span id="pusat-status-menunggu">Loading...</span>',
                        'subtitle' => 'Dokumen pending',
                        'href' => $urlPending
                    ],
                    [
                        'type' => 'danger',
                        'icon' => Icons::Close,
                        'title' => '<span id="pusat-status-ditolak">Loading...</span>',
                        'subtitle' => 'Dokumen ditolak',
                        'href' => $urlDanger
                    ]
                ]
            );
        }
        include_once VIEWS . 'admin/template/jam-card.php';
        ?>
    </div>
    <h2><Strong>TOP 3</Strong> Dokumen Terbaru</h2>
    <div id="table-wrapper">
        <table class="table table-hover" style="overflow-y: auto;">
            <thead>
                <tr>
                    <th scope="col">NO</th>
                    <th scope="col" style="width: 10%;">NIM</th>
                    <th scope="col" style="width: 35%;">NAMA</th>
                    <th scope="col">JURUSAN</th>
                    <th scope="col">PROGRAM STUDI</th>
                </tr>
            </thead>
            <tbody class="align-middle" id="table-body">

            </tbody>
        </table>
    </div>
</div>

<?php include_once VIEWS . 'admin/template/dashboard-script.php'; ?>