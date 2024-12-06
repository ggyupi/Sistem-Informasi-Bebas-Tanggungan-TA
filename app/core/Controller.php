<?php

abstract class Controller
{
    public function view($view, $data = [])
    {
        if (file_exists("../app/views/" . $view . ".php")) {
            require_once "../app/views/" . $view . ".php";
        } else {
            die("View does not exist.");
        }
    }

    public function logout($location = '')
    {
        Session::destroy();
        header("Location: " . BASE_URL . $location);
        exit();
    }

    public function setUiState()
    {
        foreach ($_POST['set_ui_state'] as $key => $value) {
            Session::set($key, $value);
        }
    }

    public function error($code = 404, $message = "Page not found")
    {
        $this->view('error/index', ["code" => $code, "message" => $message]);
        exit();
    }
}
