<script>
    function setUiState(uiStateMap) {
        $.ajax({
            type: "POST",
            url: "setUiState",
            data: {
                set_ui_state: uiStateMap
            },
            success: function() {
                console.log("Update UI State Success");
            },
            error: function(response) {
                console.log("[Update UI State]: " + response);
            }
        });
    }

    const toggleSideBarBtns = document.getElementsByClassName('toggle-side-bar-btn');
    for (let i = 0; i < toggleSideBarBtns.length; i++) {
        toggleSideBarBtns[i].addEventListener('click', function() {
            const toggleSidebar = document.getElementById('toggle-side-bar');
            const sideBar = document.getElementById('side-bar');
            toggleSidebar.checked = !toggleSidebar.checked;
            if (toggleSidebar.checked) {
                sideBar.classList.remove('show');
            } else {
                sideBar.classList.add('show');
            }
            setUiState({
                'toggle_sidebar': toggleSidebar.checked
            });
        });
    }

    document.getElementById('toggle-dark-mode').addEventListener('click', function() {
        const html = document.getElementById('html');
        html.setAttribute('data-bs-theme', html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark');
        document.getElementById("dark-mode-text").innerHTML = (html.getAttribute('data-bs-theme') === 'dark' ? 'Dark' : 'Light') + " Mode";
        setUiState({
            'theme_mode': html.getAttribute('data-bs-theme')
        });
    });

    const sidebarNav = document.getElementsByClassName('side-bar-nav');
    for (let i = 0; i < sidebarNav.length; i++) {
        for (let j = 0; j < sidebarNav[i].children.length; j++) {
            const button = sidebarNav[i].children[j];
            const buttonTitle = button.children[2];
            if (buttonTitle.innerHTML == '<?= ucwords(isset($data['screen']) ? $data['screen'] : 'Dashboard') ?>') {
                button.classList.add('side-bar-btn-selected');
                break;
            }
        }
    }
</script>