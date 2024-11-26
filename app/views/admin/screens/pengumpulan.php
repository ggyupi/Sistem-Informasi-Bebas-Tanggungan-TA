<?php
include VIEWS . 'component/status-badge.php';
include VIEWS . 'component/btn-icon.php';
?>

<style>
    #pengumpulan-page {
        display: flex;
        flex-direction: column;
        gap: 24px;
        flex: 1;
    }
</style>

<div id="pengumpulan-page">
    <form id="dialog-acc">
        <?=
        dialogYesNo(
            'btn-acc',
            'Acc?',
            'Logout dan Hapus Sesi Saat ini',
            SvgIcons::getIcon(Icons::Check) . 'Acc kan min',
            SvgIcons::getIcon(Icons::Close) . 'Ga Jadi',
            true
        );
        ?>
    </form>
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
                    <th scope="col">ID</th>
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



    <script>
        function removeTableActive() {
            document.querySelectorAll('tbody tr').forEach(function(row) {
                row.classList.remove('table-active');
            });
        }

        let idTableExpand = -1;

        function generateTableBodyItems(data) {
            const iconAcc = '<?= SvgIcons::getIcon(Icons::Check) ?>';
            const iconDecl = '<?= SvgIcons::getIcon(Icons::Close) ?>';
            const iconQuestion = '<?= SvgIcons::getIcon(Icons::Question) ?>';
            const btnSee = '<?= iconButton('btn-see', Icons::Eye, 'var(--bs-emphasis-color)') ?>';
            const btnAcc = '<?= iconButton('btn-acc', Icons::Check, 'green') ?>';
            const btnDecl = '<?= iconButton('btn-decl', Icons::Close, 'red') ?>';
            const badgeTertanggung = '<?= statusBadge('warning', Icons::Close, 'Tertanggung') ?>';
            const badgeSelesai = '<?= statusBadge('success', Icons::Check, 'Selesai') ?>';

            let tableBody = document.createElement('tbody');

            for (let i = 0; i < data.length; i++) {
                let tr = document.createElement('tr');
                let dataMahasiswa = data[i].data_mahasiswa;
                tr.innerHTML = `
                    <td>${dataMahasiswa.id}</td>
                    <td>${dataMahasiswa.nim}</td>
                    <td>${dataMahasiswa.nama}</td>
                    <td>${dataMahasiswa.jurusan}</td>
                    <td>${dataMahasiswa.programStudi}</td> 
                    <td style="place-items: center">${dataMahasiswa.status.toLowerCase() ===
                     "selesai" ? badgeSelesai : badgeTertanggung}</td>                   
                `;
                if (i == idTableExpand) {
                    tr.classList.add('table-active');
                }
                tableBody.appendChild(tr);

                // OnExampand
                let dataDetail = data[i].data_detail;
                tr = document.createElement('tr');

                let td = document.createElement('td');
                td.colSpan = 6;
                td.classList.add('table-expand-wrapper');

                let tableExpand = document.createElement('div');
                tableExpand.classList.add('table-expand');
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

                let actions = [btnSee, btnAcc, btnDecl];
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

        let test = [{
            data_mahasiswa: {
                id: 1,
                nim: '2341720157',
                nama: 'UwU Kagamihara',
                jurusan: 'Teknologi Informasi',
                programStudi: 'Teknik Informatika',
                status: 'Tertanggung'
            },
            data_detail: {
                dokumen: 'test',
                status: 'diverifikasi'
            }
        }, {
            data_mahasiswa: {
                id: 1,
                nim: '2341712357',
                nama: 'Kami Kagamihara',
                jurusan: 'Teknologi Informasi',
                programStudi: 'Teknik Informatika',
                status: 'Tertanggung'
            },
            data_detail: {
                dokumen: 'test',
                status: 'Tertanggung'
            }
        }];

        document.getElementById('table-body').append(...generateTableBodyItems(test).children);

        document.getElementById('dialog-acc').addEventListener('submit', function(e) {
            e.preventDefault();
            fetch(window.location.href, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        acc: this.acc.checked
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        window.location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error(error));
        });
    </script>

</div>