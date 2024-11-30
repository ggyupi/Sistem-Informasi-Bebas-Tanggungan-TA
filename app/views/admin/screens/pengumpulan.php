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
<form id="dialog-decl">
    <?=
    dialogYesNo(
        'btn-decl',
        'Tolak',
        'Decl',
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
        ' . iconButton('', Icons::OpenInNewTab, 'white', 'window.open(document.getElementById(`pdf-viewer`).getAttribute(`src`), `_blank`);') . '
    </div>',
    '<div id="pdf-viewer-wrapper">
    </div>',
    '<div class="d-flex flex-row align-items-center">
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

<div id="pengumpulan-page">

    <div id="page-content-top">
        <?php
        $tipe = explode(' ', $data['title']);
        echo '<h1>Data Dokumen <strong>' . ucwords($data['user']->adminApa === TipeAdmin::Super ? end($tipe) : $data['user']->adminApa->value) . '</strong></h1>';
        ?>
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
            <div style="width: 120%;" class="d-flex input-group" role="search">
                <label class="input-group-text rounded-start-pill" for="inputGroupSelect01"><?= SvgIcons::getIcon(Icons::Search) ?></label>
                <input class="form-control me-2 rounded-end-pill" type="search" placeholder="Telusuri" id="search-input">
            </div>
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
            <tbody class="align-middle" id="table-body"></tbody>
        </table>
    </div>

    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a class="page-link" href="#">
                    <span>&laquo;</span>
                </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">
                    <span>&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>

    <?php include_once VIEWS . "template/script-helper.php"; ?>
    <script>

        function pdfViewerLoadPdf(url) {
            document.getElementById('pdf-viewer-title').innerHTML = getFileName(url);
            document.getElementById('pdf-viewer-wrapper').innerHTML = `<iframe src="${url}" id="pdf-viewer" style="width: 100%; height: 70vh;">Loading...</iframe>`;
        }

        function setDokumenInOpen(idDokumen, namaDokumen, namaMahasiswa, nim) {
            console.log('setDokumenInOpen');
            document.getElementById('id_dokumen').value = idDokumen;
            document.getElementById('nama_dokumen').value = namaDokumen;
            document.getElementById('nama_mahasiswa').value = namaMahasiswa;
            document.getElementById('nim').value = nim;
        }

        function clearDokumenInOpen() {
            console.log('clearDokumenInOpen');
            document.getElementById('id_dokumen').value = '';
            document.getElementById('nim').value = '';
        }

        document.getElementById('btn-acc').addEventListener('hidden.bs.modal', clearDokumenInOpen);
        document.getElementById('btn-decl').addEventListener('hidden.bs.modal', clearDokumenInOpen);

        function removeTableActive() {
            document.querySelectorAll('tbody tr').forEach(function(row) {
                row.classList.remove('table-active');
            });
        }

        function changeModalDialogMessage(id, message) {
            let dialog = document.getElementById(id);
            dialog.getElementsByClassName('modal-body')[0].innerHTML = message;
        }

        function funSearch(search) {
            document.querySelectorAll('tr #search-mahasiswa').forEach(function(row) {
                row.parentNode.style.display = row.textContent.toLowerCase().includes(search) ? '' : 'none';
            });
        }


        const searchInput = document.getElementById('search-input');
        searchInput.addEventListener('input', function() {
            var search = this.value.toLowerCase();
            removeTableActive();
            funSearch(search);
        });

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
                    <td id="search-mahasiswa">${dataMahasiswa.nama}</td>
                    <td>${dataMahasiswa.jurusan}</td>
                    <td>${dataMahasiswa.program_studi}</td> 
                    <td style="place-items: center">${tuntas ? badgeSelesai : badgeTertanggungWithNumber}</td>                   
                `;
                tableBody.appendChild(tr);

                // OnExpand           
                tr = document.createElement('tr');
                let td = document.createElement('td');
                td.colSpan = 6;
                td.classList.add('table-expand-wrapper');
                let tableExpand = document.createElement('div');
                tableExpand.classList.add('table-expand');
                for (const dataDetail of dataDetails) {
                    let tableExpandItem = document.createElement('div');
                    let actions = [
                        btnAcc.replace(`#onclick`, `                        
                        changeModalDialogMessage('dialog-acc', 
                            'Acc <strong>[${dataMahasiswa.nim}] ${dataMahasiswa.nama}<br>${dataDetail.dokumen}</strong>?');`),
                        btnDecl.replace(`#onclick`, `                        
                        changeModalDialogMessage('dialog-decl', 
                        'Tolak <strong>[${dataMahasiswa.nim}] ${dataMahasiswa.nama}<br>${dataDetail.dokumen}</strong>?');`)
                    ];
                    let pdfFileUrl = pdfDatabasePrefix + dataDetail.path_dokumen;
                    if (getFileName(pdfFileUrl) != '') {
                        actions.unshift(btnSee.replace(`#onclick`, `
                        setDokumenInOpen('${dataDetail.id}', '${dataDetail.dokumen}', '${dataMahasiswa.nama}', '${dataMahasiswa.nim}');
                        pdfViewerLoadPdf('${pdfFileUrl}');`));
                        tableExpandItem.onclick = function() {
                            setDokumenInOpen(dataDetail.id, dataDetail.dokumen, dataMahasiswa.nama, dataMahasiswa.nim);
                            pdfViewerLoadPdf(`${pdfFileUrl}`);
                        };
                        tableExpandItem.dataset.bsToggle = "modal";
                        tableExpandItem.dataset.bsTarget = "#btn-see";
                        tableExpandItem.classList.add('table-expand-item-hoverable');
                    }

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
                    if (getFileName(pdfFileUrl) == '') {
                        tableExpandItemAction.style.opacity = '0';
                        tableExpandItemAction.style.pointerEvents = 'none';
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
                if (i == idTableExpand) {
                    row.classList.add('table-active');
                }
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
            let data = <?php
                        $tipe = explode(' ', $data['title']);
                        echo $data['user']->adminApa === TipeAdmin::Super ? ('{"super-tingkat": "' . ucwords(end($tipe)) . '"}') : '{}';
                        ?>;
            $.ajax({
                type: "POST",
                url: "getDataPengumpulan",
                data: data,
                success: function(response) {
                    let data = JSON.parse(response);
                    console.log(data);
                    tableBody.append(...generateTableBodyItems(data).children);
                    funSearch(searchInput.value);
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
                url: "updateDataPengumpulan",
                data: $('#in-open-dokumen').serialize() + '&acc=true',
                success: function(response) {
                    console.log(response);
                    getDataPengumpulan();
                },
                error: function(response) {
                    console.log(response);
                }
            });
        });

        document.getElementById('dialog-decl').addEventListener('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "updateDataPengumpulan",
                data: $('#in-open-dokumen').serialize() + '&acc=false',
                success: function(response) {
                    console.log(response);
                    getDataPengumpulan();
                },
                error: function(response) {
                    console.log(response);
                }
            });
        });
    </script>

</div>