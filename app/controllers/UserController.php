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
        if (!Session::exists('username')) {
            $this->logout('login');
        }
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
    public function getDataPengumpulanNotification()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // $tingkatDokumenJurusan = TingkatDokumen::Jurusan;
            // $tingkatDokumenPusat = TingkatDokumen::Pusat;
            // $dokumenList = array_merge(
            //     $this->dokumen->getDokumenList($tingkatDokumenJurusan),
            //     $this->dokumen->getDokumenList($tingkatDokumenPusat)
            // );
            // $uploadListJurusan = $this->dokumen->getDocumentNotification($tingkatDokumenJurusan, $this->mahasiswa->getPeopleId());
            // $uploadListPusat = $this->dokumen->getDocumentNotification($tingkatDokumenPusat, $this->mahasiswa->getPeopleId());
            // $uploadList = array_merge($uploadListJurusan, $uploadListPusat);
            // foreach ($dokumenList as &$dokumen) {
            //     foreach ($uploadList as $upload) {
            //         if ($upload['id'] == $dokumen['id']) {
            //             $dokumen['nama_dokumen'] = $upload['dokumen'];
            //         }
            //     }
            // }
            $result = $this->dokumen->getStatusDokumenByNIM($this->mahasiswa->getPeopleId());
            $result = array_filter($result, function ($dokumen) {
                return $dokumen['Status'] === StatusDokumen::Ditolak->value;
            });
            echo json_encode(array_values($result));
        }
    }

    public function uploadPengumpulan()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $dokumenList = [];
            foreach ($this->dokumen->getDokumenList(TingkatDokumen::from($_POST['tingkat_dokumen'])) as $dokumen) {
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

    public function statusDokumen()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nim = $this->mahasiswa->getPeopleId();

            // Ambil status dokumen berdasarkan NIM mahasiswa
            $data = $this->dokumen->getStatusDokumenByNIM($nim);

            // Kirimkan hanya data 'nama_dokumen' dan 'Status' ke view
            $result = [];
            foreach ($data as $dokumen) {
                $result[] = [
                    "nama_dokumen" => $dokumen['nama_dokumen'],
                    "status" => $dokumen['Status']
                ];
            }

            echo json_encode($result);
        }
    }
}
