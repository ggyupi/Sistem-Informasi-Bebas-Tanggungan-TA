<?php

class App
{
    protected static $controller = 'LoginController';
    protected static $method = 'index';
    protected static $params = [];

    public static function route($url = BASE_URL)
    {
        $url = self::parseUrl($url);
        if (isset($url[0]) && file_exists("../app/controllers/" . ucwords($url[0]) . "Controller.php")) {
            self::$controller = ucwords($url[0]) . "Controller";
        }

        require_once "../app/controllers/" . self::$controller . ".php";
        self::$controller = new self::$controller;

        $endUrl = explode("?", end($url));
        if (method_exists(self::$controller, $endUrl[0])) {
            self::$method = preg_replace('/\.php$/', '', $endUrl[0]);
        }

        call_user_func_array([self::$controller, self::$method], []);
    }

    public static function parseUrl($url)
    {
        if (isset($url)) {
            $arr =  array_values(array_filter(explode('/', filter_var(trim($url, '/'), FILTER_SANITIZE_URL))));
            // array_splice($arr, 0, 4);
            array_splice($arr, 0, array_search('public', $arr)+1);
            return $arr;
        }
        return [];
    }
}
