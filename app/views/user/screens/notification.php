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

    #total-tertanggung {
        font-weight: 600;
        font-size: 96px;
        line-height: 24px;
        color: var(--bs-danger);
        margin: auto;
    }

    #total-tertanggung + div h1{
        margin: 0px;
        font-size: 32px;
    }
</style>
<div class="d-flex flex-column" id="pengumpulan-page" style="gap: 24px;">
    <div id="page-content-top">
        <div class="d-flex flex-row align-items-center justify-content-end">
            <p id="total-tertanggung">X</p>
            <div class="d-flex flex-column align-items-start justify-content-end">
                <h1>Notifikasi</h1>
                <h1>Baru</h1>
            </div>
        </div>
    </div>
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
    </div>
</div>

<script>
    function generateNotification(data) {
        let notificationItems = document.getElementById('notification-wrapper');
        notificationItems.innerHTML = '';
        document.getElementById('total-tertanggung').textContent = data.length;
        data.forEach(notification => {
            let notificationContent = document.createElement('div');
            notificationContent.id = 'notification-content';
            let notificationItem = document.createElement('div');
            notificationItem.classList.add('d-flex', 'flex-row', 'align-items-center', 'justify-content-start', 'danger-bg');
            notificationItem.id = 'notification-item';
            let statusBadge = document.createElement('div');
            statusBadge.classList.add('status-badge-text', 'danger');
            statusBadge.innerHTML = '<?= SvgIcons::getIconWithColor(Icons::Close, "white") ?>';
            let notificationDocument = document.createElement('div');
            notificationDocument.style.flex = '1';
            notificationDocument.style.textOverflow = 'ellipsis';
            notificationDocument.style.overflow = 'hidden';
            notificationDocument.style.whiteSpace = 'nowrap';
            notificationDocument.id = 'notification-document';
            notificationDocument.textContent = notification.nama_dokumen;
            let openInNewTab = `<?= iconButton('', Icons::OpenInNewTab, 'var(--bs-emphasis-color)', 'window.location.href=\`screen?screen=pengumpulan_${notification.tingkat}\`;') ?>`;
            notificationItem.appendChild(statusBadge);
            notificationItem.appendChild(notificationDocument);
            notificationItem.innerHTML += (openInNewTab);
            notificationContent.appendChild(notificationItem);
            notificationItems.appendChild(notificationContent);
        });
    }

    function getDataPengumpulan(useUpdate = true) {
        $.ajax({
            type: "POST",
            url: "getDataPengumpulanNotification",
            success: function(response) {
                // console.log(response);
                let data = JSON.parse(response);
                generateNotification(data);
                console.log(data);
            },
            error: function(response) {
                console.log(response);
            }
        });
    }
    getDataPengumpulan(false);
</script>