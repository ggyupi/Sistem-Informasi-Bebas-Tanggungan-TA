<form class="side-bar-nav" action="screen" method="get">
    <button class="side-bar-btn" type="submit" name="screen" value="dashboard" checked>
        <?= SvgIcons::getIcon(Icons::Dashboard) ?>
        <span></span>
        <p>Dashboard</p>
    </button>
    <button class="side-bar-btn" type="submit" name="screen" value="pengumpulan">
        <?= SvgIcons::getIcon(Icons::DocumentStack) ?>
        <span></span>
        <p>Pengumpulan</p>
    </button>
    <button class="side-bar-btn" type="submit" name="screen" value="pengumpulan">
        <?= SvgIcons::getIcon(Icons::Admin) ?>
        <span></span>
        <p>Admin</p>
    </button>
    <button class="side-bar-btn" type="submit" name="screen" value="pengumpulan">
        <?= SvgIcons::getIcon(Icons::Mahasiswa) ?>
        <span></span>
        <p>Mahasiswa</p>
    </button>
</form>