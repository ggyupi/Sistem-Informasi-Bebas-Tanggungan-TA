<?php


function getDatabaseConfig(): array
{
    return [
        "server_name" => "KAGAMI-NO-MAJO",
        "database" => "BebasTA",
        "username" => "pblbebasta",
        "password" => "weakpasswd",
    ];
}

define('FILEDATABASE', '../file_database/');
define('FILEDATABASE_URL', (getDatabaseConfig()['server_name'] != gethostname()
    ? 'http://192.168.193.77/pbl' : BASE) . '/file_database/');
define ('FILEDATABASE_POST', 'http://192.168.193.77/pbl/public/api/upload_file/post');