<script>
    function updateStatusCard() {
        $.ajax({
            type: "POST",
            url: "AdminController/getCountStatus",
            success: function (response) {
                try {
                    const data = JSON.parse(response);

                    // Variabel yang dirender dari PHP ke JavaScript
                    const adminTingkat = "<?= isset($adminTingkat) ? $adminTingkat : '' ?>";

                    if (adminTingkat === 'Jurusan' || adminTingkat === '') {
                        document.getElementById("jurusan-status-menunggu").innerText = data.Jurusan.menunggu || 0;
                        document.getElementById("jurusan-status-diverifikasi").innerText = data.Jurusan.diverifikasi || 0;
                        document.getElementById("jurusan-status-ditolak").innerText = data.Jurusan.ditolak || 0;
                    }
                    if (adminTingkat === 'Pusat' || adminTingkat === '') {
                        document.getElementById("pusat-status-menunggu").innerText = data.Pusat.menunggu || 0;
                        document.getElementById("pusat-status-diverifikasi").innerText = data.Pusat.diverifikasi || 0;
                        document.getElementById("pusat-status-ditolak").innerText = data.Pusat.ditolak || 0;
                    }
                } catch (error) {
                    console.error("Error parsing JSON or processing data: ", error);
                }
            },
            error: function (response) {
                console.error("Error fetching count status: ", response);
            }
        });
    }

    // Panggil fungsi pertama kali dan ulangi setiap 60 detik
    updateStatusCard();
    funToCallEachInterval.push(updateStatusCard);

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
                url: "getRecentDokumenGrouped",
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
                        funSearch('tr #search-mahasiswa', searchInput.value);
                    }
                    getDataPengumpulanInUpdate = false;
                    renderPaggedTable();
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

</script>