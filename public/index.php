<?php

$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']
    === 'on' ? "https" : "http") .
    "://" . $_SERVER['HTTP_HOST'] .
    $_SERVER['REQUEST_URI'];


require_once '../app/core/Controller.php';
require_once '../app/core/Session.php';
require_once '../app/core/Database.php';
require_once '../app/utils/utils.php';
require_once '../app/utils/SvgIcons.php';
require_once '../app/config/config.php';
require_once '../app/core/App.php';

Session::start();
App::route($url);
