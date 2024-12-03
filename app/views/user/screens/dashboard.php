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
            [[
                'type' => 'good',
                'icon' => Icons::Close,
                'title' => ' ',
                'subtitle' => 'Terverifikasi',
                'href' => ''
            ]]
        );
        ?>

        <?php
        statusCard(
            'status-kompen',
            'Status Kompen',
            [[
                'type' => 'good',
                'icon' => Icons::Check,
                'title' => ' ',
                'subtitle' => 'Terverifikasi',
                'href' => ''
            ]]
        );
        ?>
        <?php
        statusCard(
            'status-ukt',
            'Status UKT',
            [[
                'type' => 'good',
                'icon' => Icons::Check,
                'title' => ' ',
                'subtitle' => 'Terverifikasi',
                'href' => ''
            ]]
        );

        ?>
        <?php
        statusCard(
            'status-skkm',
            'Status SKKM',
            [[
                'type' => 'good',
                'icon' => Icons::Check,
                'title' => ' ',
                'subtitle' => 'Terverifikasi',
                'href' => ''
            ]]
        );
        ?>
        <?php
        statusCard(
            'status-perpus',
            'Perpustakaan',
            [[
                'type' => 'good',
                'icon' => Icons::Check,
                'title' => ' ',
                'subtitle' => 'Terverifikasi',
                'href' => ''
            ]]
        );
        ?>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-start" id="page-content-bawah">
        <div class="d-flex flex-row align-items-center justify-content-start" id="status-perpus">
            <?php
            statusCard(
                'status-perpus',
                'Status Perpustakaan',
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
            <div >
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
    document.getElementById('status-skkm').classList.add('');
    document.getElementById('status-perpus').classList.add('');
</script>