<?php

require_once '../app/models/Admin.php';
require_once '../app/models/Mahasiswa.php';
require_once '../app/models/Dokumen.php';

class AdminController extends Controller
{
    private $admin;
    private $mahasiswa;
    private $dokumen;

    public function __construct()
    {
        $db = Database::getInstance(getDatabaseConfig(), [$this, 'error']);
        $this->mahasiswa = new Mahasiswa($db);
        $this->dokumen = new Dokumen($db);
        $this->admin = new Admin(
            $db,
            Session::get('username'),
            Session::get('level'),
        );
    }

    public function index($screen = "dashboard")
    {
        $title = $screen;
        if (strpos($title, '/') !== false) {
            $title = explode('/', $title);
            $title = array_pop($title);
            $title = str_replace('_', ' ', $title);
            $title = ucwords($title);
        }

        $this->view('admin/index', [
            "screen" => $screen,
            "title" => $title,
            "user" => $this->admin
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
            $mahasiswaList = $this->mahasiswa->getAllMahasiswaInformation();

            $tingkatDokumen = $this->admin->adminApa;
            if ($tingkatDokumen === TipeAdmin::Super) {
                $tingkatDokumen = TingkatDokumen::from($_POST['super-tingkat']);
            } else {
                $tingkatDokumen = TingkatDokumen::from(ucwords($this->admin->adminApa->value));
            }
            $dokumenList = $this->dokumen->getDokumenList($tingkatDokumen);
            $everToSubmit = [];
            foreach ($this->dokumen->getDokumenListAllWithUpload($tingkatDokumen) as $dokumen) {
                $nim = $dokumen['nim'];
                unset($dokumen['nim']);
                $everToSubmit[$nim][] = $dokumen;
            }

            $data = [];
            foreach ($mahasiswaList as $mahasiswa) {
                $temp = [
                    'data_mahasiswa' => $mahasiswa,
                ];
                foreach ($dokumenList as $dokumen) {
                    $temp['data_detail'][] = [
                        'dokumen' => $dokumen['dokumen'],
                        'id' => $dokumen['id'],
                        'status' => ''
                    ];
                }
                if (isset($everToSubmit[$mahasiswa['nim']])) {
                    $dokumenMahasiswaNim = $everToSubmit[$mahasiswa['nim']];
                    foreach ($dokumenMahasiswaNim as $key => $value) {
                        $temp['data_detail'][$key] = $value;
                    }
                }
                $data[] = $temp;
            }
        }

        echo json_encode($data);
    }

    public function updateDataPengumpulan()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->dokumen->updateUploadDokumen(
                $_POST['id_dokumen'],
                $_POST['nim'],
                $this->admin->getPeopleId(),
                $_POST['acc'] === 'true' ? StatusDokumen::Diverifikasi : StatusDokumen::Ditolak,
                isset($_POST['komentar']) ? $_POST['komentar'] : ''
            );
        }
    }
}
