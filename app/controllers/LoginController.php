<?php

require_once '../app/models/User.php';

class LoginController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = new User(Database::getInstance(getDatabaseConfig()));
    }


    public function index()
    {
        $this->view('landing/index', []);
    }

    public function login()
    {
        $db = Database::getInstance(getDatabaseConfig());

        if ($db->getConnection()) {
            consoleLog("[LoginController, login]", "koneksi berhasil tuan");
        }
        if (Session::exists('username') && Session::exists('password') && Session::exists('level')) {
            $this->dologin();
        } else {
            $this->view('login/index', ['']);
        }
    }

    public function postLogin()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $level = isset($_POST['isAdmin']) ? 'Admin' : 'Mahasiswa';

        Session::set('username', $username);
        Session::set('password', $password);
        Session::set('level', $level);
        $this->dologin();
    }

    public function dologin()
    {
        $user = $this->user->getUserByUsername(Session::get('username'), Session::get('password'), Session::get('level'));     
        if ($user) {
            if (Session::get('level')) {
                $this->view('admin/index', []);
            } else {
                $this->view('user/index', []);
            }
        } else {
            Session::destroy();
            Session::start();
            $this->view('login/index', ['']);
        }
    }

    public function logout()
    {
        Session::destroy();
        $this->view('landing/index', []);
        exit();
    }
}
