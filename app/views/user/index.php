<!DOCTYPE html>
<html data-bs-theme="light">

<head>
    <?php include VIEWS . "template/head.php"; ?>
    <title><?= ucwords(isset($data['page']) ? $data['page'] : 'Dashboard') ?></title>
</head>

<body>
    <input type="checkbox" id="toggle-side-bar" <?= Session::get('toggle_sidebar') === 'true' ? 'checked' : '' ?> />
    <div id="side-bar">
        <button id="toggle-side-bar-btn">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.1658 4.23431C10.4782 4.54673 10.4782 5.05327 10.1658 5.36569L7.53147 8L10.1658 10.6343C10.4782 10.9467 10.4782 11.4533 10.1658 11.7657C9.85336 12.0781 9.34683 12.0781 9.03441 11.7657L5.83441 8.56569C5.52199 8.25327 5.52199 7.74673 5.83441 7.43431L9.03441 4.23431C9.34683 3.9219 9.85336 3.9219 10.1658 4.23431Z" fill="#081021" />
            </svg>
        </button>
        <div id="side-bar-top">
            <div id="side-bar-title">
                <svg width="30" height="28" viewBox="0 0 30 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 7.75C15 6.42392 14.4732 5.15215 13.5355 4.21447C12.5979 3.27678 11.3261 2.75 10 2.75H2.5V21.5H11.25C12.2446 21.5 13.1984 21.8951 13.9017 22.5983C14.6049 23.3016 15 24.2554 15 25.25M15 7.75V25.25M15 7.75C15 6.42392 15.5268 5.15215 16.4645 4.21447C17.4021 3.27678 18.6739 2.75 20 2.75H27.5V21.5H18.75C17.7554 21.5 16.8016 21.8951 16.0983 22.5983C15.3951 23.3016 15 24.2554 15 25.25" stroke="#4F46E5" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p>SIBETA</p>
            </div>
        </div>

        <div id="side-bar-menu">
            <?php include VIEWS . "user/sidebar-nav1.php"; ?>

            <span id="side-bar-menu-seperator"></span>
            <?php include VIEWS . "template/sidebar/sidebar-nav2.php"; ?>
        </div>
        <?php include VIEWS . "template/sidebar/sidebar-bottom.php"; ?>
    </div>

    <div id="the-content">
        <div id="top-bar">
            <h1><?= ucwords(isset($data['page']) ? $data['page'] : 'Dashboard') ?></h1>
            <?php
            echo '<form method="post" action="logout">';
            echo '<button type="submit" class="btn btn-danger">Logout</button>';
            echo '</form>';
            ?>
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