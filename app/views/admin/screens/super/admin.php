<?php
include_once VIEWS . 'component/status-badge.php';
include_once VIEWS . 'component/btn-icon.php';
?>

<style>
    #admin-page {
        display: flex;
        flex-direction: column;
        gap: 24px;
        flex: 1;
        overflow-y: auto;
    }

    #input-pick-tanggal_lahir {
        padding: 0.375rem 0.75rem;
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    #input-pick-tanggal_lahir:hover {
        background-color: var(--bs-tertiary-bg);
    }

    #input-pick-tanggal_lahir svg {
        width: 16px;
        height: 16px;
    }

    @media (max-width: 1200px) {
        #form-dialog .modal .modal-dialog {
            max-width: 53vw !important;
        }
    }

    @media (max-width: 768px) {
        #form-dialog .modal .modal-dialog {
            max-width: unset !important;
        }
    }
</style>


<?php
dialogYesNoCustom(
    'btn-del',
    '<h1 class="modal-title fs-5">Hapus Data?</h1>',
    'Apakah anda yakin ingin menghapus data ini?',
    '
    <button type="button" class="btn btn-outline" data-bs-dismiss="modal">' . SvgIcons::getIcon(Icons::Close) . 'Ga Jadi</button>
    <button class="btn btn-danger" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#btn-del" 
    onclick="deleteAdminData();">' .
    SvgIcons::getIcon(Icons::Trash) . 'Hapus
    </button>',
);
?>

