<?php

class AdminController extends Controller
{
    public function index($screen = "dashboard")
    {
        $this->view('admin/index', ["screen" => $screen]);
    }

    public function screen()
    {
        if (isset($_GET['screen'])) {
            $screen = strtolower($_GET['screen']);
            $this->index($screen);
        }
    }

}