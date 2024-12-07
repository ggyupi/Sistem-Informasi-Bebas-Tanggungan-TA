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
        if (!Session::exists('username') || !in_array(Admin::parseAdminApa(Session::get('level')), array_column(TipeAdmin::cases(), 'value'))) {
            $this->logout('login');
        }
        try {
            $db = Database::getInstance(getDatabaseConfig(), [$this, 'error']);
            $this->mahasiswa = new Mahasiswa($db);
            $this->dokumen = new Dokumen($db);
            $this->admin = new Admin(
                $db,
                Session::get('username'),
                Session::get('level'),
            );
        } catch (Throwable $th) {
            $this->logout('login');
        }
    }

    public function index($screen = "dashboard")
    {
        if ($screen == 'dashboard' && $this->admin->adminApa === TipeAdmin::Super) {
            $screen = 'super/dashboard';
        }
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
            "user" => $this->admin,
            "filter" => isset($_GET['filter']) ? $_GET['filter'] : ''
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
                $tingkatDokumen = TingkatDokumen::from($_POST['super_tingkat']);
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
                        $temp['data_detail'][$dokumen['id']] = [
                        'dokumen' => $dokumen['dokumen'],
                        'id' => $dokumen['id'],
                        'status' => ''
                    ];
                }
                if (isset($everToSubmit[$mahasiswa['nim']])) {
                    $dokumenMahasiswaNim = $everToSubmit[$mahasiswa['nim']];
                    foreach ($dokumenMahasiswaNim as $value) {
                        $temp['data_detail'][$value['id']] = $value;
                    }
                }
                $temp['data_detail'] = array_values($temp['data_detail']);
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
                isset($_POST['komentar']) ? $_POST['komentar'] : 'null'
            );
        }
    }

    public function getAdminList()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $adminList = $this->admin->getAdminList();
            foreach ($adminList as &$value) {
                $value['level'] = ucwords($this->admin->parseAdminApa($value['level']));
            }
            echo json_encode($adminList);
        }
    }

    public function getAdminData()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $adminData = $this->admin->getAdminData($_POST['id']);
            $adminData['level'] = ucwords($this->admin->parseAdminApa($adminData['level']));
            echo json_encode($adminData);
        }
    }

    public function saveAdminData()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->admin->saveAdminData(
                id: $_POST['id_admin'],
                password: $_POST['password'],
                nama: $_POST['nama'],
                nik: $_POST['nik'],
                tempat_lahir: $_POST['tempat_lahir'],
                tanggal_lahir: $_POST['tanggal_lahir'],
                jenis_kel: $_POST['jenis_kel'],
                alamat: $_POST['alamat'],
                no_telp: $_POST['no_telp'],
                level: 'admin-' . strtolower($_POST['level'])
            );
        }
    }

    public function countDocumentStatus(string $status): int
    {
        return count(array_filter($this->dokumen->getAllDocumentStatus(), function ($value) use ($status) {
            return $value === $status;
        }));
    }

    public function getCountStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $dataByTingkat = $this->dokumen->countDocumentStatusByTingkat();

            $response = [
                'Jurusan' => [
                    'menunggu' => $dataByTingkat['Jurusan'][StatusDokumen::Menunggu->value] ?? 0,
                    'diverifikasi' => $dataByTingkat['Jurusan'][StatusDokumen::Diverifikasi->value] ?? 0,
                    'ditolak' => $dataByTingkat['Jurusan'][StatusDokumen::Ditolak->value] ?? 0,
                ],
                'Pusat' => [
                    'menunggu' => $dataByTingkat['Pusat'][StatusDokumen::Menunggu->value] ?? 0,
                    'diverifikasi' => $dataByTingkat['Pusat'][StatusDokumen::Diverifikasi->value] ?? 0,
                    'ditolak' => $dataByTingkat['Pusat'][StatusDokumen::Ditolak->value] ?? 0,
                ]
            ];

            echo json_encode($response);
        }
    }

    public function deleteAdmin()
    {
        // Periksa apakah permintaan adalah POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id_admin = $_POST['id'];

            // Validasi ID admin
            if (empty($id_admin)) {
                echo json_encode(["status" => "error", "message" => "ID admin tidak valid."]);
                return;
            }

            // Hapus data admin menggunakan model
            $this->dokumen->setAdminNull($id_admin);
            $result = $this->admin->deleteAdminById($id_admin);
            echo json_encode($result);
        } else {
            echo json_encode(["status" => "error", "message" => "Permintaan tidak valid."]);
        }
    }

    public function getRecentDokumenGrouped()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'Jurusan' => $this->dokumen->getRecentDokumenByTingkat('Jurusan'),
                'Pusat' => $this->dokumen->getRecentDokumenByTingkat('Pusat'),
                'Keduanya' => $this->dokumen->getRecentDokumenByTingkat('Keduanya')
            ];

            echo json_encode($data);
        }
    }
}
