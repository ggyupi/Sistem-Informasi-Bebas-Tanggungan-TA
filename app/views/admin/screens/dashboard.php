<?php
include_once VIEWS . 'component/jam-card.php';
include_once VIEWS . 'component/status-badge.php';
include_once VIEWS . 'component/btn-icon.php';
include_once VIEWS . 'admin/template/pengumpulan-modal.php';
?>
<h1>Selamat Datang, Admin <strong><?= ucwords($data['user']->adminApa->value) ?></strong></h1>
<br>
<div class="d-flex flex-column" style="gap: 26px;">
    <div class="d-flex flex-row" style="gap: 32px; flex-wrap: wrap;">
        <?php
        $adminTingkat = ucwords($data['user']->adminApa->value);

        $urlSuccess = 'screen?screen=pengumpulan&filter=selesai';
        $urlPending = 'screen?screen=pengumpulan&filter=baru';
        $urlDanger = 'screen?screen=pengumpulan&filter=tertanggung';

        if ($adminTingkat === 'Jurusan') {
            echo statusCard(
                'card-status-jurusan',
                'Status Pengumpulan',
                [
                    [
                        'type' => 'success',
                        'icon' => Icons::Check,
                        'title' => '<span id="jurusan-status-diverifikasi">Loading...</span>',
                        'subtitle' => 'Dokumen diverifikasi',
                        'href' => $urlSuccess
                    ],
                    [
                        'type' => 'warning',
                        'icon' => Icons::Question,
                        'title' => '<span id="jurusan-status-menunggu">Loading...</span>',
                        'subtitle' => 'Dokumen pending',
                        'href' => $urlPending
                    ],
                    [
                        'type' => 'danger',
                        'icon' => Icons::Close,
                        'title' => '<span id="jurusan-status-ditolak">Loading...</span>',
                        'subtitle' => 'Dokumen ditolak',
                        'href' => $urlDanger
                    ]
                ]
            );
        } elseif ($adminTingkat === 'Pusat') {
            echo statusCard(
                'card-status-pusat',
                'Status Pengumpulan',
                [

                    [
                        'type' => 'success',
                        'icon' => Icons::Check,
                        'title' => '<span id="pusat-status-diverifikasi">Loading...</span>',
                        'subtitle' => 'Dokumen diverifikasi',
                        'href' => $urlSuccess
                    ],
                    [
                        'type' => 'warning',
                        'icon' => Icons::Question,
                        'title' => '<span id="pusat-status-menunggu">Loading...</span>',
                        'subtitle' => 'Dokumen pending',
                        'href' => $urlPending
                    ],
                    [
                        'type' => 'danger',
                        'icon' => Icons::Close,
                        'title' => '<span id="pusat-status-ditolak">Loading...</span>',
                        'subtitle' => 'Dokumen ditolak',
                        'href' => $urlDanger
                    ]
                ]
            );
        }
        include_once VIEWS . 'admin/template/jam-card.php';
        ?>
    </div>
    <h2><Strong>TOP 3</Strong> Dokumen Terbaru</h2>
    <div id="table-wrapper">
        <table class="table table-hover" style="overflow-y: auto;">
            <thead>
                <tr>
                    <th scope="col">NO</th>
                    <th scope="col" style="width: 10%;">NIM</th>
                    <th scope="col" style="width: 35%;">NAMA</th>
                    <th scope="col">JURUSAN</th>
                    <th scope="col">PROGRAM STUDI</th>
                </tr>
            </thead>
            <tbody class="align-middle" id="table-body">

            </tbody>
        </table>
    </div>
</div>

