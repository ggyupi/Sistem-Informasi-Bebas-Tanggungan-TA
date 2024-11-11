<?php

class App
{
    protected $controller = 'LoginController';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        Session::start();
        $url = $this->parseUrl();

        if (isset($url[0]) && file_exists("../app/controllers/" . ucwords($url[0]) . "Controller.php")) {
            $this->controller = ucwords($url[0]) . "Controller";
            // unset($url[0]);
        }

        require_once "../app/controllers/" . $this->controller . ".php";
        $this->controller = new $this->controller;


        if (isset($url[1]) && method_exists($this->controller, end($url))) {
            $this->method = preg_replace('/\.php$/', '', end($url));
            // unset(end($url));
        }
        // consoleLog("[App, __construct]", end($url));

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl()
    {
        // consoleLog("[App, parseUrl]", $_GET['url']);
        if (isset($_GET['url'])) {
            $arr =  array_values(array_filter(explode('/', filter_var(trim($_GET['url'], '/'), FILTER_SANITIZE_URL))));
             array_splice($arr, 0, 4);
             return $arr;
        }
        return [];
    }
}