<form id="form-dialog">
    <div class="modal fade" id="the-dialog" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 45vw;">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex flex-row align-items-center justify-content-between" style="flex: 1;">
                        <h1 id="dialog-title" class="modal-title fs-5">XXXXX</h1>
                        <?= iconButton('', Icons::Close, 'white') ?>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-row align-items-start justify-content-start"
                        style="gap: 24px; flex-wrap: wrap;">
                        <div class="d-flex flex-column align-items-start" style="gap: 4px; flex: 1;">
                            <input type="text" class="d-none" name="id_admin_ori" id="input-id-admin-ori" readonly />
                            <label for="input-id-admin" class="form-label"><b>ID Admin</b></label>
                            <input type="text" class="form-control" name="id_admin" id="input-id-admin" required />
                            <label for="input-password" class="form-label"><b>Password</b></label>
                            <input type="password" class="form-control" value="" name="password" id="input-password"
                                required />
                            <label for="input-tingkat" class="form-label"><b>Tingkat Admin</b></label>
                            <select name="level" class="form-select" id="input-tingkat">
                                <option selected>Tingkat Admin</option>
                                <?php foreach (TipeAdmin::cases() as $tipe): ?>
                                    <option value="<?= $tipe->name ?>"><?= ucwords($tipe->name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="d-flex flex-column align-items-start" style="gap: 4px; flex: 1;">
                            <label for="input-nama" class="form-label"><b>Nama</b></label>
                            <input type="text" class="form-control" value="" name="nama" id="input-nama" required />
                            <label class="form-label"><b>Jenis Kelamin</b></label>
                            <div class="d-flex flex-row align-items-stretch justify-content-evenly" style="gap: 32px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="Laki-laki" name="jenis_kel"
                                        id="jenis-kel-laki">
                                    <label class="form-check-label" for="jenis-kel-laki">
                                        Laki-Laki
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="Perempuan" name="jenis_kel"
                                        id="jenis-kel-perempuan">
                                    <label class="form-check-label" for="jenis-kel-perempuan">
                                        Perempuan
                                    </label>
                                </div>
                            </div>
                            <label for="input-tanggal_lahir" class="form-label"><b>Tanggal Lahir</b></label>
                            <input type="date" class="form-control" value="" name="tanggal_lahir"
                                id="input-tanggal_lahir" required />
                            <label for="input-lahir" class="form-label"><b>Tempat Lahir</b></label>
                            <input type="text" class="form-control" value="" name="tempat_lahir" id="input-lahir"
                                required />
                            <label for="input-nik" class="form-label"><b>NIK</b></label>
                            <input type="text" class="form-control" value="" name="nik" id="input-nik" required />
                            <label for="input-alamat" class="form-label"><b>Alamat</b></label>
                            <input type="text" class="form-control" value="" name="alamat" id="input-alamat" required />
                            <label for="input-telp" class="form-label"><b>Nomor Telepon</b></label>
                            <input type="text" class="form-control" value="" name="no_telp" id="input-telp" required />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex flex-row align-items-center justify-content-between"
                        style="flex: 1;gap: 16px;flex-wrap: wrap;">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#btn-del"
                            data-bs-dismiss="modal">
                            <?= SvgIcons::getIcon(Icons::Trash) ?> Hapus
                        </button>
                        <div class="d-flex flex-row align-items-center justify-content-between" style="gap: 8px;">
                            <button type="button" class="btn btn-outline" data-bs-dismiss="modal"
                                onclick="resetFormDialog(); ">
                                <?= SvgIcons::getIcon(Icons::Close) ?> Ga Jadi
                            </button>
                            <button type="button" class="btn btn-primary" onclick="saveFormDialog();">
                                <?= SvgIcons::getIcon(Icons::Save) ?> Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<div id="admin-page">
    <div id="page-content-top">
        <div class="d-flex flex-column align-items-start">
            <h1><strong>Data Admin</strong></h1>
            <button class="btn btn-primary" id="btn-add-admin" data-bs-toggle="modal" data-bs-target="#the-dialog"
                onclick="
                resetFormDialog();
                let btnDel = document.querySelector('#form-dialog .modal-footer .btn-danger');
                btnDel.style.opacity = 0;
                btnDel.style.pointerEvents = 'none';">
                <?= SvgIcons::getIcon(Icons::Add) ?> Tambah Admin
            </button>
        </div>
        <div id="page-content-top-right">
            <div class="w-100 input-group d-flex">
                <label class="input-group-text rounded-start-pill" for="filter-data">level</label>
                <select class="form-select rounded-end-pill" id="filter-data">
                    <option selected value="semua">Semua</option>
                    <?php foreach (TipeAdmin::cases() as $tipe): ?>
                        <option value="<?= $tipe->name ?>"><?= ucwords($tipe->name) ?></option>
                    <?php endforeach; ?>
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
                    <th scope="col" style="width: 1%;">NO</th>
                    <th scope="col" style="width: 5%;">ID Admin</th>
                    <th scope="col" style="width: 50%;">NAMA</th>
                    <th scope="col" style="width: 10%;">Level Admin</th>
                </tr>
            </thead>
            <tbody class="align-middle" id="table-body"></tbody>
        </table>
    </div>

    <?php include_once VIEWS . "template/script-helper.php"; ?>
    <script>
        const searchInput = document.getElementById('search-input');
        searchInput.addEventListener('input', function () {
            let search = this.value.toLowerCase();
            funSearch('tr #search-nama', search);
        });

        function resetFormDialog() {
            document.getElementById('form-dialog').reset();
        }

        // document.getElementById('the-dialog').addEventListener('hidden.bs.modal', () => {
        //     resetFormDialog();
        // });

        function openFormDialog(data) {
            let dialog = document.querySelector('#the-dialog .modal-dialog .modal-content');
            let header = dialog.querySelector('.modal-header');
            let body = dialog.querySelector('.modal-body');
            let footer = dialog.querySelector('.modal-footer');
            let title = header.querySelector('#dialog-title');

            if (!data) {
                title.textContent = 'Tambah Admin';
                return;
            } else {
                let id = body.querySelector('#input-id-admin');
                let password = body.querySelector("#input-password");
                let name = body.querySelector('#input-nama');
                let tanggal_lahir = body.querySelector('#input-tanggal_lahir');
                let tempat_lahir = body.querySelector('#input-lahir');
                let nik = body.querySelector('#input-nik');
                let alamat = body.querySelector('#input-alamat');
                let telp = body.querySelector('#input-telp');
                let jenis_kel = body.querySelectorAll('input[name="jenis_kel"]');
                let tingkat = body.querySelector('#input-tingkat');

                id.value = data.id_admin;
                for (let i = 0; i < tingkat.children.length; i++) {
                    let element = tingkat.children[i];
                    if (element.value == data.level) {
                        element.selected = true;
                    }
                }
                password.value = data.password;
                name.value = data.nama;
                tanggal_lahir.value = data.tanggal_lahir;
                tempat_lahir.value = data.tempat_lahir;
                nik.value = data.nik;
                alamat.value = data.alamat;
                telp.value = data.no_telp;
                jenis_kel.forEach(element => {
                    if (element.value == data.jenis_kel) {
                        element.checked = true;
                    }
                });
                body.querySelector('#input-id-admin-ori').value = data.id_admin;
                title.textContent = `Edit [${data.id_admin}]`;

                let btnDel = document.querySelector('#form-dialog .modal-footer .btn-danger');
                btnDel.style.opacity = 1;
                btnDel.style.pointerEvents = 'auto';
            }
        }

        function closeFormDialog() {
            document.querySelector('#the-dialog .btn-outline').click();
        }

        function getAdminData(id) {
            $.ajax({
                type: "POST",
                url: "getAdminData",
                data: {
                    id: id
                },
                success: function (response) {
                    console.log(response);
                    let data = JSON.parse(response);
                    console.log(data);
                    openFormDialog(data);
                }
            });
        }

        function generateTableBodyItems(data) {
            let tableBody = document.createElement('tbody');
            let countItem = 0;

            data.forEach(dataAdmin => {
                let tr = document.createElement('tr');

                tr.innerHTML = `
                    <td>${countItem + 1}</td>
                    <td>${dataAdmin.id_admin}</td>
                    <td id="search-nama">${dataAdmin.nama}</td>
                    <td>${dataAdmin.level}</td>
                `;
                tr.dataset.bsToggle = "modal";
                tr.dataset.bsTarget = "#the-dialog";
                tr.onclick = function () {
                    getAdminData(dataAdmin.id_admin);
                };
                tableBody.appendChild(tr);

                countItem++;
            });

            return tableBody;
        }

        function getAdminList() {
            $.ajax({
                type: "POST",
                url: "getAdminList",
                success: function (response) {
                    // console.log(response);
                    let data = JSON.parse(response);
                    console.log(data);
                    let tableBody = document.getElementById('table-body');
                    tableBody.innerHTML = '';
                    tableBody.append(...generateTableBodyItems(data).children);
                }
            });
        }
        getAdminList();

        function saveFormDialog() {
            let data = new FormData(document.getElementById('form-dialog'));
            for (var pair of data.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }

            $.ajax({
                type: "POST",
                url: "saveAdminData",
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);
                    getAdminList();
                    closeFormDialog();
                    resetFormDialog();
                }
            });
        }

        function deleteAdminData() {
            let id = document.getElementById('input-id-admin-ori').value;

            if (id) {
                $.ajax({
                    type: "POST",
                    url: "deleteAdmin", // Endpoint untuk controller
                    data: {
                        id: id
                    },
                    success: function (response) {
                        console.log(response);
                        let result = JSON.parse(response);
                        if (result.status === "success") {
                            getAdminList();
                        } else {
                            console.log(result.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error:", error);
                        alert("Gagal menghapus data admin.");
                    }
                });
            } else {
                alert("ID Admin tidak ditemukan.");
            }
        }
    </script>