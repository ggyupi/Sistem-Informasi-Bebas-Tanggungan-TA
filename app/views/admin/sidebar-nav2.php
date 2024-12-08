<form class="side-bar-nav" action="screen" method="get">
    <button class="side-bar-btn" type="submit" name="screen" value="notifications">
        <div id="nav2-notification-icon">
            <?= SvgIcons::getIcon(Icons::Notification) ?>
        </div>
        <span></span>
        <p>Notifications</p>
    </button>
    <div class="side-bar-btn" id="toggle-dark-mode">
        <?= SvgIcons::getIcon(Icons::Bulb) ?>
        <span></span>
        <p id="dark-mode-text"><?= Session::get('theme_mode') === 'dark' ? 'Dark' : 'Light' ?> Mode</p>
    </div>
</form>