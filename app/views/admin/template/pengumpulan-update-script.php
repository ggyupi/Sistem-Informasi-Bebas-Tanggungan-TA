<script>
    function showResultAcc(showResult = false) {
        if (!showResult) {
            $('#result-acc').modal('show');
        } else {
            let result = document.querySelector('#result-acc #result-content');
            result.style.opacity = '1';
            setTimeout(function() {
                $('#result-acc').modal('hide');
                result.style.opacity = '1';
            }, 1000);
        }

    }

    function showResultDecl(showResult = false) {
        if (!showResult) {
            $('#result-decl').modal('show');
        } else {
            let result = document.querySelector('#result-decl #result-content');
            result.style.opacity = '1';
            setTimeout(function() {
                $('#result-decl').modal('hide');
                result.style.opacity = '1';
            }, 1000);
        }
    }

    document.getElementById('dialog-acc').addEventListener('submit', function(e) {
        e.preventDefault();
        showResultAcc();
        $.ajax({
            type: "POST",
            url: "updateDataPengumpulan",
            data: $('#in-open-dokumen').serialize() + '&acc=true',
            success: function(response) {
                console.log(response);
                getDataPengumpulan();
                showResultAcc(true);
            },
            error: function(response) {
                console.log(response);
            }
        });
    });

    document.getElementById('dialog-decl').addEventListener('submit', function(e) {
        e.preventDefault();
        document.querySelector('#btn-decl .btn-outline').click();
        showResultDecl();
        $.ajax({
            type: "POST",
            url: "updateDataPengumpulan",
            data: $('#in-open-dokumen').serialize() + '&acc=false&komentar=' +
                document.getElementById('komentar-tolak').value,
            success: function(response) {
                console.log(response);
                getDataPengumpulan();
                showResultDecl(true);
            },
            error: function(response) {
                console.log(response);
            }
        });
    });
</script>