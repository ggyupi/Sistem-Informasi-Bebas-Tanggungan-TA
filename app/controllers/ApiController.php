<?php

class ApiController
{
    public function index()
    {
        $url = $_SERVER['REQUEST_URI'];
        $arr =  array_values(array_filter(explode('/', filter_var(trim($url, '/'), FILTER_SANITIZE_URL))));
        array_splice($arr, 0, array_search('api', $arr) + 1);
        if (method_exists($this, $arr[0])) {
            call_user_func_array([$this, $arr[0]], array_splice($arr, 1));
        }
    }

    public function upload_file($args)
    {
        require_once '../app/services/UploadFile.php';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $upload = new UploadFile();
            echo $upload->writeFile(
                $_FILES['file'],
                $_POST['folder_name'],
                $_POST['id'],
                $_POST['file_name'],
            );
        }
    }
}
