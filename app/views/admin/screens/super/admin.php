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
</style>
<div id="admin-page">
    <div id="page-content-top">
        <?php
        $tipe = explode(' ', $data['title']);
        echo '<h1>Data <strong>' . ucwords($data['user']->adminApa === TipeAdmin::Super ? end($tipe) : $data['user']->adminApa->value) . '</strong></h1>';
        ?>
        <div id="page-content-top-right">
            <div class="w-100 input-group d-flex">
                <label class="input-group-text rounded-start-pill" for="filter-data">level</label>
                <select class="form-select rounded-end-pill" id="filter-data">
                    <option selected value="semua">Semua</option>
                    <option value="super">Super</option>
                    <option value="jurusan">Jurusan</option>
                    <option value="pusat">Pusat</option>
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
                    <th scope="col" style="width: 5%;">NO</th>
                    <th scope="col" style="width: 10%;">ID Admin</th>
                    <th scope="col" style="width: 50%;">NAMA</th>
                    <th scope="col" style="width: 10%;">Level Admin</th>
                </tr>
            </thead>
            <tbody class="align-middle" id="table-body"></tbody>
        </table>
    </div>
    <script>
        function generateTableBodyItems(data) {
            let tableBody = document.createElement('tbody');
            let countItem = 0;

            data.forEach(dataAdmin => {
                let tr = document.createElement('tr');

                tr.innerHTML = `
                    <td>${countItem + 1}</td>
                    <td>${dataAdmin.id_admin}</td>
                    <td>${dataAdmin.nama}</td>
                    <td>${dataAdmin.level_admin}</td>
                `;
                tableBody.appendChild(tr);

                countItem++;
            });

            return tableBody;
        }


    </script>