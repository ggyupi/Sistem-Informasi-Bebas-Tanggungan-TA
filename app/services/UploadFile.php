<?php

class UploadFile
{
    function __construct()
    {
        if (!is_dir(FILEDATABASE)) {
            mkdir(FILEDATABASE);
        }
    }

    public function writeFile($file, $folderName = 'folderName', $id = 'xxx', $fileName = 'fileName')
    {
        $fileTmpPath = $file['tmp_name'];
        $fileType = '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $id = trim($id);

        $destinationDir = FILEDATABASE . $folderName . '/' . $id . '/';
        if (!is_dir($destinationDir)) {
            mkdir($destinationDir, 0777, true);
        }

        $newFilePath = $destinationDir . $fileName . $fileType;
        move_uploaded_file($fileTmpPath, $newFilePath);
        return str_replace(FILEDATABASE, '', $newFilePath);
    }
}
