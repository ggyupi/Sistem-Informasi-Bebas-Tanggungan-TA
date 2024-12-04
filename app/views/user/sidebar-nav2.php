<form class="side-bar-nav">
    <button class="side-bar-btn" type="submit" name="screen" value="notifications">
        <?= SvgIcons::getIcon(Icons::Notification) ?>
        <span></span>
        <p>Notifications</p>
    </button>
    <button class="side-bar-btn" type="submit" name="screen" value="support">
        <?= SvgIcons::getIcon(Icons::About) ?>
        <span></span>
        <p>Support</p>
    </button>
    <div class="side-bar-btn" name="screen" id="toggle-dark-mode" value="dark_mode">
        <?= SvgIcons::getIcon(Icons::Bulb) ?>
        <span></span>
        <p id="dark-mode-text"><?= Session::get('theme_mode') === 'dark' ? 'Dark' : 'Light' ?> Mode</p>
    </div>
</form>