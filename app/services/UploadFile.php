<?php

class UploadFile
{
    private $useLocalHost;

    function __construct()
    {
        $this->useLocalHost = getDatabaseConfig()['server_name'] == gethostname();
        if (!is_dir(FILEDATABASE)) {
            mkdir(FILEDATABASE);
        }
    }

    public function writeFile($file, $folderName = 'folderName', $id = 'xxx', $fileName = 'fileName')
    {
        $fileTmpPath = $file['tmp_name'];
        $fileType = '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $id = trim($id);
        if ($this->useLocalHost) {
            $destinationDir = FILEDATABASE . $folderName . '/' . $id . '/';
            if (!is_dir($destinationDir)) {
                mkdir($destinationDir, 0777, true);
            }

            $newFilePath = $destinationDir . $fileName . $fileType;
            move_uploaded_file($fileTmpPath, $newFilePath);
            return str_replace(FILEDATABASE, '', $newFilePath);
        } else {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, FILEDATABASE_POST);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, [
                'file' => new CURLFile($fileTmpPath, mime_content_type($fileTmpPath), basename($file['name'])),
                'folder_name' => $folderName,
                'id' => $id,
                'file_name' => $fileName
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            curl_close($ch);
            return $response;
        }
    }
}
