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
            if (Session::get('level') == 'Admin') {
                require_once '../app/controllers/AdminController.php';
                header("Location: admin/index");
            } else {
                require_once '../app/controllers/UserController.php';
                header("Location: user/index");
            }
        } else {
            $username = Session::get('username');
            $password = Session::get('password');
            $level = Session::get('level');
            Session::destroy();
            Session::start();
            $this->view('login/index', ['not_found' => true, 'username' => $username, 'password' => $password, 'level' => $level]);
        }
    }

    public function logout()
    {
        Session::destroy();
        $this->view('landing/index', []);
        exit();
    }
}
