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

    #form-pengumpulan-item-header .flex-row {
        flex-wrap: wrap-reverse;
        justify-content: flex-end;
    }

    @media (max-width: 1200px) {
        #page-content-middle {
            flex-direction: column;
            overflow: unset;
        }

        #page-content-middle-left {
            width: 100%;
            overflow: unset;
        }

        #total-tanggungan #total-tanggungan-bottom {
            flex-direction: column !important;
        }
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
                        <h2>Tanggungan <?= $tingkat?></h2>
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
                <h2>Daftar Dokumen <?= $tingkat?></h2>
                <div class="d-flex flex-column" id="list-dokumen">
                </div>
            </div>
        </div>

        <form id="form-pengumpulan" enctype="multipart/form-data">
        </form>
    </div>

    <div class="d-flex flex-row align-items-center justify-content-between" id="page-content-bottom">
        <h2>Silahkan Lengkapi Dokumen Terlebih Dahulu</h2>
        <button class="btn btn-secondary" id="btn-upload" onclick="upload()" disabled>Upload</button>
    </div>

    <?php include_once VIEWS . "template/script-helper.php"; ?>
    <script>
        const statusBadgeIconVerified = `<?= SvgIcons::getIconWithColor(Icons::Check, 'white') ?>`;
        const statusBadgeIconPending = `<?= SvgIcons::getIconWithColor(Icons::Question, 'white') ?>`;
        const statusBadgeIconTertanggung = `<?= SvgIcons::getIconWithColor(Icons::Close, 'white') ?>`;
        const statusBadgeVerified = `<?= statusBadge('success', Icons::Check, 'Terverifikasi') ?>`;
        const statusBadgePending = `<?= statusBadge('warning', Icons::Question, 'Pending') ?>`;
        const statusBadgeTertanggung = `<?= statusBadge('danger', Icons::Close, 'Tertanggung') ?>`;
        const statusBadgeKosong = `<?= statusBadge('danger', Icons::Question, 'Kosong') ?>`;

        function refreshUploadSection() {
            let readyToUpload = Array.from(document.querySelectorAll('.form-pengumpulan-upload')).every(function(formPengumpulanUpload) {
                return formPengumpulanUpload.classList.contains('has-file');
            });
            let pageContentBottom = document.getElementById('page-content-bottom');
            if (readyToUpload) {
                pageContentBottom.children[0].innerHTML = 'Silahkan Upload';
                pageContentBottom.children[1].removeAttribute('disabled');
            } else {
                pageContentBottom.children[0].innerHTML = 'Silahkan Lengkapi Dokumen Terlebih Dahulu';
                pageContentBottom.children[1].setAttribute('disabled', 'true');
            }
        }

        function generatePageContent(data) {
            const btnUpload = ' <?= iconButton('', Icons::Upload, 'var(--bs-emphasis-color)', ' ') ?>';
            const btnDownload = ' <?= iconButton('', Icons::Download, 'var(--bs-emphasis-color)', ' ') ?>';
            const btnOpenInNewTab = ' <?= iconButton('', Icons::OpenInNewTab, 'var(--bs-emphasis-color)', ' ') ?>';

            const listDokumen = document.getElementById('list-dokumen');
            listDokumen.innerHTML = '';
            const formPengumpulan = document.getElementById('form-pengumpulan');
            formPengumpulan.innerHTML = '';

            let countVerifikasi = 0;
            let countPending = 0;
            let countTertanggung = 0;
            let lastestDate = '';

            for (let i = 0; i < data.length; i++) {
                const dataItem = data[i];
                // LIST
                let listDokumenItem = document.createElement('div');
                listDokumenItem.classList.add('list-dokumen-item');
                let statusBadge = document.createElement('div');
                statusBadge.classList.add('status-badge-text');

                switch (dataItem.status) {
                    case '<?= StatusDokumen::Diverifikasi->value ?>':
                        statusBadge.innerHTML = statusBadgeIconVerified;
                        statusBadge.classList.add('success');
                        countVerifikasi += 1;
                        break;
                    case '<?= StatusDokumen::Menunggu->value ?>':
                        statusBadge.innerHTML = statusBadgeIconPending;
                        statusBadge.classList.add('warning');
                        countPending += 1;
                        break;
                    case '<?= StatusDokumen::Ditolak->value ?>':
                        statusBadge.innerHTML = statusBadgeIconTertanggung;
                        statusBadge.classList.add('danger');
                        countTertanggung += 1;
                        break;
                    default:
                        statusBadge.innerHTML = statusBadgeIconPending;
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
                        statusBadge = statusBadgeVerified;
                        break;
                    case '<?= StatusDokumen::Menunggu->value ?>':
                        statusBadge = statusBadgePending;
                        break;
                    case '<?= StatusDokumen::Ditolak->value ?>':
                        statusBadge = statusBadgeTertanggung;
                        break;
                    default:
                        statusBadge = statusBadgeKosong;
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
                    <div class="d-flex flex-row align-items-center" style="">
                        <p>${formattedDateUpload}</p>
                        ${statusBadge}
                    </div>
                `;
                formItem.appendChild(formHeader);

                let uploadWrapper = document.createElement('div');
                uploadWrapper.id = 'form-pengumpulan-upload-wrapper';
                uploadWrapper.innerHTML = `
                <h3>Bukti Mendukung</h3>
                    <label for="file-input${i}" class="form-pengumpulan-upload">
                        <p id="upload-placeholder">Upload Dokumen Disini min</p>
                        <div class="d-none" id="upload-terlampir-wrapper">
                            <div class="w-75" id="upload-terlampir">
                                <?= SvgIcons::getIconWithFill(Icons::Document, 'var(--bs-tertiary-color)') ?>
                                <p></p>
                            </div>
                            <div id="upload-actions"></div>
                        </div>
                    </label>
                    <input type="file" class="d-none" name="${dataItem.id}" id="file-input${i}" accept=".pdf, .zip">                    
                `;
                let formPengumpulanUpload = uploadWrapper.getElementsByClassName('form-pengumpulan-upload')[0];

                uploadWrapper.querySelector(`#file-input${i}`).addEventListener('change', function(context) {
                    if (!context.target.files.length || context.target.value === '') {
                        // console.log('tidak ada file atau dialog dibatalkan');
                        formPengumpulanUpload.classList.remove('has-file');
                        uploadWrapper.querySelector('#upload-terlampir-wrapper').classList.add('d-none');
                        uploadWrapper.querySelector('#upload-placeholder').classList.remove('d-none');
                        refreshUploadSection();
                        return;
                    }
                    const cloneFormPengumpulanUpload = formPengumpulanUpload.cloneNode(true);
                    formPengumpulanUpload.parentNode.replaceChild(cloneFormPengumpulanUpload, formPengumpulanUpload);
                    formPengumpulanUpload = cloneFormPengumpulanUpload;
                    formPengumpulanUpload.addEventListener('click', function(e) {
                        if (e.target.closest('#upload-actions button:nth-child(1)')) {
                            formPengumpulanUpload.click();
                        }
                        if (e.target.id === 'upload-terlampir-wrapper' ||
                            e.target.parentNode.id === 'upload-terlampir' ||
                            e.target.id === 'upload-terlampir' ||
                            e.target.closest('#upload-actions button:nth-child(2)')) {
                            e.preventDefault();
                            const file = new Blob([context.target.files[0]], {
                                type: 'application/pdf'
                            });
                            const fileURL = URL.createObjectURL(file);
                            window.open(fileURL, '_blank');
                        }
                    });
                    formPengumpulanUpload.classList.add('has-file');
                    uploadWrapper.querySelector('#upload-actions').innerHTML = btnUpload + btnOpenInNewTab;
                    uploadWrapper.querySelector('#upload-terlampir p').textContent = context.target.files[0].name;
                    refreshUploadSection();
                });

                if (typeof dataItem.path_dokumen !== 'undefined') {
                    uploadWrapper.querySelector('#upload-terlampir p').textContent = getFileName(dataItem.path_dokumen);
                    formPengumpulanUpload.classList.add('has-file');
                    uploadWrapper.querySelector('#upload-actions').innerHTML = btnUpload + btnDownload + btnOpenInNewTab;
                    if (dataItem.status === '<?= StatusDokumen::Diverifikasi->value ?>') {
                        uploadWrapper.querySelector('#upload-actions button:nth-child(1)').classList.add('d-none');
                    }


                    formPengumpulanUpload.addEventListener('click', function(e) {
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
                            let link = document.createElement('a');
                            link.href = pdfDatabasePrefix + dataItem.path_dokumen;
                            link.setAttribute('target', '_blank');
                            link.style.display = 'none';
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        }
                        if (e.target.id === 'upload-terlampir-wrapper' ||
                            e.target.parentNode.id === 'upload-terlampir' ||
                            e.target.id === 'upload-terlampir') {
                            e.preventDefault();
                            let link = document.createElement('a');
                            link.href = pdfDatabasePrefix + dataItem.path_dokumen;
                            link.setAttribute('target', '_blank');
                            link.style.display = 'none';
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        }
                    });
                }
                formItem.appendChild(uploadWrapper);

                let komentarToggle = document.createElement('div');
                komentarToggle.classList.add('toggle-komentar', 'd-none');
                if (typeof dataItem.nama_admin !== 'undefined' &&
                    dataItem.status !== '<?= StatusDokumen::Diverifikasi->value ?>' &&
                    dataItem.nama_admin !== null) {
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
                        <h4>${dataItem.nama_admin}</h4>
                          <?= SvgIcons::getIconWithColor(Icons::Minidot, 'var(--bs-emphasis-color)') ?>
                        <p id="tgl-komentar">${formattedDateKomentar}</p>
                    </div>
                    <div id="komentar-text-wrapper">
                        <p>${dataItem.isi_komentar}</p>
                    </div> `;
                formItem.appendChild(komentarWrapper);

                formPengumpulan.appendChild(formItem);
            }

            let totalTanggungan = document.getElementById('total-tanggungan');
            totalTanggungan.querySelector('#total-dokumen').textContent = countVerifikasi + countPending + countTertanggung;
            totalTanggungan.querySelector('#total-verifikasi').textContent = countVerifikasi;
            totalTanggungan.querySelector('#total-pending').textContent = countPending;
            totalTanggungan.querySelector('#total-tertanggung').textContent = countTertanggung;
            totalTanggungan.querySelector('#last-update').textContent = formatDate(lastestDate);
        }

        function updatePageContent(data) {
            let listDocument = document.getElementById('list-dokumen');
            let formPengumpulanList = document.getElementById('form-pengumpulan');
            let countVerifikasi = 0;
            let countPending = 0;
            let countTertanggung = 0;
            let lastestDate = '';

            for (let i = 0; i < data.length; i++) {
                let dataItem = data[i];
                let dokumenItem = listDocument.children[i];
                let dokumenItemBadge = dokumenItem.querySelector('.status-badge-text');

                if (dokumenItemBadge.classList.contains('success') && dataItem.status === '<?= StatusDokumen::Ditolak->value ?>') {
                    generatePageContent(data);
                    return;
                }

                dokumenItem.children[1].textContent = dataItem.dokumen;
                let formPengumpulanItemHeader = formPengumpulanList.children[i].children[0];
                formPengumpulanItemHeader.children[0].textContent = dataItem.dokumen;
                if (typeof dataItem.tanggal_upload !== 'undefined') {
                    const date = new Date(dataItem.tanggal_upload);
                    if (lastestDate === '') {
                        lastestDate = date;
                    }
                    if (date.getTime() > lastestDate.getTime()) {
                        lastestDate = date;
                    }
                    formPengumpulanItemHeader.children[1].children[0].textContent =
                        formatDate(date);
                }
                let formPengumpulanItemHBadge = formPengumpulanItemHeader.children[1].children[1];
                let btnUpload = document.querySelectorAll('#form-pengumpulan-upload-wrapper #upload-actions button:nth-child(1)')[i];

                dokumenItemBadge.classList.remove('success', 'warning', 'danger');
                if (dataItem.status === '<?= StatusDokumen::Diverifikasi->value ?>') {                
                    dokumenItemBadge.classList.add('success');
                    btnUpload.classList.add('d-none');
                    dokumenItemBadge.innerHTML = statusBadgeIconVerified;
                    formPengumpulanItemHBadge.outerHTML = statusBadgeVerified;
                    countVerifikasi += 1;
                } else if (dataItem.status === '<?= StatusDokumen::Menunggu->value ?>') {
                    dokumenItemBadge.classList.add('warning');
                    dokumenItemBadge.innerHTML = statusBadgeIconPending;
                    formPengumpulanItemHBadge.outerHTML = statusBadgePending;
                    countPending += 1;
                } else if (dataItem.status === '<?= StatusDokumen::Ditolak->value ?>') {
                    dokumenItemBadge.classList.add('danger');
                    dokumenItemBadge.innerHTML = statusBadgeIconTertanggung;
                    formPengumpulanItemHBadge.outerHTML = statusBadgeTertanggung;
                    btnUpload.classList.remove('d-none');
                    countTertanggung += 1;
                } else {
                    dokumenItemBadge.classList.add('danger');
                    dokumenItemBadge.innerHTML = statusBadgeIconPending;
                    formPengumpulanItemHBadge.outerHTML = statusBadgeKosong;
                    btnUpload.classList.remove('d-none');
                    countTertanggung += 1;
                }

                let komentarToggle = formPengumpulanList.children[i].children[formPengumpulanList.children[i].children.length - 2];
                komentarToggle.classList.add('toggle-komentar', 'd-none');
                if (typeof dataItem.nama_admin !== 'undefined' &&
                    dataItem.status !== '<?= StatusDokumen::Diverifikasi->value ?>' &&
                    dataItem.nama_admin !== null) {
                    komentarToggle.classList.remove('d-none');
                    komentarToggle.innerHTML = `
                    <?= SvgIcons::getIcon(Icons::Message) ?>
                    <h3>Komentar</h3>`;

                    let komentarWrapper = formPengumpulanList.children[i].children[formPengumpulanList.children[i].children.length - 1];
                    let komentarPeople = komentarWrapper.children[0];
                    komentarPeople.children[1].innerHTML = `${dataItem.nama_admin}`;
                    komentarPeople.children[3].textContent = formatDate(new Date(dataItem.tanggal_komentar));
                    komentarWrapper.children[1].children[0].textContent = dataItem.isi_komentar;
                } else {
                    komentarToggle.classList.remove('komentar-expand');
                }
            }
            let totalTanggungan = document.getElementById('total-tanggungan');
            totalTanggungan.querySelector('#total-dokumen').textContent = countVerifikasi + countPending + countTertanggung;
            totalTanggungan.querySelector('#total-verifikasi').textContent = countVerifikasi;
            totalTanggungan.querySelector('#total-pending').textContent = countPending;
            totalTanggungan.querySelector('#total-tertanggung').textContent = countTertanggung;
            totalTanggungan.querySelector('#last-update').textContent = formatDate(lastestDate);
        }

        function getDataPengumpulan(useUpdate = true) {
            $.ajax({
                type: "POST",
                url: "getDataPengumpulan",
                data: {
                    tingkat_dokumen: "<?= $tingkat ?>"
                },
                success: function(response) {
                    //console.log(response);
                    let data = JSON.parse(response);
                    console.log(data);
                    if (useUpdate) {
                        updatePageContent(data);
                    } else {
                        generatePageContent(data);
                    }
                },
                error: function(response) {
                    console.log(response);
                }
            });
        }
        getDataPengumpulan(false);
        funToCallEachInterval.push(getDataPengumpulan);

        function upload() {
            let pageContentBottom = document.getElementById('page-content-bottom');
            pageContentBottom.children[0].innerHTML = 'UPLOADING... (Jangan Klik Apapun)';
            pageContentBottom.children[1].setAttribute('disabled', 'disabled');

            let formData = new FormData();
            document.querySelectorAll('#form-pengumpulan-upload-wrapper input[type="file"]').forEach(input => {
                if (input.files.length > 0) {
                    formData.append(input.name, input.files[0]);
                }
            });

            formData.append('tingkat_dokumen', "<?= $tingkat ?>");

            $.ajax({
                type: "POST",
                url: "uploadPengumpulan",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    // console.log('response');
                    // console.log(response);
                    getDataPengumpulan(false);
                    pageContentBottom.children[0].innerHTML = 'Upload Berhasil';
                    pageContentBottom.children[1].removeAttribute('disabled');
                },
                error: function(response) {
                    console.log(response);
                    pageContentBottom.children[0].innerHTML = 'Upload Gagal';
                    pageContentBottom.children[1].removeAttribute('disabled');
                }
            });
        }
    </script>
</div>