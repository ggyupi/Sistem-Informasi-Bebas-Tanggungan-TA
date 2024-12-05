<?php
include_once VIEWS . 'component/btn-icon.php';
?>
<style>
    #notification-item {
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 16px;
        padding: 24px 24px;
        border-radius: 12px;
        width: fit-content;
        height: fit-content;
        margin: 16px;

    }

    /* bg item*/
    #notification-content {
        border-radius: 12px;
        background-color: var(--bs-body-bg);
        display: flex;
        flex-direction: column;
        align-items: start;
        justify-content: start;
        padding: 5px 5px;
        border-radius: 12px;
        width: fit-content;
        margin: 8px;
    }

    .status-badge-text {
        padding-top: 0px;
    }

    .status-badge-text svg {
        height: 16px;
        width: 16px;
    }
</style>
<div class="d-flex flex-column align-items-start justify-content-center" id="notification-wrapper">
    <div id="notification-content">
        <div class="d-flex flex-row align-items-center justify-content-center danger-bg" id="notification-item">
            <div class="status-badge-text danger"><?= SvgIcons::getIconWithColor(Icons::Close, "white") ?></div>
            <div class="d-flex">
                <div id="notification-document">
                    Dokumen ditolak, silahkan perbaiki dokumen .....
                </div>
            </div>
            <?= iconButton('', Icons::OpenInNewTab, 'var(--bs-emphasis-color)') ?>
        </div>
    </div>
    <div id="notification-content">
        <div class="d-flex flex-row align-items-center justify-content-center danger-bg" id="notification-item">
            <div class="status-badge-text danger"><?= SvgIcons::getIconWithColor(Icons::Close, "white") ?></div>
            <div class="d-flex">
                <div id="notification-document">
                    Dokumen ditolak, silahkan perbaiki dokumen .....
                </div>
            </div>
            <?= iconButton('', Icons::OpenInNewTab, 'var(--bs-emphasis-color)') ?>
        </div>
    </div>
</div>