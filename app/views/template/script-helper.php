<script>
    const pdfDatabasePrefix = '<?= FILEDATABASE_URL ?>';

    function getFileName(url) {
        let filename = url.substring(url.lastIndexOf('/') + 1);
        return filename === 'undefined' ? '' : filename;
    }

    function formatDate(date) {
        if (!date) return '';
        return date.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
        });
    }

    function funSearch(target,search) {
            document.querySelectorAll(target).forEach(function(row) {
                row.parentNode.style.display = row.textContent.toLowerCase().includes(search) ? '' : 'none';
            });
        }
</script>