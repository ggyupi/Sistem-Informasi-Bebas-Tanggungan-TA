<?php

class LoginController extends Controller
{
    // Default method to load when this controller is accessed
    // Delete later - Raruu
    public function index()
    {
        // Example data to pass to the view
        $data = [
            // 'title' => 'Welcome to My MVC App',
            // 'content' => 'This is the home page content loaded from the HomeController.'
        ];

        // Load the view and pass the data
        $this->view('login/index', $data);
    }
}
