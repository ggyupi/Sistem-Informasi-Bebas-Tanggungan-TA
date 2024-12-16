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
        document.getElementById('pdf-viewer-wrapper').innerHTML = `
            <object src="${url}?t=${new Date().getTime()}" data="${url}?t=${new Date().getTime()}" id="pdf-viewer" style="width: 100%; height: 70vh;">
                <p>Browser tidak dapat meload File</p>
                <p><a href="${url}" download="${getFileName(url)}">Download Saja min</a></p>
            </object>`;
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
        if (id == 'dialog-decl') {
            modalBody.innerHTML = `
                ${message}<br><br>
                <label for="komentar-tolak" class="form-label">Masukkan alasan penolakan</label>
                <input type="text" class="form-control" value="" name="komentar" id="komentar-tolak" required />
                <div class="invalid-feedback">
                    Tolong isi alasan penolakan
                </div>
                `;
            let inputKomentar = modalBody.querySelector('#komentar-tolak');
            setTimeout(function() {
                inputKomentar.focus();
            }, 500);

        } else {
            modalBody.innerHTML = message;
        }
    }
</script>