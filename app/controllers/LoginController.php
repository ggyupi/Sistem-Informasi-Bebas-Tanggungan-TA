<?php

class LoginController extends Controller
{
    public function index()
    {        
        $this->view('landing/index', []);
    }

    public function login()
    {
        $this->view('login/index', []);
    }

    public function dologin()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        consoleLog("[LoginController, dologin]", $username . " " . $password);
    }
}
