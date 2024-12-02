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

<form class="needs-validation was-validated" id="dialog-decl">
    <?=
    dialogYesNoCustom(
        'btn-decl',
        '<div class="modal-header">
        <h1 class="modal-title fs-5">Tolak?</h1>
        </div>
        ',
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

<div id="pengumpulan-page">
    <div id="page-content-top">
        <?php
        $tipe = explode(' ', $data['title']);
        echo '<h1>Data Dokumen <strong>' . ucwords($data['user']->adminApa === TipeAdmin::Super ? end($tipe) : $data['user']->adminApa->value) . '</strong></h1>';
        ?>
        <div id="page-content-top-right">
            <div class="w-100 input-group d-flex">
                <label class="input-group-text rounded-start-pill" for="filter-data">Status</label>
                <select class="form-select rounded-end-pill" id="filter-data">
                    <option selected value="semua">Semua</option>
                    <option value="baru">Baru</option>
                    <option value="tertanggung">Tertanggung</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>
            <div style="width: 120%;" class="d-flex input-group" role="search">
                <label class="input-group-text rounded-start-pill" for="search-input"><?= SvgIcons::getIcon(Icons::Search) ?></label>
                <input class="form-control me-2 rounded-end-pill" type="search" placeholder="Telusuri" id="search-input">
            </div>
        </div>
    </div>

    <div id="table-wrapper">
        <table class="table table-hover" style="overflow-y: auto;">
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
         function resetDialogSee() {
            document.querySelectorAll('#btn-see #pdf-viewer-footer button').forEach(function(button) {
                button.style.display = '';
            });
        }

        function pdfViewerLoadPdf(url, status) {
            resetDialogSee();
            let pdfViewerFooter = document.querySelector('#btn-see #pdf-viewer-footer');
            if (status === '<?= StatusDokumen::Diverifikasi->value ?>') {
                pdfViewerFooter.children[2].style.display = 'none';
            } else if (status === '<?= StatusDokumen::Ditolak->value ?>') {
                pdfViewerFooter.children[1].style.display = 'none';
            }
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
        document.getElementById('btn-see').addEventListener('hidden.bs.modal', resetDialogSee);

        function removeTableActive() {
            document.querySelectorAll('tbody tr').forEach(function(row) {
                row.classList.remove('table-active');
            });
        }

        function changeModalDialogMessage(id, message) {
            let dialog = document.getElementById(id);
            let modalBody = dialog.getElementsByClassName('modal-body')[0];
            console.log(id);
            if (id == 'dialog-decl') {
                // modalBody.parentNode.parentNode.parentNode.parentNode.classList.remove('was-validated');
                modalBody.innerHTML = `
                ${message}<br><br>
                <label for="komentar-tolak" class="form-label">Masukkan alasan penolakan</label>
                <input type="text" class="form-control" value="" name="komentar" id="komentar-tolak" required />
                <div class="invalid-feedback">
                    Tolong isi alasan penolakan 
                </div>                
                `;
            } else {
                modalBody.innerHTML = message;
            }
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

        const iconAcc = '<?= SvgIcons::getIcon(Icons::Check) ?>';
        const iconDecl = '<?= SvgIcons::getIcon(Icons::Close) ?>';
        const iconQuestion = '<?= SvgIcons::getIcon(Icons::Question) ?>';
        const btnSee = '<?= iconButton('btn-see', Icons::Eye, 'var(--bs-emphasis-color)', '#onclick') ?>';
        const btnAcc = '<?= iconButton('btn-acc', Icons::Check, 'green', '#onclick') ?>';
        const btnDecl = '<?= iconButton('btn-decl', Icons::Close, 'red', '#onclick') ?>';
        const badgeTertanggung = `<?= statusBadge('danger', Icons::Close, 'Tertanggung') ?>`;
        const badgeSelesai = `<?= statusBadge('success', Icons::Check, 'Selesai') ?>`;

        function generateTableBodyItems(data) {
            let tableBody = document.createElement('tbody');
            let countItem = 0;

            for (let i = 0; i < data.length; i++) {
                countItem += 1;
                let tr = document.createElement('tr');
                let dataMahasiswa = data[i].data_mahasiswa;
                let dataDetails = data[i].data_detail;
                let tuntas = true;
                for (const i of dataDetails) {
                    if (i.status !== '<?= StatusDokumen::Diverifikasi->value ?>') {
                        tuntas = false;
                        break;
                    }
                }

                let sumMenunggu = 0;
                for (const dataDetail of dataDetails) {
                    if (dataDetail.status == '<?= StatusDokumen::Menunggu->value ?>') {
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
                    <td id="search-nim">${dataMahasiswa.nim}</td>
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
                        pdfViewerLoadPdf('${pdfFileUrl}', dataDetail.status);`));
                        tableExpandItem.onclick = function() {
                            setDokumenInOpen(dataDetail.id, dataDetail.dokumen, dataMahasiswa.nama, dataMahasiswa.nim);
                            pdfViewerLoadPdf(`${pdfFileUrl}`, dataDetail.status);
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

                    if (dataDetail.status == '<?= StatusDokumen::Diverifikasi->value ?>') {
                        tableExpandItemIcon.classList.add('success');
                        actions.splice(1, 1);
                        tableExpandItemIcon.innerHTML = iconAcc;

                    } else if (dataDetail.status == '<?= StatusDokumen::Menunggu->value ?>') {
                        tableExpandItemIcon.classList.add('warning');
                        tableExpandItemIcon.innerHTML = iconQuestion;
                    } else if (dataDetail.status == '<?= StatusDokumen::Ditolak->value ?>') {
                        actions.pop();
                        tableExpandItemIcon.classList.add('danger');
                        tableExpandItemIcon.innerHTML = iconDecl;
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

        function updateTableBodyItems(data) {
            let tableBody = document.getElementById('table-body');
            for (let i = 0; i < tableBody.children.length; i += 2) {
                let dataMahasiswa = data[i / 2].data_mahasiswa;
                let dataDetails = data[i / 2].data_detail;
                let row = tableBody.children[i];
                let rowDetails = tableBody.children[i + 1];
                let tuntas = true;
                for (const i of dataDetails) {
                    if (i.status !== '<?= StatusDokumen::Diverifikasi->value ?>') {
                        tuntas = false;
                        break;
                    }
                }
                let sumMenunggu = 0;
                for (const dataDetail of dataDetails) {
                    if (dataDetail.status == '<?= StatusDokumen::Menunggu->value ?>') {
                        sumMenunggu += 1;
                    }
                }
                let badgeWithNumber = `
                    <div class="d-flex flex-row align-items-center" style="gap: 12px;">
                        <div class="status-badge-text" style="opacity: ${sumMenunggu > 0 ? 1 : 0};">${sumMenunggu}</div> 
                            ${badgeTertanggung}
                        <div class="status-badge-text" style="opacity: ${sumMenunggu > 0 ? 0 : 0};">${sumMenunggu}</div>
                    </div> 
                `;
                row.children[row.children.length - 1].innerHTML = tuntas ? badgeSelesai : badgeWithNumber;


                for (let j = 0; j < dataDetails.length; j++) {
                    const dataDetail = dataDetails[j];
                    let tableExpandItem = rowDetails.children[0].children[0].children[j];
                    tableExpandItem.children[0].children[0].classList.remove('success', 'warning', 'danger');
                    let pdfFileUrl = pdfDatabasePrefix + dataDetail.path_dokumen;
                    let actions = [
                        btnSee.replace(`#onclick`, `
                        setDokumenInOpen('${dataDetail.id}', '${dataDetail.dokumen}', '${dataMahasiswa.nama}', '${dataMahasiswa.nim}');
                        pdfViewerLoadPdf('${pdfFileUrl}', dataDetail.status);`),
                        btnAcc.replace(`#onclick`, `                        
                        changeModalDialogMessage('dialog-acc', 
                            'Acc <strong>[${dataMahasiswa.nim}] ${dataMahasiswa.nama}<br>${dataDetail.dokumen}</strong>?');`),
                        btnDecl.replace(`#onclick`, `                        
                        changeModalDialogMessage('dialog-decl', 
                        'Tolak <strong>[${dataMahasiswa.nim}] ${dataMahasiswa.nama}<br>${dataDetail.dokumen}</strong>?');`)
                    ];
                    if (dataDetail.status == '<?= StatusDokumen::Diverifikasi->value ?>') {
                        tableExpandItem.children[0].children[0].classList.add('success');
                        tableExpandItem.children[0].children[0].innerHTML = iconAcc;
                        actions.splice(1, 1);
                    } else if (dataDetail.status == '<?= StatusDokumen::Menunggu->value ?>') {
                        tableExpandItem.children[0].children[0].classList.add('warning');
                        tableExpandItem.children[0].children[0].innerHTML = iconQuestion;
                    } else if (dataDetail.status == '<?= StatusDokumen::Ditolak->value ?>') {
                        tableExpandItem.children[0].children[0].classList.add('danger');
                        tableExpandItem.children[0].children[0].innerHTML = iconDecl;
                        actions.pop();
                    }

                    tableExpandItem.children[0].children[1].textContent = dataDetail.dokumen;

                    if (getFileName(pdfFileUrl) != '') {
                        tableExpandItem.children[1].innerHTML = actions.join('');
                        tableExpandItem.onclick = function() {
                            setDokumenInOpen(dataDetail.id, dataDetail.dokumen, dataMahasiswa.nama, dataMahasiswa.nim);
                            pdfViewerLoadPdf(`${pdfFileUrl}`, dataDetail.status);
                        };
                        tableExpandItem.dataset.bsToggle = "modal";
                        tableExpandItem.dataset.bsTarget = "#btn-see";
                        tableExpandItem.classList.add('table-expand-item-hoverable');
                    } else {
                        tableExpandItem.onclick = null;
                        delete tableExpandItem.dataset.bsToggle;
                        delete tableExpandItem.dataset.bsTarget;
                        tableExpandItem.classList.remove('table-expand-item-hoverable');
                    }
                }
            }
        }

        var getDataPengumpulanInUpdate = false;

        function getDataPengumpulan(useUpdate = true) {
            if (getDataPengumpulanInUpdate) {
                return;
            }
            getDataPengumpulanInUpdate = true;
            let data = <?php
                        $tipe = explode(' ', $data['title']);
                        echo $data['user']->adminApa === TipeAdmin::Super ? ('{"super_tingkat": "' . ucwords(end($tipe)) . '"}') : '{}';
                        ?>;
            $.ajax({
                type: "POST",
                url: "getDataPengumpulan",
                data: data,
                success: function(response) {
                    let data = JSON.parse(response);
                    console.log(data);
                    if (useUpdate) {
                        updateTableBodyItems(data);
                    } else {
                        let tableBody = document.getElementById('table-body');
                        tableBody.innerHTML = '';
                        tableBody.append(...generateTableBodyItems(data).children);
                        funSearch(searchInput.value);
                    }
                    getDataPengumpulanInUpdate = false;
                },
                error: function(response) {
                    console.log(response);
                    getDataPengumpulanInUpdate = false;
                }

            });

        }
        getDataPengumpulan(false);
        funToCallEachInterval.push(getDataPengumpulan);

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

        // let dialogDecl = document.getElementById('dialog-decl');
        document.getElementById('dialog-decl').addEventListener('submit', function(e) {
            e.preventDefault();
            document.querySelector('#btn-decl .btn-outline').click();

            $.ajax({
                type: "POST",
                url: "updateDataPengumpulan",
                data: $('#in-open-dokumen').serialize() + '&acc=false&komentar=' +
                    document.getElementById('komentar-tolak').value,
                success: function(response) {
                    console.log(response);
                    getDataPengumpulan();
                },
                error: function(response) {
                    console.log(response);
                }
            });
        });

        function selectFilter(value) {
            document.querySelectorAll('#table-body tr').forEach(function(row) {
                const statusCell = row.querySelector('td:nth-child(6)');
                if (statusCell) {
                    const statusText = statusCell.textContent.toLowerCase();
                    if (value === 'semua') {
                        row.style.display = '';
                    } else if (value === 'baru') {
                        row.style.display = statusCell.children[0].children[0].style.opacity == 1 ? '' : 'none';
                    } else if (value === 'tertanggung') {
                        row.style.display = statusText.includes('tertanggung') ? '' : 'none';
                    } else if (value === 'selesai') {
                        row.style.display = statusText.includes('selesai') ? '' : 'none';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        }

        document.getElementById('filter-data').addEventListener('change', function() {
            removeTableActive();
            selectFilter(this.value);
        });
    </script>

</div>