<?php
include VIEWS . "component/status-card.php";
include VIEWS . "component/dialog-yes-no.php"; 
?>

<!DOCTYPE html>
<html data-bs-theme="<?= Session::get('theme_mode') === 'dark' ? 'dark' : 'light' ?>" id="html">

<head>
    <?php include VIEWS . "template/head.php"; ?>
    <title><?= ucwords($data['screen'] ?? 'Dashboard') ?></title>
</head>

<body>
    <input type="checkbox" id="toggle-side-bar" <?= Session::get('toggle_sidebar') === 'true' ? 'checked' : '' ?> />
    <div class="dropend offcanvas-md offcanvas-start <?= Session::get('toggle_sidebar') === 'true' ? '' : 'show' ?>" id="side-bar">
        <?php include VIEWS . "template/sidebar/sidebar-top.php"; ?>

        <div id="side-bar-menu">
            <?php
            include VIEWS . "admin/sidebar-nav1" . ($data['user']->adminApa === 'super' ? '-super' : '') . ".php";
            ?>
            <span id="side-bar-menu-seperator"></span>
            <?php include VIEWS . "template/sidebar/sidebar-nav2.php"; ?>
        </div>
        <?php include VIEWS . "template/sidebar/sidebar-bottom.php"; ?>
    </div>

    <div id="right-section">
        <div id="top-bar">
            <?php include VIEWS . "template/top-bar.php" ?>
        </div>
        <div id="page-content">
            <?php include VIEWS . "admin/screens/" . $data['screen'] . ".php"; ?>
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

<?php include VIEWS . "template/footer.php"; ?>

</html>