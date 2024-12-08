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

<?php
include_once VIEWS . 'admin/template/pengumpulan-modal.php';
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
                    <option value="semua" <?= $data['filter'] == 'semua' ? 'selected' : '' ?>>Semua</option>
                    <option value="baru" <?= $data['filter'] == 'baru' ? 'selected' : '' ?>>Baru</option>
                    <option value="tertanggung" <?= $data['filter'] == 'tertanggung' ? 'selected' : '' ?>>Tertanggung</option>
                    <option value="selesai" <?= $data['filter'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                </select>
            </div>
            <div style="width: 120%;" class="d-flex input-group" role="search">
                <label class="input-group-text rounded-start-pill"
                    for="search-input"><?= SvgIcons::getIcon(Icons::Search) ?></label>
                <input class="form-control me-2 rounded-end-pill" type="search" placeholder="Telusuri"
                    id="search-input">
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

    <nav class="d-flex flex-row align-items-center justify-content-between" id="nav-pagination">
        <div class="w-25 input-group d-flex">
            <label class="input-group-text rounded-start-pill" for="pagination-settings">Halaman</label>
            <select class="form-select rounded-end-pill" id="pagination-settings">
                <option selected value="0">Semua</option>
                <option value="1">1-10</option>
                <option value="2">1-25</option>
                <option value="3">1-50</option>
            </select>
        </div>
        <div class="pagination">
            <div class="pagination-nextprev" id="pagination-prev">&lt;</div>
            <div class="pagination-number pagination-active">1</div>
            <div class="pagination-span">...</div>
            <div class="pagination-number">2</div>
            <div class="pagination-number">3</div>
            <div class="pagination-number">4</div>
            <div class="pagination-span">...</div>
            <div class="pagination-number">5</div>
            <div class="pagination-nextprev" id="pagination-end">></div>
        </div>
    </nav>

    <?php 
    include_once VIEWS . "template/script-helper.php";
    include_once VIEWS . 'admin/template/pengumpulan-modal-script.php';
    ?>
    <script>       
        function getRowsPerPage(value) {
            switch (value) {
                case '0':
                    return 0;
                case '1':
                    return 10;
                case '2':
                    return 25;
                case '3':
                    return 50;
                default:
                    return 0;
            }
        }

        let idTableExpand = -1;
        let rowsPerPage = getRowsPerPage(document.getElementById('pagination-settings').value);
        let currentPage = 1;

        function nextprevPagination(value) {
            removeTableActive();
            document.querySelectorAll('.pagination-number').forEach(function(paginationNum) {
                paginationNum.classList.remove('pagination-active');
            });
            let rows = document.querySelectorAll('tbody tr');
            const totalPages = Math.ceil((rows.length / 2) / rowsPerPage);
            if (currentPage + value > 0 && currentPage + value <= totalPages) {
                currentPage += value;
                console.log(currentPage);
            }
            renderPaggedTable();
        }

        document.getElementById('pagination-prev').addEventListener('click', function() {
            nextprevPagination(-1);
        });

        document.getElementById('pagination-end').addEventListener('click', function() {
            nextprevPagination(1);
        })

        document.getElementById('pagination-settings').addEventListener('change', function() {
            rowsPerPage = getRowsPerPage(this.value);
            renderPaggedTable();
        });

        document.querySelectorAll('.pagination-number').forEach(function(paginationNumber) {
            paginationNumber.addEventListener('click', function(e) {
                if (paginationNumber.classList.contains('pagination-active')) {
                    return;
                }
                document.querySelectorAll('.pagination-number').forEach(function(pn) {
                    pn.classList.remove('pagination-active');
                });
                paginationNumber.classList.add('pagination-active');
                let rows = document.querySelectorAll('tbody tr');
                const totalPages = Math.ceil((rows.length / 2) / rowsPerPage);

                let pageNumber = parseInt(paginationNumber.innerHTML);
                if (pageNumber > totalPages) {
                    pageNumber = totalPages;
                }
                currentPage = pageNumber;
                removeTableActive();
                renderPaggedTable();
            });
        });

        const searchInput = document.getElementById('search-input');
        searchInput.addEventListener('input', function() {
            removeTableActive();
            renderTableWithTweaks();
        });

        let filterData = document.getElementById('filter-data');
        filterData.addEventListener('change', function() {
            removeTableActive();
            renderTableWithTweaks();
        });

        function renderTableWithTweaks() {
            let search = searchInput.value.toLowerCase();
            let skipByFilter = selectFilter(filterData.value);
            funSearch('tr #search-mahasiswa', search);
            renderPaggedTable(search != '' || skipByFilter);
        }

        function renderPaggedTable(skipPagination = false) {
            if (skipPagination) {
                document.querySelector('.pagination').classList.add('d-none');
                document.getElementById('nav-pagination').classList.add('d-none');
                return;
            } else {
                document.querySelector('.pagination').classList.remove('d-none');
                document.getElementById('nav-pagination').classList.remove('d-none');
            }
            let rows = document.querySelectorAll('tbody tr');
            let startIndex = Math.max(0, (currentPage - 1) * rowsPerPage * 2);
            let endIndex = startIndex + rowsPerPage * 2;
            for (let i = 0; i < rows.length; i += 2) {
                let row = rows[i];
                if (i >= startIndex && i < endIndex || endIndex == 0) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
            if (rowsPerPage == 0) {
                document.querySelector('.pagination').classList.add('d-none');
                return;
            } else {
                document.querySelector('.pagination').classList.remove('d-none');
            }

            const totalPages = Math.ceil((rows.length / 2) / rowsPerPage);
            let paginationNumber = document.querySelectorAll('.pagination-number');
            let paginationSpan = document.querySelectorAll('.pagination-span');
            if (totalPages > 5) {
                for (let i = 1; i < paginationNumber.length; i++) {
                    paginationNumber[i].classList.remove('d-none');
                }
                paginationNumber[paginationNumber.length - 1].innerHTML = totalPages;

                paginationSpan[0].classList.toggle('d-flex', currentPage > 3);
                paginationSpan[1].classList.toggle('d-flex', currentPage < totalPages - 2);

                let startPage = 1;
                if (paginationSpan[0].classList.contains('d-flex') &&
                    paginationSpan[1].classList.contains('d-flex')) {
                    startPage = Math.max(1, currentPage - 1);
                } else {
                    startPage = currentPage > Math.ceil(totalPages / 2) ? totalPages - 3 : 2;
                }
                for (let i = 1; i <= 3; i++) {
                    paginationNumber[i].innerHTML = startPage++;
                    paginationNumber[i].classList.toggle('pagination-active', paginationNumber[i].innerHTML == currentPage);
                }
            } else {
                for (let i = 0; i < paginationNumber.length; i++) {
                    paginationNumber[i].classList.remove('d-none');
                    paginationNumber[i].innerHTML = i + 1;
                    paginationNumber[i].classList.toggle('pagination-active', paginationNumber[i].innerHTML == currentPage);
                }
                for (let i = totalPages; i < paginationNumber.length; i++) {
                    paginationNumber[i].classList.add('d-none');
                }
            }
        }

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

        function selectFilter(value) {
            let skipPagination = true;
            document.querySelectorAll('#table-body tr').forEach(function(row) {
                const statusCell = row.querySelector('td:nth-child(6)');
                if (statusCell) {
                    const statusText = statusCell.textContent.toLowerCase();
                    if (value === 'semua') {
                        skipPagination = false;
                        row.classList.remove('d-none');
                    } else if (value === 'baru') {
                        row.classList.toggle('d-none', statusCell.children[0].children[0].style.opacity != 1);
                    } else if (value === 'tertanggung') {
                        row.classList.toggle('d-none', !statusText.includes('tertanggung'));
                    } else if (value === 'selesai') {
                        row.classList.toggle('d-none', !statusText.includes('selesai'));
                    } else {
                        row.classList.remove('d-none');
                        skipPagination = false;
                    }
                }
            });
            return skipPagination;
        }

        var getDataPengumpulanInUpdate = false;

        let callOnStart = true;

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
                        renderTableWithTweaks(searchInput.value.toLowerCase());
                    }
                    getDataPengumpulanInUpdate = false;

                    if (callOnStart) {
                        callOnStart = false;
                        selectFilter("<?= $data['filter'] ?>");
                    }
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
    <?php include_once VIEWS . 'admin/template/pengumpulan-update-script.php';?>
</div>