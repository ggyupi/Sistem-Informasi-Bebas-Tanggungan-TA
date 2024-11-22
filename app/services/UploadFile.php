<?php

class UploadFile
{
    function __construct()
    {
        if (!is_dir(FILEDATABASE)) {
            mkdir(FILEDATABASE);
        }
    }

    public function upload($folderName = 'folderName', $id = 'xxx', $fileName = 'fileName')
    {
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['file']['tmp_name'];
            $fileType = '.' . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

            $destinationDir = FILEDATABASE . $folderName . '/' . $id . '/';
            if (!is_dir($destinationDir)) {
                mkdir($destinationDir, 0777, true);
            }

            $newFilePath = $destinationDir . $fileName . $fileType;

            move_uploaded_file($fileTmpPath, $newFilePath);
        } else {
            consoleLog("File upload failed. Error code: ",  $_FILES['file']['error']);
        }
    }
}
