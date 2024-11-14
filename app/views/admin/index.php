<!DOCTYPE html>
<html data-bs-theme="<?= Session::get('theme_mode') === 'dark' ? 'dark' : 'light' ?>" id="html">

<head>
    <?php include VIEWS . "template/head.php"; ?>
    <title><?= ucwords(isset($data['page']) ? $data['page'] : 'Dashboard') ?></title>
</head>

<body>
    <input type="checkbox" id="toggle-side-bar" <?= Session::get('toggle_sidebar') === 'true' ? 'checked' : '' ?> />
    <div id="side-bar">
        <?php include VIEWS . "template/sidebar/sidebar-top.php"; ?>

        <div id="side-bar-menu">
            <?php include VIEWS . "admin/sidebar-nav1.php"; ?>

            <span id="side-bar-menu-seperator"></span>
            <?php include VIEWS . "template/sidebar/sidebar-nav2.php"; ?>
        </div>
        <?php include VIEWS . "template/sidebar/sidebar-bottom.php"; ?>
    </div>

    <div id="the-content">
        <div id="top-bar">
            <?php include VIEWS . "template/top-bar.php" ?>
        </div>

        <div id="page-content">
            <?php
            echo "Username: " . Session::get('username') . "<br>";
            echo "level: " .  Session::get('level') . "<br>";
            echo "password: " .  Session::get('password') . "<br>";
            ?>
        </div>
    </div>

</body>

<?php include VIEWS . "template/footer.php"; ?>

</html>