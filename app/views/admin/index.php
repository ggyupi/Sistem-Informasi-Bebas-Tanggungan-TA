<?php
include_once VIEWS . "component/status-card.php";
include_once VIEWS . "component/dialog-yes-no.php";
?>

<!DOCTYPE html>
<html data-bs-theme="<?= Session::get('theme_mode') === 'dark' ? 'dark' : 'light' ?>" id="html">

<head>
    <?php include_once VIEWS . "template/head.php"; ?>
    <title><?= ucwords($data['title'] ?? 'Dashboard') ?></title>
</head>

<body>
    <input type="checkbox" id="toggle-side-bar" <?= Session::get('toggle_sidebar') === 'true' ? 'checked' : '' ?> />
    <div class="dropend offcanvas-md offcanvas-start <?= Session::get('toggle_sidebar') === 'true' ? '' : 'show' ?>"
        id="side-bar">
        <?php include_once VIEWS . "template/sidebar/sidebar-top.php"; ?>

        <div id="side-bar-menu">
            <?php
            include_once VIEWS . "admin/sidebar-nav1" . ($data['user']->adminApa === TipeAdmin::Super ? '-super' : '') . ".php";
            ?>
            <span id="side-bar-menu-seperator"></span>
            <?php include_once VIEWS . "admin/sidebar-nav2.php"; ?>
        </div>
        <?php include_once VIEWS . "template/sidebar/sidebar-bottom.php"; ?>
    </div>

    <div id="right-section">
        <div id="top-bar">
            <?php include_once VIEWS . "template/top-bar.php" ?>
        </div>
        <div id="page-content">
            <?php include_once VIEWS . "admin/screens/" . $data['screen'] . ".php"; ?>
        </div>
    </div>
    <form method="post" action="logout">
        <?php
        dialogYesNo(
            'dialog-logout',
            'Logout',
            'Logout dan Hapus Sesi Saat ini',
            SvgIcons::getIcon(Icons::Logout) . 'Logout',
            SvgIcons::getIcon(Icons::Close) . 'Ga Jadi',
            true
        );
        ?>
        <form>
</body>

<script>
    function getDataNotificationPusat() {
        const adminRole = "<?= ucwords($data['user']->adminApa->value) ?>";

        let ajaxUrl;
        if (adminRole === "Super") {
            ajaxUrl = "getDataDokumenSuper";
        } else if (adminRole === "Pusat") {
            ajaxUrl = "getDataDokumenPusat";
        } else if (adminRole === "Jurusan") {
            ajaxUrl = "getDataDokumenJurusan";
        } else {
            console.error("Role admin tidak dikenali.");
            ajaxUrl = "";
        }

        if (ajaxUrl) {
            $.ajax({
                type: "POST",
                url: ajaxUrl,
                success: function (response) {
                    // console.log(response);
                    let data = JSON.parse(response);

                    if (typeof generateNotificationItem === 'function') {
                        generateNotificationItem(data);
                    }
                    changeSidebarNav2NotificationIcon(data);
                },
                error: function (response) {
                    console.log(response);
                }
            });
        }
    }

    getDataNotificationPusat();

    funToCallEachInterval.push(getDataNotificationPusat);
</script>


<?php include_once VIEWS . "template/footer.php"; ?>

</html>