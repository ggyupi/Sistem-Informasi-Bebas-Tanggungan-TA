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
</script>