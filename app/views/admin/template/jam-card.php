<div style="flex: 1;">
    <?= jamCard(
        'jam-card',
        '<span id="clock">Loading...</span>',
        '<span id="date">Loading...</span>'
    ) ?>
    <script>
        function addZero(i) {
            return i < 10 ? "0" + i : i;
        }

        function startTime() {
            const today = new Date();
            const d = today.getDate();
            const mo = today.getMonth() + 1;
            const y = today.getFullYear();
            const h = today.getHours();
            const m = addZero(today.getMinutes());
            const s = addZero(today.getSeconds());
            document.getElementById("clock").innerHTML = `${h}:${m}:${s}`;
            document.getElementById("date").innerHTML = `${d}/${mo}/${y}`;
            setTimeout(startTime, 1000);
        }
        startTime();
    </script>

</div>