<?php

class UserController extends Controller
{
    public function index($screen = "dashboard")
    {
        consoleLog("[UserController, index]", "screen: " . $screen);
        $this->view('user/index', ["screen" => $screen]);
    }

    public function screen()
    {
        if (isset($_GET['screen'])) {
            $screen = strtolower($_GET['screen']);
            $this->index($screen);
        }
    }
}
