<?php
include_once VIEWS . 'component/btn-icon.php';

?>
<style>
    #notification-item {
        flex-direction: column;
        gap: 16px;
        padding: 24px 24px;
        border-radius: 12px;
        /* width: 1600; */
        height: fit-content;
        margin: 16px;
        flex: 1;

    }

    /* bg item*/
    #notification-content {
        border-radius: 12px;
        background-color: var(--bs-body-bg);
        display: flex;
        flex-direction: column;
        padding: 5px 5px;
        border-radius: 12px;
        margin: 8px;
        flex: 1;
    }

    .status-badge-text {
        padding-top: 0px;
    }

    .status-badge-text svg {
        height: 16px;
        width: 16px;
    }
</style>
<div id="pengumpulan-page">
    <div id="page-content-top">
        <div id="total-tertanggung">5</div>
        <h1>Dokumen <strong><?= $data['user']->getPeopleName() ?></strong></h1>
    </div>
</div>
<div class=""></div>
<div class="d-flex flex-column align-items-stretch justify-content-center" id="notification-wrapper">
    <div id="notification-content">
        <div class="d-flex flex-row align-items-center justify-content-start danger-bg" id="notification-item">
            <div class="status-badge-text danger"><?= SvgIcons::getIconWithColor(Icons::Close, "white") ?></div>
            <div style="flex: 1; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;" id="notification-document">
                Dokumen ditolak, silahkan perbaiki dokumen .....
            </div>
            <?= iconButton('', Icons::OpenInNewTab, 'var(--bs-emphasis-color)') ?>
        </div>
    </div>
    <div id="notification-content">
        <div class="d-flex flex-row align-items-center justify-content-start danger-bg" id="notification-item">
            <div class="status-badge-text danger"><?= SvgIcons::getIconWithColor(Icons::Close, "white") ?></div>
            <div style="flex: 1; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;" id="notification-document">
                Dokumen ditolak, silahkan perbaiki dokumen .....
            </div>
            <?= iconButton('', Icons::OpenInNewTab, 'var(--bs-emphasis-color)') ?>
        </div>
    </div>
</div>
<script>
    function getDataPengumpulan(useUpdate = true) {
            $.ajax({
                type: "POST",
                url: "getDataPengumpulan",
                data: {
                    tingkat_dokumen: "<?= $tingkat ?>"
                },
                success: function(response) {
                    //console.log(response);
                    let data = JSON.parse(response);
                    console.log(data);
                    if (useUpdate) {
                        updatePageContent(data);
                    } else {
                        generatePageContent(data);
                    }
                },
                error: function(response) {
                    console.log(response);
                }
            });
        }
        getDataPengumpulan(false);
        // funToCallEachInterval.push(getDataPengumpulan);
    
    function getDataPengumpulan(useUpdate = true) {
            $.ajax({
                type: "POST",
                url: "getDataPengumpulan",
                data: {
                    tingkat_dokumen: "<?= $tingkat ?>"
                },
                success: function(response) {
                    //console.log(response);
                    let data = JSON.parse(response);
                    console.log(data);
                    if (useUpdate) {
                        updatePageContent(data);
                    } else {
                        generatePageContent(data);
                    }
                },
                error: function(response) {
                    console.log(response);
                }
            });
        }
        getDataPengumpulan(false);
        // funToCallEachInterval.push(getDataPengumpulan);

    
    let countTertanggung = 0;
    let totalTertanggung = document.getElementById('total-tertanggung');
    totalTertanggung.querySelectorAll('#total-tertanggung').textContent = countTertanggung ;
</script>