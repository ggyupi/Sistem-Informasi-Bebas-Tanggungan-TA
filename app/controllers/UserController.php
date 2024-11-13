<?php

class UserController extends Controller
{
    public function index($page = "dashboard")
    {
        $this->view('user/index', ["page" => $page]);
    }

    public function page()
    {
        if (isset($_GET['page'])) {
            $page = strtolower($_GET['page']);
            $this->index($page);
        }
    }
}
