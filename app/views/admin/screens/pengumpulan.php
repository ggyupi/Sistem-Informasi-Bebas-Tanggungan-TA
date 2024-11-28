<?php
include_once VIEWS . 'component/status-badge.php';
include_once VIEWS . 'component/btn-icon.php';
?>

<style>
    #pengumpulan-page {
        display: flex;
        flex-direction: column;
        gap: 24px;
        flex: 1;
        overflow-y: auto;
    }
</style>

<form id="dialog-acc">
    <?=
    dialogYesNo(
        'btn-acc',
        'Acc?',
        'Logout dan Hapus Sesi Saat ini',
        SvgIcons::getIcon(Icons::Check) . 'Acc kan min',
        SvgIcons::getIcon(Icons::Close) . 'Ga Jadi',
        true,
        'btn-success'
    );
    ?>
</form>
<form id="dialog-decl">
    <?=
    dialogYesNo(
        'btn-decl',
        'Tolak',
        'Logout dan Hapus Sesi Saat ini',
        SvgIcons::getIcon(Icons::Check) . 'Tolak saja min',
        SvgIcons::getIcon(Icons::Close) . 'Ga Jadi',
        true
    );
    ?>
</form>

<?=
dialogYesNoCustom(
    'btn-see',
    '<div class="d-flex flex-row align-items-center justify-content-between" style="flex: 1;">
        ' . iconButton('', Icons::Close, 'white') . '
        <h1 class="modal-title fs-5" id="pdf-viewer-title"></h1>
        ' . iconButton('', Icons::OpenInNewTab, 'white', 'window.open(document.getElementById(`pdf-viewer`).getAttribute(`data`), `_blank`);') . '
    </div>',
    '<div id="pdf-viewer-wrapper">
    </div>',
    '<form class="d-flex flex-row align-items-center">
        <button type="submit" class="btn btn-badge">
            ' . statusBadge('danger', Icons::Close, 'Tolak') . '
        </button>
        <button type="submit" class="btn btn-badge">
         ' . statusBadge('success', Icons::Check, 'Terima') . '
         </button>
    </form>',
    true,
    '70vw'
)
?>

