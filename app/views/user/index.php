<?php

echo "Username" . Session::get('username'). "<br>";
echo "level" .  Session::get('level') . "<br>";
echo "password" .  Session::get('password'). "<br>";

echo '<form method="post" action="logout">';
echo '<button type="submit" class="btn btn-danger">Logout</button>';
echo '</form>';