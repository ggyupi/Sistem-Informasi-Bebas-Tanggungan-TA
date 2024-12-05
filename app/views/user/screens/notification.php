<style>
    #notification-wrapper {
        background-color: var(--bs-body-bg);
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 32px;
        padding: 24px 50px;
        border-radius: 12px;
        width: fit-content;
        height: fit-content;
    }
</style>
<div class="d-flex flex-column align-items-center justify-content-center"></div>
<div class="d-flex flex-row" id="notification-wrapper">
    <div class="status-badge-text danger"><?= SvgIcons::getIconWithColor(Icons::Close, "white") ?>
    </div>
    <div class="d-flex" style="gap: 16px;">
        Dokumen ditolak, silahkan perbaiki dokumen .....
    </div>
</div>