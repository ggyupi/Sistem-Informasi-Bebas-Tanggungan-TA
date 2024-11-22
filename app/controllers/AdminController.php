<?php

require_once '../app/models/Admin.php';

class AdminController extends Controller
{
    private $admin;

    public function __construct()
    {
        $userLevel = Session::get('level');
        $userLevel = substr($userLevel, strpos($userLevel, '-') + 1);
        $this->admin = new Admin(
            Database::getInstance(getDatabaseConfig(), [$this, 'error']),
            Session::get('username'),
            $userLevel,
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
