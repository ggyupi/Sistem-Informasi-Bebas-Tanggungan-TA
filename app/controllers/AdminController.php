<?php

require_once '../app/models/Admin.php';

class AdminController extends Controller
{
    private $admin;

    public function __construct()
    {
        $this->admin = new Admin(
            Database::getInstance(getDatabaseConfig(), [$this, 'error']),
            Session::get('username'),
            Session::get('level'),
        );
    }
    public function index($screen = "dashboard")
    {
        $this->view('admin/index', [
            "screen" => $screen,
            "user" => $this->admin
        ]);
    }

    public function screen()
    {
        if (isset($_GET['screen'])) {
            $screen = strtolower($_GET['screen']);
            $this->index($screen);
        }
    }
}
