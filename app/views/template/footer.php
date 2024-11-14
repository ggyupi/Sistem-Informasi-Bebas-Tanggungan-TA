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

    const sidebarNav = document.getElementsByClassName('side-bar-nav');
    for (let i = 0; i < sidebarNav.length; i++) {
        for (let j = 0; j < sidebarNav[i].children.length; j++) {
            const button = sidebarNav[i].children[j];
            const buttonTitle = button.children[2];
            console.log(buttonTitle.innerHTML);
            if (buttonTitle.innerHTML == '<?= ucwords(isset($data['page']) ? $data['page'] : 'Dashboard') ?>') {
                button.classList.add('side-bar-btn-selected');
                break;
            }
        }
    }
</script>