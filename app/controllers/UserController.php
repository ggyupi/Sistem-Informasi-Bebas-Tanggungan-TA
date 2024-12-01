<?php

require_once '../app/services/UploadFile.php';
require_once '../app/models/Mahasiswa.php';
require_once '../app/models/Dokumen.php';

class UserController extends Controller
{
    private $mahasiswa;
    private $dokumen;

    function __construct()
    {
        $db = Database::getInstance(getDatabaseConfig(), [$this, 'error']);
        $this->dokumen = new Dokumen($db);
        $this->mahasiswa = new Mahasiswa(
            $db,
            Session::get('username'),
        );
    }

    public function index($screen = "dashboard")
    {
        $title = $screen;
        if (strpos($title, '_') !== false) {
            // $title = array_pop(explode('_', $title));
            $title = str_replace('_', ' ', $title);
            $title = ucwords($title);
        }

        $this->view('user/index', [
            "screen" => $screen,
            "user" => $this->mahasiswa,
            "title" => $title
        ]);
    }

    public function screen()
    {
        if (isset($_GET['screen'])) {
            $screen = strtolower($_GET['screen']);
            $this->index($screen);
        }
    }

    public function getDataPengumpulan()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tingkatDokumen = TingkatDokumen::from($_POST['tingkat_dokumen']);
            $dokumenList = $this->dokumen->getDokumenList($tingkatDokumen);
            $uploadList = $this->dokumen->getDokumenListUploadByNIM($tingkatDokumen, $this->mahasiswa->getPeopleId());
            $uploadListWithIdKey = [];
            foreach ($uploadList as $dokumen) {
                $id = $dokumen['id'];
                unset($dokumen['id']);
                $uploadListWithIdKey[$id] = $dokumen;
            }

            foreach ($dokumenList as &$dokumen) {
                if (isset($uploadListWithIdKey[$dokumen['id']])) {
                    foreach ($uploadListWithIdKey[$dokumen['id']] as $key => $value) {
                        $dokumen[$key] = $value;
                    }
                }
            }

            echo json_encode($dokumenList);
        }
    }

    public function uploadPengumpulan()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $dokumenList = [];
            foreach (
                $this->dokumen->getDokumenList(
                    TingkatDokumen::from($_POST['tingkat_dokumen'])
                ) as $dokumen
            ) {
                $id = $dokumen['id'];
                unset($dokumen['id']);
                $dokumenList[$id] = str_replace('/', '-', $dokumen['dokumen']);
            }

            $upload = new UploadFile();
            foreach ($_FILES as $key => $file) {
                if ($file['error'] === UPLOAD_ERR_OK) {
                    $pathForDatabase = $upload->writeFile(
                        $file,
                        'Upload_dokumen',
                        $this->mahasiswa->getPeopleId(),
                        $dokumenList[$key]
                    );
                    $this->dokumen->insertUploadDokumen(
                        $key,
                        $this->mahasiswa->getPeopleId(),
                        $pathForDatabase
                    );
                } else {
                    echo "Error uploading file: " . $file['error'];
                }
            }
        }
    }

    public function uploadTest()
    {
        $upload = new UploadFile();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // $upload->upload();
        }
    }
}
