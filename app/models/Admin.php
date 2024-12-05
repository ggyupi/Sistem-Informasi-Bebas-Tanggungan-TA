<?php

require_once '../app/core/IUserApp.php';
require_once '../app/core/Model.php';

enum TipeAdmin: string
{
    case Super = 'super';
    case Jurusan = 'jurusan';
    case Pusat = 'pusat';
}

class Admin extends Model implements IUserApp
{
    public $NIDN;
    public $nama;
    public $adminApa;
    public $username;

    public static function parseAdminApa($level)
    {
        return substr($level, strpos($level, '-') + 1);
    }

    public function __construct($db, $username, $adminApa)
    {
        parent::__construct($db);
        $output = $this->getAdminInformation($username);
        $this->NIDN = $output['NIDN'];
        $this->nama = $output['Nama'];
        $adminApa = self::parseAdminApa($adminApa);
        $this->adminApa = TipeAdmin::from($adminApa);
    }

    public function getPeopleId()
    {
        return $this->NIDN;
    }

    public function getPeopleName()
    {
        return $this->nama;
    }

    public function getAdminInformation($username)
    {
        $query = $this->db->prepare("SELECT NIDN, Nama FROM Pengguna.Admin WHERE username = :username");
        $query->bindValue(":username", $username);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getAdminList()
    {
        $query = $this->db->prepare("SELECT ad.NIDN id_admin, ad.Nama nama, us.level
        FROM Pengguna.Admin ad
        LEFT JOIN Pengguna.[User] us
        ON ad.username = us.username
        ORDER BY ad.Nama ASC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAdminData($id)
    {
        $query = $this->db->prepare("SELECT 
            ad.NIDN id_admin, ad.Nama nama, ad.NIK nik, 
            ad.Tempat_lahir tempat_lahir, ad.tanggal_lahir,
            ad.Alamat alamat, ad.Nomor_telepon no_telp, 
            ad.Jenis_kelamin jenis_kel, us.level, us.password
        FROM Pengguna.Admin ad 
        LEFT JOIN Pengguna.[User] us
        ON ad.username = us.username
        WHERE NIDN = :id");
        $query->bindValue(":id", $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function saveAdminData(
        $nama,
        $password,
        $nik,
        $tempat_lahir,
        $tanggal_lahir,
        $alamat,
        $no_telp,
        $jenis_kel,
        $level,
        $id
    ) {
        // Memulai transaksi
        $this->db->beginTransaction();

        // Pengecekan apakah id sudah ada di database
        $queryCheck = $this->db->prepare("SELECT COUNT(*) FROM Pengguna.[User] WHERE username = :username");
        $queryCheck->bindValue(":username", $id);
        $queryCheck->execute();
        $exists = $queryCheck->fetchColumn() > 0; // Mengembalikan true jika id sudah ada

        if ($exists) {
            // Jika id sudah ada, lakukan UPDATE pada tabel User
            $queryUser = $this->db->prepare("
                UPDATE Pengguna.[User] 
                SET level = :level, password = :password
                WHERE username = :username
            ");
        } else {
            // Jika id belum ada, lakukan INSERT pada tabel User
            $queryUser = $this->db->prepare("
                INSERT INTO Pengguna.[User] (username, level, password)
                VALUES (:username, :level, :password)
            ");
        }

        $queryUser->bindValue(":password", $password);
        $queryUser->bindValue(":username", $id);
        $queryUser->bindValue(":level", $level);
        $queryUser->execute();

        // Pengecekan apakah id sudah ada di tabel Admin
        $queryCheckAdmin = $this->db->prepare("SELECT COUNT(*) FROM Pengguna.Admin WHERE username = :username");
        $queryCheckAdmin->bindValue(":username", $id);
        $queryCheckAdmin->execute();
        $existsAdmin = $queryCheckAdmin->fetchColumn() > 0;

        if ($existsAdmin) {
            // Jika id sudah ada, lakukan UPDATE pada tabel Admin
            $queryAdmin = $this->db->prepare("
                UPDATE Pengguna.Admin 
                SET Nama = :nama, NIK = :nik, Tempat_lahir = :tempat_lahir,
                    tanggal_lahir = :tanggal_lahir, Alamat = :alamat, 
                    Nomor_telepon = :no_telp, Jenis_kelamin = :jenis_kelamin
                WHERE NIDN = :nidn
            ");
        } else {
            // Jika id belum ada, lakukan INSERT pada tabel Admin
            $queryAdmin = $this->db->prepare("
                INSERT INTO Pengguna.Admin 
                (NIDN, Nama, NIK, Tempat_lahir, tanggal_lahir, Alamat,
                Nomor_telepon, Jenis_kelamin, username)
                VALUES (:nidn, :nama, :nik, :tempat_lahir, :tanggal_lahir,
                :alamat, :no_telp, :jenis_kelamin, :username)
            ");
            $queryAdmin->bindValue(":username", $id);
        }

        $queryAdmin->bindValue(":nama", $nama);
        $queryAdmin->bindValue(":nik", $nik);
        $queryAdmin->bindValue(":tempat_lahir", $tempat_lahir);
        $queryAdmin->bindValue(":tanggal_lahir", $tanggal_lahir);
        $queryAdmin->bindValue(":alamat", $alamat);
        $queryAdmin->bindValue(":no_telp", $no_telp);
        $queryAdmin->bindValue(":jenis_kelamin", $jenis_kel);
        $queryAdmin->bindValue(":nidn", $id);
        $queryAdmin->execute();

        // Commit transaksi
        $this->db->commit();
        return true;
    }

    public function deleteAdminById($id_admin)
    {
        $query = "DELETE FROM Pengguna.Admin WHERE NIDN = :id_admin";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_admin', $id_admin, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return ["status" => "success", "message" => "Data admin berhasil dihapus."];
        } else {
            return ["status" => "error", "message" => "Gagal menghapus data admin."];
        }
    }
}
