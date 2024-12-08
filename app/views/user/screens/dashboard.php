<style>
    #page-content-wrapper {
        gap: 32px;
        align-items: center;
        justify-content: center;
    }

    .page-content {
        gap: 16px;
        width: 100%;
        flex-direction: row;
        align-items: center;
        /* justify-content: start; */
        flex-wrap: wrap;
    }

    #status-lulus {
        font-size: 24px;
        font-weight: 600;
        margin: 0px;
        flex: 1;
        height: 100%;
        border-radius: 12px;
        display: none;
    }

    #status-lulus h2 {
        font-size: 24px;
        font-weight: 600;
        margin: 0px;
    }


    #status-lulus svg {
        width: 50%;
        height: 50%;
    }
</style>
<div class="d-flex flex-column align-items-center justify-content-center">
    <div class="d-flex flex-column" id="page-content-wrapper">
        <div class="w-100 d-flex flex-row align-items-center justify-content-start">
            <h1>Overview <strong><?= $data['user']->getPeopleName() ?></strong></h1>
        </div>
        <div class="d-flex flex-row page-content">
            <?php
            statusCard(
                'dokumen-7',
                'Status Toeic',
                [
                    [
                        'type' => 'success',
                        'icon' => Icons::Close,
                        'title' => ' ',
                        'subtitle' => '',
                        'href' => 'screen?screen=pengumpulan_jurusan'
                    ]
                ]
            );

            statusCard(
                'dokumen-6',
                'Status Kompen',
                [
                    [
                        'type' => 'success',
                        'icon' => Icons::Check,
                        'title' => ' ',
                        'subtitle' => '',
                        'href' => 'screen?screen=pengumpulan_jurusan'
                    ]
                ]
            );

            statusCard(
                'dokumen-9',
                'Status Akademik',
                [
                    [
                        'type' => 'success',
                        'icon' => Icons::Check,
                        'title' => ' ',
                        'subtitle' => '',
                        'href' => 'screen?screen=pengumpulan_pusat'
                    ]
                ]
            );

            statusCard(
                'dokumen-1',
                'Status Tugas Akhir',
                [
                    [
                        'type' => 'success',
                        'icon' => Icons::Check,
                        'title' => ' ',
                        'subtitle' => '',
                        'href' => 'screen?screen=pengumpulan_jurusan'
                    ]
                ]
            );

            statusCard(
                'dokumen-10',
                'Status Perpustakaan',
                [
                    [
                        'type' => 'success',
                        'icon' => Icons::Check,
                        'title' => '',
                        'subtitle' => '',
                        'href' => 'screen?screen=pengumpulan_pusat'
                    ]
                ]
            );
            ?>
        </div>
        <div class="d-flex flex-row page-content">
            <div class="d-flex flex-row align-items-center justify-content-start" id="status-perpus">
                <?php
                statusCard(
                    'status-total-dokumen',
                    'Status Dokumen',
                    [
                        [
                            'type' => 'success',
                            'icon' => Icons::Check,
                            'title' => '',
                            'subtitle' => 'Dokumen<br>Terverifikasi',
                            'href' => 'null'
                        ],
                        [
                            'type' => 'warning',
                            'icon' => Icons::Question,
                            'title' => '',
                            'subtitle' => 'Dokumen<br>Pending',
                            'href' => 'null'
                        ],
                        [
                            'type' => 'danger',
                            'icon' => Icons::Close,
                            'title' => '',
                            'subtitle' => 'Dokumen<br>Tertanggung',
                            'href' => 'null'
                        ]
                    ]
                );
                ?>
            </div>

            <div class="flex-row align-items-center justify-content-center" id="status-lulus">
                <div class="flex-column align-items-center justify-content-center" style="gap: 16px; display: flex;">
                    <div class="status-badge-text success"><?= SvgIcons::getIconWithColor(Icons::Check, "white") ?></div>
                    <h2>Anda Sudah Lulus</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function setDokumenStatusUI(data) {
        let countSelesai = 0;
        let countPending = 0;
        let countTertanggung = 0;
        data.forEach(dokumen => {
            let statusCard = document.querySelector(`#dokumen-${dokumen.id}`);
            if (statusCard) {
                statusCard.querySelector('h3').innerText = dokumen.status;
                let cardContent = statusCard.querySelector('.card-status-content');
                cardContent.classList.remove('success-bg', 'warning-bg', 'danger-bg');
                let cardIcon = statusCard.querySelector('.card-status-icon');
                cardIcon.classList.remove('success', 'warning', 'danger');
                if (dokumen.status === '<?= StatusDokumen::Diverifikasi->value ?>') {
                    cardContent.classList.add('success-bg');
                    cardIcon.classList.add('success');
                    cardIcon.innerHTML = '<?= SvgIcons::getIcon(Icons::Check) ?>';
                } else if (dokumen.status === '<?= StatusDokumen::Menunggu->value ?>') {
                    cardContent.classList.add('warning-bg');
                    cardIcon.classList.add('warning');
                    cardIcon.innerHTML = '<?= SvgIcons::getIcon(Icons::Question) ?>';
                } else if (dokumen.status === '<?= StatusDokumen::Ditolak->value ?>') {
                    cardContent.classList.add('danger-bg');
                    cardIcon.classList.add('danger');
                    cardIcon.innerHTML = '<?= SvgIcons::getIcon(Icons::Close) ?>';
                } else {
                    cardContent.classList.add('danger-bg');
                    cardIcon.classList.add('danger');
                    cardIcon.innerHTML = '<?= SvgIcons::getIcon(Icons::Question) ?>';
                }
            }
            if (dokumen.status === '<?= StatusDokumen::Diverifikasi->value ?>') {
                countSelesai += 1;
            } else if (dokumen.status === '<?= StatusDokumen::Menunggu->value ?>') {
                countPending += 1;
            } else {
                countTertanggung += 1;
            }
        });

        let statusTotalDokumen = document.querySelector('#status-total-dokumen .card-status-content-wrapper');
        statusTotalDokumen.children[0].querySelector('h1').innerText = countSelesai;
        statusTotalDokumen.children[1].querySelector('h1').innerText = countPending;
        statusTotalDokumen.children[2].querySelector('h1').innerText = countTertanggung;

        let statusLulus = document.querySelector('#status-lulus');
        if (countSelesai >= data.length) {
            statusLulus.classList.add('success-bg');
            statusLulus.children[0].innerHTML = `
                <div class="status-badge-text success"><?= SvgIcons::getIconWithColor(Icons::Check, "white") ?></div>
                <h2>Anda Sudah Lulus</h2>
            `;
        }
        else{
            statusLulus.classList.add('danger-bg');
            statusLulus.children[0].innerHTML = `
                <div class="status-badge-text danger"><?= SvgIcons::getIconWithColor(Icons::Close, "white") ?></div>
                <h2>Anda Masih Memiliki Tanggungan</h2>
            `;
        }
        statusLulus.style.display = 'flex';
    }

    function updateDokumenStatus() {
        $.ajax({
            type: "POST",
            url: "statusDokumen", // Sesuaikan URL dengan controller Anda
            success: function(response) {
                // console.log(response);
                const data = JSON.parse(response);
                console.log(data)
                setDokumenStatusUI(data);
            },
            error: function(response) {
                console.error("Error fetching dokumen status: ", response);
            }
        });
    }

    // Panggil fungsi pertama kali dan ulangi setiap 60 detik
    updateDokumenStatus();
    funToCallEachInterval.push(updateDokumenStatus);
</script>