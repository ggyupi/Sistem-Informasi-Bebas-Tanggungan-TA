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

    #total-tanggungan-bottom .flex-row {
        gap: 12px;
    }
</style>

<div id="pengumpulan-page">
    <div id="page-content-top">
        <h1>Dokumen <strong><?= $data['user']->getPeopleName() ?></strong></h1>
    </div>

    <div id="page-content-middle">
        <div id="page-content-middle-left">
            <div id="total-tanggungan">
                <div class="d-flex flex-row align-items-center justify-content-between" id="total-tanggungan-top">
                    <div class="d-flex flex-row align-items-center">
                        <h2>Tanggungan Jurusan</h2>
                        <div class="status-badge-text slim primary" id="total-dokumen">3</div>
                    </div>
                    <p id="last-update">12 Desember 2024</p>
                </div>
                <div class="d-flex flex-row" style="gap: 12px;" id="total-tanggungan-bottom">
                    <div class="d-flex flex-row align-items-center">
                        <div class="status-badge-text success" id="total-verifikasi">3</div>
                        <h5>Terverfikasi</h5>
                    </div>
                    <div class="d-flex flex-row align-items-center">
                        <div class="status-badge-text" id="total-pending">3</div>
                        <h5>Pending</h5>
                    </div>
                    <div class="d-flex flex-row align-items-center">
                        <div class="status-badge-text danger" id="total-tertanggung">3</div>
                        <h5>Tertanggung</h5>
                    </div>
                </div>
            </div>

            <div id="list-dokumen-wrapper">
                <h2>Daftar Dokumen Jurusan</h2>
                <div class="d-flex flex-column" id="list-dokumen">
                </div>
            </div>
        </div>

        <form id="form-pengumpulan">
           
        </form>
    </div>

    <div class="d-flex flex-row align-items-center justify-content-between" id="page-content-bottom">
        <h2>Silahkan Upload</h2>
        <button class="btn btn-secondary">Upload</button>
    </div>

    <?php include_once VIEWS . "template/script-helper.php"; ?>
    <script>
        function generatePageContent(data) {
            const listDokumen = document.getElementById('list-dokumen');
            listDokumen.innerHTML = '';
            const fomrPengumpulan = document.getElementById('form-pengumpulan');
            fomrPengumpulan.innerHTML = '';

            let countVerifikasi = 0;
            let countPending = 0;
            let countTertanggung = 0;
            let lastestDate = '';

            for (const dataItem of data) {
                // LIST
                let listDokumenItem = document.createElement('div');
                listDokumenItem.classList.add('list-dokumen-item');
                let statusBadge = document.createElement('div');
                statusBadge.classList.add('status-badge-text');

                switch (dataItem.status) {
                    case '<?= StatusDokumen::Diverifikasi->value ?>':
                        statusBadge.innerHTML = `<?= SvgIcons::getIconWithColor(Icons::Check, 'white') ?>`;
                        statusBadge.classList.add('success');
                        countVerifikasi += 1;
                        break;
                    case '<?= StatusDokumen::Menunggu->value ?>':
                        statusBadge.innerHTML = `<?= SvgIcons::getIconWithColor(Icons::Question, 'white') ?>`;
                        statusBadge.classList.add('warning');
                        countPending += 1;
                        break;
                    case '<?= StatusDokumen::Ditolak->value ?>':
                        statusBadge.innerHTML = `<?= SvgIcons::getIconWithColor(Icons::Close, 'white') ?>`;
                        statusBadge.classList.add('danger');
                        countTertanggung += 1;
                        break;
                    default:
                        statusBadge.innerHTML = `<?= SvgIcons::getIconWithColor(Icons::Question, 'white') ?>`;
                        statusBadge.classList.add('danger');
                        countTertanggung += 1;
                        break;
                }
                let paragraph = document.createElement('p');
                paragraph.textContent = dataItem.dokumen;
                listDokumenItem.appendChild(statusBadge);
                listDokumenItem.appendChild(paragraph);
                listDokumen.appendChild(listDokumenItem);

                // Form Pengumpulan

                let formItem = document.createElement('div');
                formItem.id = 'form-pengumpulan-item';

                let formHeader = document.createElement('div');
                formHeader.classList.add('border-bottom');
                formHeader.id = 'form-pengumpulan-item-header';
                statusBadge = '';
                switch (dataItem.status) {
                    case '<?= StatusDokumen::Diverifikasi->value ?>':
                        statusBadge = ` <?= statusBadge('success', Icons::Check, 'Terverfikasi') ?>`;
                        break;
                    case '<?= StatusDokumen::Menunggu->value ?>':
                        statusBadge = ` <?= statusBadge('warning', Icons::Question, 'Menunggu') ?>`;
                        break;
                    case '<?= StatusDokumen::Ditolak->value ?>':
                        statusBadge = ` <?= statusBadge('danger', Icons::Close, 'Ditolak') ?>`;
                        break;
                    default:
                        statusBadge = ` <?= statusBadge('danger', Icons::Question, 'Kosong') ?>`;
                        break;
                }
                let formattedDateUpload = '';
                if (typeof dataItem.tanggal_upload !== 'undefined') {
                    const date = new Date(dataItem.tanggal_upload);
                    if (lastestDate === '') {
                        lastestDate = date;
                    }
                    if (date.getTime() > lastestDate.getTime()) {
                        lastestDate = date;
                    }
                    formattedDateUpload = formatDate(date);
                }
                formHeader.innerHTML = `
                    <h2>${dataItem.dokumen}</h2>
                    <div class="d-flex flex-row align-items-center">
                        <p>${formattedDateUpload}</p>
                        ${statusBadge}
                    </div>
                `;
                formItem.appendChild(formHeader);

                let uploadWrapper = document.createElement('div');
                uploadWrapper.id = 'form-pengumpulan-upload-wrapper';
                uploadWrapper.innerHTML = `
                <h3>Bukti Mendukung</h3>
                    <label for="file-input" class="form-pengumpulan-upload">
                        <p id="upload-placeholder">Upload Dokumen Disini min</p>
                        <div class="d-none" id="upload-terlampir-wrapper">
                            <div id="upload-terlampir">
                                <?= SvgIcons::getIconWithFill(Icons::Document, 'var(--bs-tertiary-color)') ?>
                                <p></p>
                            </div>
                            <div id="upload-actions">
                                <?= iconButton('', Icons::Upload, 'var(--bs-emphasis-color)', ' ') ?>
                                <?= iconButton('', Icons::Download, 'var(--bs-emphasis-color)', ' ') ?>
                                <?= iconButton('', Icons::OpenInNewTab, 'var(--bs-emphasis-color)', ' ') ?>
                            </div>
                        </div>
                    </label>
                    <input type="file" class="d-none" id="file-input">
                `;

                if (typeof dataItem.path_dokumen !== 'undefined') {
                    uploadWrapper.querySelector('#upload-terlampir p').textContent = getFileName(dataItem.path_dokumen);
                    let formPengumpulanUpload = uploadWrapper.getElementsByClassName('form-pengumpulan-upload')[0];
                    formPengumpulanUpload.classList.add('has-file');
                    formPengumpulanUpload.addEventListener('click', function(e) {
                        console.log(e.target);
                        if (e.target.closest('#upload-actions button:nth-child(1)')) {
                            formPengumpulanUpload.click();
                        }
                        if (e.target.closest('#upload-actions button:nth-child(2)')) {
                            let link = document.createElement('a');
                            link.href = pdfDatabasePrefix + dataItem.path_dokumen;
                            link.setAttribute('download', getFileName(dataItem.path_dokumen));
                            link.style.display = 'none';
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        }
                        if (e.target.closest('#upload-actions button:nth-child(3)')) {
                            window.open(`${pdfDatabasePrefix+dataItem.path_dokumen}`, '_blank');
                        }
                        if (e.target.id === 'upload-terlampir-wrapper') {
                            e.preventDefault();
                            window.open(pdfDatabasePrefix + dataItem.path_dokumen, '_blank');
                        }

                    });
                }
                formItem.appendChild(uploadWrapper);

                let komentarToggle = document.createElement('div');
                komentarToggle.classList.add('toggle-komentar', 'd-none');
                if (typeof dataItem.isi_komentar !== 'undefined' &&
                    dataItem.status !== '<?= StatusDokumen::Diverifikasi->value ?>') {
                    komentarToggle.classList.remove('d-none');
                    komentarToggle.innerHTML = `
                    <?= SvgIcons::getIcon(Icons::Message) ?>
                    <h3>Komentar</h3>`;
                }
                komentarToggle.addEventListener('click', function() {
                    komentarToggle.classList.toggle('komentar-expand');
                });
                formItem.appendChild(komentarToggle);

                let formattedDateKomentar = '';
                if (typeof dataItem.tanggal_upload !== 'undefined') {
                    const date = new Date(dataItem.tanggal_komentar);
                    formattedDateKomentar = formatDate(date);
                }
                let komentarWrapper = document.createElement('div');
                komentarWrapper.id = 'komentar-wrapper';
                komentarWrapper.innerHTML = `
                    <div id="komentar-people">
                        <div class="member-picture">
                            <img src="<?= IMGS; ?>anggota/Raruu.webp" />
                        </div>
                        <h4>${dataItem.nama_admin} <?= SvgIcons::getIconWithColor(Icons::Minidot) ?></h4>
                        <p id="tgl-komentar">${formattedDateKomentar}</p>
                    </div>
                    <div id="komentar-text-wrapper">
                        <p>${dataItem.isi_komentar}</p>
                    </div> `;
                formItem.appendChild(komentarWrapper);

                document.getElementById('form-pengumpulan').appendChild(formItem);
            }

            let totalTanggungan = document.getElementById('total-tanggungan');
            totalTanggungan.querySelector('#total-dokumen').textContent = countVerifikasi + countPending + countTertanggung;
            totalTanggungan.querySelector('#total-verifikasi').textContent = countVerifikasi;
            totalTanggungan.querySelector('#total-pending').textContent = countPending;
            totalTanggungan.querySelector('#total-tertanggung').textContent = countTertanggung;
            totalTanggungan.querySelector('#last-update').textContent = formatDate(lastestDate);
        }


        function getDataPengumpulan() {
            $.ajax({
                type: "POST",
                url: "getDataPengumpulan",
                success: function(response) {
                    console.log(response);
                    let data = JSON.parse(response);
                    console.log(data);
                    generatePageContent(data);
                },
                error: function(response) {
                    console.log(response);
                }
            });
        }
        getDataPengumpulan();
    </script>
</div>