<?php include_once VIEWS . "component/status-card.php"; ?>

<!DOCTYPE html>
<html data-bs-theme="<?= Session::get('theme_mode') === 'dark' ? 'dark' : 'light' ?>" id="html">

<head>
    <?php include_once VIEWS . "template/head.php"; ?>
    <title><?= ucwords($data['screen'] ?? 'Dashboard') ?></title>
</head>

<body>
    <input type="checkbox" id="toggle-side-bar" <?= Session::get('toggle_sidebar') === 'true' ? 'checked' : '' ?> />
    <div class="dropend offcanvas-md offcanvas-start <?= Session::get('toggle_sidebar') === 'true' ? '' : 'show' ?>" id="side-bar">
        <?php include_once VIEWS . "template/sidebar/sidebar-top.php"; ?>

        <div id="side-bar-menu">
            <?php include_once VIEWS . "user/sidebar-nav1.php"; ?>
            <span id="side-bar-menu-seperator"></span>
            <?php include_once VIEWS . "template/sidebar/sidebar-nav2.php"; ?>
        </div>
        <?php include_once VIEWS . "template/sidebar/sidebar-bottom.php"; ?>
    </div>

    <div id="right-section">
        <div id="top-bar">
            <?php include_once VIEWS . "template/top-bar.php" ?>
        </div>
        <div id="page-content">
            <form action="uploadTest" method="post" enctype="multipart/form-data">
                <label for="file">Select a file:</label>
                <input type="file" name="file" id="file" required>
                <button class="btn btn-primary" type="submit">Upload</button>
            </form>

            <?php
            statusCard(
                'test-card',
                'Test',
                [[
                    'type' => 'good',
                    'icon' => Icons::Close,
                    'title' => '1 Buku',
                    'subtitle' => 'Terpinjam',
                    'href' => ''
                ], [
                    'type' => 'bad',
                    'icon' => Icons::Logout,
                    'title' => '1 Buku',
                    'subtitle' => 'Terpinjam',
                    'href' => ''
                ], [
                    'type' => 'warning',
                    'icon' => Icons::Logout,
                    'title' => '1 Buku',
                    'subtitle' => 'Terpinjam',
                    'href' => ''
                ]]
            );
            echo '<br>';
            echo "Username: " . Session::get('username') . "<br>";
            echo "level: " .  Session::get('level') . "<br>";
            echo "password: " .  Session::get('password') . "<br>";
            ?>
        </div>
    </div>
    <form method="post" action="logout">
        <?php include_once VIEWS . "component/dialog-yes-no.php";
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

<?php include_once VIEWS . "template/footer.php"; ?>

</html>