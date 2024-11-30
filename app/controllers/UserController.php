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
        if (strpos($title, '/') !== false) {
            $title = array_pop(explode('/', $title));
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
            $tingkatDokumen = TingkatDokumen::Jurusan;
            $dokumenList = $this->dokumen->getDokumenList($tingkatDokumen);
            $uploadList = $this->dokumen->getDokumenListUploadByNIM($this->mahasiswa->getPeopleId());
            $uploadListWithIdKey = [];
            foreach ($uploadList as $dokumen) {
                $id = $dokumen['id'];
                unset($dokumen['id']);
                $uploadListWithIdKey[$id] = $dokumen;
            }

            foreach ($dokumenList as &$dokumen) {
                if (isset($uploadListWithIdKey[$dokumen['id']])) {                    
                    foreach ($uploadListWithIdKey[$dokumen['id']] as $key => $value){
                      $dokumen[$key] = $value;  
                    }
                }
            }

            echo json_encode($dokumenList);
        }
    }

    public function uploadTest()
    {
        $upload = new UploadFile();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $upload->upload();
        }
    }
}