<div id="pengumpulan-page">

    <div id="page-content-top">
        <h1>Data Dokumen</h1>
        <div id="page-content-top-right">
            <div class="w-100 input-group d-flex">
                <label class="input-group-text rounded-start-pill" for="inputGroupSelect01">Status</label>
                <select class="form-select rounded-end-pill" id="inputGroupSelect01">
                    <option selected>Semua</option>
                    <option value="1">Baru</option>
                    <option value="2">Tertanggung</option>
                    <option value="3">Selesai</option>
                </select>
            </div>
            <form style="width: 120%;" class="d-flex input-group" role="search">
                <label class="input-group-text rounded-start-pill" for="inputGroupSelect01"><?= SvgIcons::getIcon(Icons::Search) ?></label>
                <input class="form-control me-2 rounded-end-pill" type="search" placeholder="Telusuri">
            </form>
        </div>
    </div>

    <div id="table-wrapper">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">NO</th>
                    <th scope="col" style="width: 10%;">NIM</th>
                    <th scope="col" style="width: 35%;">NAMA</th>
                    <th scope="col">JURUSAN</th>
                    <th scope="col">PROGRAM STUDI</th>
                    <th scope="col" class="text-center">STATUS</th>
                </tr>
            </thead>
            <tbody class="align-middle" id="table-body">
                <!-- <tr class="table-active">
                    <td>1</td>
                    <td>2341720157</td>
                    <td>UwU Kagamihara</td>
                    <td>Teknologi Informasi</td>
                    <td>Teknik Informatika</td>
                    <td style="place-items: center">
                        <?= statusBadge('warning', Icons::Check, 'Tertanggung') ?>
                    </td>
                </tr>
                <tr>
                    <td class="table-expand-wrapper" colspan="6">
                        <div class="table-expand">
                            <div class="table-expand-item">
                                <div class="d-flex flex-row align-items-center" id="table-expand-item">
                                    <div class="status-badge-icon success">
                                        <?= SvgIcons::getIcon(Icons::Question) ?>
                                    </div>
                                    <p>Tukamm</p>
                                </div>
                                <div class="d-flex flex-row align-items-center" id="action">
                                    <?= iconButton('btn-see', Icons::Eye, 'var(--bs-emphasis-color)') ?>
                                    <?= iconButton('btn-acc', Icons::Check, 'green') ?>
                                    <?= iconButton('btn-decl', Icons::Close, 'red') ?>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr> -->
            </tbody>
        </table>
    </div>

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>

    <script>
        const pdfDatabasePrefix = '<?= FILEDATABASE_URL ?>';

        function getFileName(url) {
            let filename = url.substring(url.lastIndexOf('/') + 1);
            return filename === 'undefined' ? '' : filename;
        }

        function pdfViewerLoadPdf(url) {
            document.getElementById('pdf-viewer-title').innerHTML = getFileName(url);
            document.getElementById('pdf-viewer-wrapper').innerHTML = `<iframe src="${url}" id="pdf-viewer" style="width: 100%; height: 70vh;">Loading...</iframe>`;
        }

        function removeTableActive() {
            document.querySelectorAll('tbody tr').forEach(function(row) {
                row.classList.remove('table-active');
            });
        }

        function changeModalDialogMessage(id, message) {
            let dialog = document.getElementById(id);
            dialog.getElementsByClassName('modal-body')[0].innerHTML = message;
        }

        let idTableExpand = -1;

        function generateTableBodyItems(data) {
            const iconAcc = '<?= SvgIcons::getIcon(Icons::Check) ?>';
            const iconDecl = '<?= SvgIcons::getIcon(Icons::Close) ?>';
            const iconQuestion = '<?= SvgIcons::getIcon(Icons::Question) ?>';
            const btnSee = '<?= iconButton('btn-see', Icons::Eye, 'var(--bs-emphasis-color)', '#onclick') ?>';
            const btnAcc = '<?= iconButton('btn-acc', Icons::Check, 'green', '#onclick') ?>';
            const btnDecl = '<?= iconButton('btn-decl', Icons::Close, 'red', '#onclick') ?>';
            const badgeTertanggung = `<?= statusBadge('danger', Icons::Close, 'Tertanggung') ?>`;
            const badgeSelesai = `<?= statusBadge('success', Icons::Check, 'Selesai') ?>`;

            let tableBody = document.createElement('tbody');
            let countItem = 0;

            for (let i = 0; i < data.length; i++) {
                countItem += 1;
                let tr = document.createElement('tr');
                let dataMahasiswa = data[i].data_mahasiswa;
                let dataDetails = data[i].data_detail;
                let tuntas = true;
                for (const i of dataDetails) {
                    if (i.status.toLowerCase() !== 'diverifikasi') {
                        tuntas = false;
                        break;
                    }
                }

                let sumMenunggu = 0;
                for (const dataDetail of dataDetails) {
                    if (dataDetail.status.toLowerCase() == 'menunggu') {
                        sumMenunggu += 1;
                    }
                }
                let badgeTertanggungWithNumber = `
                <div class="d-flex flex-row align-items-center" style="gap: 12px;">
                    <div class="status-badge-text" style="opacity: ${sumMenunggu > 0 ? 1 : 0};">${sumMenunggu}</div> 
                    ${badgeTertanggung}
                    <div class="status-badge-text" style="opacity: ${sumMenunggu > 0 ? 0 : 0};">${sumMenunggu}</div> 
                </div>
                `;
                tr.innerHTML = `
                    <td>${countItem}</td>
                    <td>${dataMahasiswa.nim}</td>
                    <td>${dataMahasiswa.nama}</td>
                    <td>${dataMahasiswa.jurusan}</td>
                    <td>${dataMahasiswa.program_studi}</td> 
                    <td style="place-items: center">${tuntas ? badgeSelesai : badgeTertanggungWithNumber}</td>                   
                `;
                if (i == idTableExpand) {
                    tr.classList.add('table-active');
                }
                tableBody.appendChild(tr);

                // OnExampand           
                tr = document.createElement('tr');
                let td = document.createElement('td');
                td.colSpan = 6;
                td.classList.add('table-expand-wrapper');
                let tableExpand = document.createElement('div');
                tableExpand.classList.add('table-expand');
                for (const dataDetail of dataDetails) {
                    let tableExpandItem = document.createElement('div');
                    tableExpandItem.classList.add('table-expand-item');
                    let tableExpandItemDocument = document.createElement('div');
                    tableExpandItemDocument.classList.add('d-flex', 'flex-row', 'align-items-center', 'action');
                    tableExpandItemDocument.id = 'table-expand-item';
                    let tableExpandItemIcon = document.createElement('div');
                    tableExpandItemIcon.classList.add('status-badge-icon');
                    let tableExpandItemText = document.createElement('p');
                    tableExpandItemText.innerText = dataDetail.dokumen;
                    let tableExpandItemAction = document.createElement('div');
                    tableExpandItemAction.classList.add('d-flex', 'flex-row', 'align-items-center', 'action');
                    tableExpandItemAction.id = 'action';

                    let actions = [
                        btnAcc.replace(`#onclick`, `changeModalDialogMessage('dialog-acc', 
                            'Acc <strong>${dataDetail.dokumen}</strong>?')`),
                        btnDecl.replace(`#onclick`, `changeModalDialogMessage('dialog-decl', 
                        'Tolak <strong>${dataDetail.dokumen}</strong>?')`)
                    ];

                    let pdfFileUrl = pdfDatabasePrefix + dataDetail.path_dokumen;
                    if (getFileName(pdfFileUrl) != '') {
                        actions.unshift(btnSee.replace(`#onclick`, `pdfViewerLoadPdf('${pdfFileUrl}')`));
                    }
                

                    if (dataDetail.status.toLowerCase() == 'diverifikasi') {
                        tableExpandItemIcon.classList.add('success');
                        actions.splice(1, 1);
                        tableExpandItemIcon.innerHTML = iconAcc;

                    } else if (dataDetail.status.toLowerCase() == 'menunggu') {
                        tableExpandItemIcon.classList.add('warning');
                        tableExpandItemIcon.innerHTML = iconQuestion;
                    } else {
                        tableExpandItemIcon.classList.add('danger');
                        tableExpandItemIcon.innerHTML = iconDecl;
                    }
                    tableExpandItemAction.innerHTML = actions.join('');

                    tableExpandItemDocument.appendChild(tableExpandItemIcon);
                    tableExpandItemDocument.appendChild(tableExpandItemText);
                    tableExpandItem.appendChild(tableExpandItemDocument);
                    tableExpandItem.appendChild(tableExpandItemAction);
                    tableExpand.appendChild(tableExpandItem);
                    td.appendChild(tableExpand);
                    tr.appendChild(td);
                }

                tableBody.appendChild(tr);
            }
            let rows = tableBody.querySelectorAll('tbody tr');
            for (let i = 0; i < rows.length; i++) {
                let row = rows[i];
                row.addEventListener('click', function() {
                    if (row.children[0].classList.contains('table-expand-wrapper')) {
                        return;
                    }
                    let having = row.classList.contains('table-active');
                    removeTableActive();
                    if (!having) {
                        row.classList.add('table-active');
                        idTableExpand = i;
                    }
                });
            }
            return tableBody;
        }

        function getDataPengumpulan() {
            let tableBody = document.getElementById('table-body');
            tableBody.innerHTML = '';
            $.ajax({
                type: "POST",
                url: "getDataPengumpulan",
                success: function(response) {
                    let data = JSON.parse(response);
                    console.log(data);
                    tableBody.append(...generateTableBodyItems(data).children);
                },
                error: function(response) {
                    console.log(response);
                }
            });

        }
        getDataPengumpulan();

        document.getElementById('dialog-acc').addEventListener('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "",
                data: {

                },
                success: function() {

                },
                error: function(response) {

                }
            });
        });

        document.getElementById('dialog-decl').addEventListener('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "",
                data: {

                },
                success: function() {

                },
                error: function(response) {

                }
            });
        });
    </script>

</div>