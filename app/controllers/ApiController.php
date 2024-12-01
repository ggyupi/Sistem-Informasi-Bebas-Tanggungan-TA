<?php

class ApiController
{
    public function index()
    {
        $url = $_SERVER['REQUEST_URI'];
        $arr =  array_values(array_filter(explode('/', filter_var(trim($url, '/'), FILTER_SANITIZE_URL))));
        array_splice($arr, 0, array_search('api', $arr) + 1);
        echo $arr[0];
        if (method_exists($this, $arr[0])) {
            call_user_func_array([$this, $arr[0]], array_splice($arr, 1));
        }
    }

    public function upload_file($args)
    {
        require_once '../app/services/UploadFile.php';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $upload = new UploadFile();
            return $upload->writeFile(
                $_FILES['file'],
                $_POST['folderName'],
                $_POST['id'],
                $_FILES['file']['name']
            );
        }
    }
}
