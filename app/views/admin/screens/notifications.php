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

    #total-tertanggung+div h1 {
        margin: 0px;
        font-size: 32px;
    }


    .page-content-top-title:not(.ada-notif) #tidak-ada-notifikasi,
    .page-content-top-title.ada-notif #ada-notifikasi {
        display: flex;
    }

    .page-content-top-title.ada-notif #tidak-ada-notifikasi,
    .page-content-top-title:not(.ada-notif) #ada-notifikasi {
        display: none;
    }
</style>
<div class="d-flex flex-column" id="pengumpulan-page" style="gap: 24px;">
    <div id="page-content-top">
        <div class="page-content-top-title d-flex flex-row align-items-center justify-content-end">
            <h1 id="tidak-ada-notifikasi">Tidak Ada Notifikasi Baru</h1>
            <div id="ada-notifikasi">
                <p id="total-tertanggung">X</p>
                <div class="d-flex flex-column align-items-start justify-content-end">
                    <h1>Notifikasi</h1>
                    <h1>Baru</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column align-items-stretch justify-content-center" id="notification-wrapper">
    </div>
</div>

<script>
    function generateNotificationItem(data) {
        let topTitle = document.getElementsByClassName('page-content-top-title')[0];
        if (data.length > 0) {
            topTitle.classList.add('ada-notif');
        } else {
            topTitle.classList.remove('ada-notif');
        }

        let notificationItems = document.getElementById('notification-wrapper');
        notificationItems.innerHTML = '';
        document.getElementById('total-tertanggung').textContent = data.length;

        data.forEach(notification => {
            // Membuat elemen untuk setiap notifikasi
            let notificationContent = document.createElement('div');
            notificationContent.id = 'notification-content';

            let notificationItem = document.createElement('div');
            notificationItem.classList.add('d-flex', 'flex-row', 'align-items-center', 'justify-content-start', 'warning-bg');
            notificationItem.id = 'notification-item';

            // Badge Status
            let statusBadge = document.createElement('div');
            statusBadge.classList.add('status-badge-text', 'warning');
            statusBadge.innerHTML = '<?= SvgIcons::getIconWithColor(Icons::Question, "white") ?>';

            // Nama Dokumen
            let notificationDocument = document.createElement('div');
            notificationDocument.style.flex = '1';
            notificationDocument.style.textOverflow = 'ellipsis';
            notificationDocument.style.overflow = 'hidden';
            notificationDocument.style.whiteSpace = 'nowrap';
            notificationDocument.id = 'notification-document';
            notificationDocument.textContent = `${notification.Nama_dokumen} oleh ${notification.Nama}`;

            // Tombol Open in New Tab
            let tingkat = notification.tingkat.toLowerCase(); // Pastikan tingkat dalam format yang sesuai
            let openInNewTab = `
            <?= iconButton(
                '',
                Icons::OpenInNewTab,
                'var(--bs-emphasis-color)',
                $data['user']->adminApa === TipeAdmin::Super ? 'window.location.href=\`screen?screen=super%2Fpengumpulan_${notification.tingkat}\`;' : 
                'window.location.href=\'screen?screen=pengumpulan\';'
            ) ?>
        `;

            notificationItem.appendChild(statusBadge);
            notificationItem.appendChild(notificationDocument);
            notificationItem.innerHTML += openInNewTab;
            notificationContent.appendChild(notificationItem);

            // Menambahkan notifikasi ke wrapper
            notificationItems.appendChild(notificationContent);
        });
    }

</script>