<?php
include_once VIEWS . 'admin/template/dashboard-script.php';
include_once VIEWS . "template/script-helper.php";
include_once VIEWS . 'admin/template/pengumpulan-modal-script.php';
?>
<script>
    const iconAcc = '<?= SvgIcons::getIcon(Icons::Check) ?>';
    const iconDecl = '<?= SvgIcons::getIcon(Icons::Close) ?>';
    const iconQuestion = '<?= SvgIcons::getIcon(Icons::Question) ?>';
    const btnSee = '<?= iconButton('btn-see', Icons::Eye, 'var(--bs-emphasis-color)', '#onclick') ?>';
    const btnAcc = '<?= iconButton('btn-acc', Icons::Check, 'green', '#onclick') ?>';
    const btnDecl = '<?= iconButton('btn-decl', Icons::Close, 'red', '#onclick') ?>';
    const badgeTertanggung = `<?= statusBadge('danger', Icons::Close, 'Tertanggung') ?>`;
    const badgeSelesai = `<?= statusBadge('success', Icons::Check, 'Selesai') ?>`;

    let idTableExpand = -1;

    function generateTableBodyItems(data) {
        let tableBody = document.createElement('tbody');
        let countItem = 0;

        for (let i = 0; i < data.length; i++) {
            countItem += 1;
            let tr = document.createElement('tr');
            let dataMahasiswa = data[i].data_mahasiswa;
            let dataDetails = data[i].data_detail;
            tr.innerHTML = `
                    <td>${countItem}</td>
                    <td id="search-nim">${dataMahasiswa.nim}</td>
                    <td id="search-mahasiswa">${dataMahasiswa.nama}</td>
                    <td>${dataMahasiswa.jurusan}</td>
                    <td>${dataMahasiswa.program_studi}</td>                     
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

                        pdfViewerLoadPdf('${pdfFileUrl}', '${dataDetail.status}');`));
                    tableExpandItem.onclick = function() {
                        setDokumenInOpen(dataDetail.id, dataDetail.dokumen, dataMahasiswa.nama, dataMahasiswa.nim);
                        pdfViewerLoadPdf(pdfFileUrl, dataDetail.status);
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

            for (let j = 0; j < dataDetails.length; j++) {
                const dataDetail = dataDetails[j];
                let tableExpandItem = rowDetails.children[0].children[0].children[j];
                tableExpandItem.children[0].children[0].classList.remove('success', 'warning', 'danger');
                let pdfFileUrl = pdfDatabasePrefix + dataDetail.path_dokumen;
                let actions = [
                    btnSee.replace(`#onclick`, `
                        setDokumenInOpen('${dataDetail.id}', '${dataDetail.dokumen}', '${dataMahasiswa.nama}', '${dataMahasiswa.nim}');
                        pdfViewerLoadPdf('${pdfFileUrl}', '${dataDetail.status}');`),
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
                    tableExpandItem.children[1].style = '';
                    tableExpandItem.children[1].innerHTML = actions.join('');
                    tableExpandItem.onclick = function() {
                        setDokumenInOpen(dataDetail.id, dataDetail.dokumen, dataMahasiswa.nama, dataMahasiswa.nim);
                        pdfViewerLoadPdf(pdfFileUrl, dataDetail.status);
                    };
                    tableExpandItem.dataset.bsToggle = "modal";
                    tableExpandItem.dataset.bsTarget = "#btn-see";
                    tableExpandItem.classList.add('table-expand-item-hoverable');
                } else {
                    tableExpandItem.children[1].style.opacity = '0';
                    tableExpandItem.children[1].style.pointerEvents = 'none';
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
        // if (getDataPengumpulanInUpdate) {
        //     return;
        // }
        getDataPengumpulanInUpdate = true;
        $.ajax({
            type: "POST",
            url: "getRecentDokumenGrouped",
            success: function(response) {
                // console.log(response);
                let data = JSON.parse(response);
                console.log(data);
                if (useUpdate) {
                    updateTableBodyItems(data);
                } else {
                    let tableBody = document.getElementById('table-body');
                    tableBody.innerHTML = '';
                    tableBody.append(...generateTableBodyItems(data).children);                  
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
</script>
<?php include_once VIEWS . 'admin/template/pengumpulan-update-script.php'; ?>