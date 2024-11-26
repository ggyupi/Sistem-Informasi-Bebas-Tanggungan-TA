<h1>Selamat Datang, Admin <strong><?= ucwords($data['user']->adminApa) ?></strong></h1>
<br> <br> <br> <br>
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
echo "Username: " . Session::get('username') . "<br>";
echo "level: " .  Session::get('level') . "<br>";
echo "password: " .  Session::get('password') . "<br>";
echo "Username: " . Session::get('username') . "<br>";
echo "level: " .  Session::get('level') . "<br>";
echo "password: " .  Session::get('password') . "<br>";
echo "Username: " . Session::get('username') . "<br>";
echo "level: " .  Session::get('level') . "<br>";
echo "password: " .  Session::get('password') . "<br>";
?>