<?php

function consoleLog($from, $data)
{
    echo "<script>console.log('" . $from . ": " . $data . "' );</script>";
}

define('CSS', 'http://localhost/pbl/assets/css/');
define('JS', 'http://localhost/pbl/assets/js/');
define('IMGS', 'http://localhost/pbl/assets/imgs/');
define('FONTS', 'http://localhost/pbl/assets/fonts/');