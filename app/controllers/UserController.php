<?php

require_once '../app/services/UploadFile.php';
require_once '../app/models/Mahasiswa.php';

class UserController extends Controller
{
    private $mahasiswa;

    function __construct()
    {
        $this->mahasiswa = new Mahasiswa(
            Database::getInstance(getDatabaseConfig(), [$this, 'error']),
            Session::get('username'),
        );
    }

    public function index($screen = "dashboard")
    {
        new UploadFile();
        $this->view('user/index', ["screen" => $screen, "user" => $this->mahasiswa]);
    }

    public function screen()
    {
        if (isset($_GET['screen'])) {
            $screen = strtolower($_GET['screen']);
            $this->index($screen);
        }
    }

    public function uploadTest()
    {
        $upload = new UploadFile();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $upload->upload();
        }
    }
}
