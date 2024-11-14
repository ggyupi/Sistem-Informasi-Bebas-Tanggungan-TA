<?php

class AdminController extends Controller
{
    public function index($page = "dashboard")
    {
        $this->view('admin/index', ["page" => $page]);
    }

}