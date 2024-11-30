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
</script>