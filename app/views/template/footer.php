<script>
    document.getElementById('toggle-side-bar-btn').addEventListener('click', function() {
        var toggleSidebar = document.getElementById('toggle-side-bar');
        toggleSidebar.checked = !toggleSidebar.checked;       
        $.ajax({
            type: "POST",
            url: "setUiState",
            data: {
                set_ui_state: {
                    'toggle_sidebar': toggleSidebar.checked
                }
            },
            success: function() {
                console.log("Update UI State Success");
            },
            error: function(response) {
                console.log("[Update UI State]: " + response);
            }
        });
    });
</script>