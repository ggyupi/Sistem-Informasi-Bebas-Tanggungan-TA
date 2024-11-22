<div id="side-bar-bottom-wrapper">
    <div id="side-bar-bottom-menu-not-dropend">
        <?php include VIEWS . "template/sidebar/sidebar-bottom-dropmenu.php"; ?>
    </div>

    <div data-bs-toggle="dropdown" data-bs-display="static" id="side-bar-bottom">

        <div id="side-bar-user-info">
            <div id="side-bar-user-picture">
                <img class="member-picture" src="<?= IMGS; ?>anggota/Raruu.webp" />
            </div>
            <div id="side-bar-user-text">
                <p class="text-secondary">Welcome back 👋</p>
                <p><?= $data['user']->getPeopleName() ?></p>
            </div>
        </div>
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.29289 14.7071C6.90237 14.3166 6.90237 13.6834 7.29289 13.2929L10.5858 10L7.29289 6.70711C6.90237 6.31658 6.90237 5.68342 7.29289 5.29289C7.68342 4.90237 8.31658 4.90237 8.70711 5.29289L12.7071 9.29289C13.0976 9.68342 13.0976 10.3166 12.7071 10.7071L8.70711 14.7071C8.31658 15.0976 7.68342 15.0976 7.29289 14.7071Z" />
        </svg>

        <ul class="dropdown-menu">
            <?php include VIEWS . "template/sidebar/sidebar-bottom-dropmenu.php"; ?>
        </ul>
    </div>
    <script>
        function whichDropDown() {
            const sideBarBottomMenuNotDropend = document.getElementById('side-bar-bottom-menu-not-dropend');
            const sideBarBottomMenuDropend = document.getElementsByClassName('dropdown-menu')[0];
            if (sideBarBottomMenuDropend.classList.contains('show') && window.innerWidth < 768) {
                sideBarBottomMenuNotDropend.style.display = 'flex';
            } else {
                sideBarBottomMenuNotDropend.style.display = '';
            }
        }

        document.getElementById('side-bar-bottom').addEventListener('click', whichDropDown);
        window.addEventListener("resize", whichDropDown);
    </script>
</div>