<form class="d-none" id="in-open-dokumen">
    <input type="text" name="id_dokumen" id="id_dokumen" />
    <input type="text" name="nama_dokumen" id="nama_dokumen" />
    <input type="text" name="nama_mahasiswa" id="nama_mahasiswa" />
    <input type="text" name="nim" id="nim" />
</form>

<form id="dialog-acc">
    <?=
    dialogYesNo(
        'btn-acc',
        'Acc?',
        'Acc',
        SvgIcons::getIcon(Icons::Check) . 'Acc kan min',
        SvgIcons::getIcon(Icons::Close) . 'Ga Jadi',
        true,
        'btn-success'
    );
    ?>
</form>

<form class="needs-validation was-validated" id="dialog-decl">
    <?=
    dialogYesNoCustom(
        'btn-decl',
        '<h1 class="modal-title fs-5">Tolak?</h1>',
        'Decl',
        '<button type="button" class="btn btn-outline'
            . '" data-bs-dismiss="modal">' . SvgIcons::getIcon(Icons::Close) .
            'Ga jadi</button>
        <button type="submit" class="btn btn-danger'
            . '" >' . SvgIcons::getIcon(Icons::Check) .
            'Tolak saja min</button>',
        true,
        maxWidth: '30vw'
    );
    ?>
</form>

<div class="modal fade" id="result-acc" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="d-flex flex-row align-items-center justify-content-center success-bg" id="result-content">
            <div class="d-flex flex-column align-items-center justify-content-center " style="gap: 16px;">
                <div class="status-badge-text success"><?= SvgIcons::getIconWithColor(Icons::Check, "white") ?></div>
                <h2>Dokumen Berhasil Diverifikasi</h2>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="result-decl" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="d-flex flex-row align-items-center justify-content-center danger-bg" id="result-content">
            <div class="d-flex flex-column align-items-center justify-content-center " style="gap: 16px;">
                <div class="status-badge-text danger"><?= SvgIcons::getIconWithColor(Icons::Close, "white") ?></div>
                <h2>Dokumen Berhasil Ditolak</h2>
            </div>
        </div>
    </div>
</div>
<?=
dialogYesNoCustom(
    'btn-see',
    '<div class="d-flex flex-row align-items-center justify-content-between" style="flex: 1;">
        ' . iconButton('', Icons::Close, 'white') . '
        <h1 class="modal-title fs-5" id="pdf-viewer-title"></h1>
        ' . iconButton('', Icons::OpenInNewTab, 'white', 'window.open(document.getElementById(`pdf-viewer`).getAttribute(`src`), `_blank`);') . '
    </div>',
    '<div id="pdf-viewer-wrapper">
    </div>',
    '<div class="d-flex flex-row align-items-center" id="pdf-viewer-footer">
        <button style="padding: 14px 12px; margin: 0px 8px" type="button" class="btn btn-outline" data-bs-dismiss="modal">' . SvgIcons::getIcon(Icons::Close) . 'Ga Jadi</button>
        <button class="btn btn-badge" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#btn-decl" 
        onclick="
            changeModalDialogMessage(`dialog-decl`, 
                `Tolak <strong>[${document.getElementById(`in-open-dokumen`).nim.value}] 
                ${document.getElementById(`in-open-dokumen`).nama_mahasiswa.value} <br>
                ${document.getElementById(`in-open-dokumen`).nama_dokumen.value}</strong>?`);">
                ' . statusBadge('danger', Icons::Close, 'Tolak') . '
        </button>
        <button class="btn btn-badge" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#btn-acc"
        onclick="
            changeModalDialogMessage(`dialog-acc`, 
                `Acc <strong>[${document.getElementById(`in-open-dokumen`).nim.value}] 
                ${document.getElementById(`in-open-dokumen`).nama_mahasiswa.value} <br>
                ${document.getElementById(`in-open-dokumen`).nama_dokumen.value}</strong>?`);">
         ' . statusBadge('success', Icons::Check, 'Terima') . '
         </button>
    </div>',
    true,
    '70vw'
)
?>