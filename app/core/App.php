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

        // TODO : add params ?
        // self::$params = $url ? array_values($endUrl) : [];
        self::$params =  [];

        call_user_func_array([self::$controller, self::$method], self::$params);
    }

    public static function parseUrl($url)
    {
        // consoleLog("[App, parseUrl]", $_GET['url']);
        if (isset($url)) {
            $arr =  array_values(array_filter(explode('/', filter_var(trim($url, '/'), FILTER_SANITIZE_URL))));
            array_splice($arr, 0, 4);
            return $arr;
        }
        return [];
    }
}
