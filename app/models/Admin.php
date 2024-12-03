<?php

require_once '../app/core/IUserApp.php';
require_once '../app/core/Model.php';

enum TipeAdmin: String
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
        ON ad.username = us.username");
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
        $id = ''
    ) {
        if ($id === '') {
            $query = $this->db->prepare("INSERT INTO Pengguna.Admin 
                (Nama, NIK, Tempat_lahir, tanggal_lahir, Alamat,
                Nomor_telepon, Jenis_kelamin)
                VALUES (:nama, :nik, :tempat_lahir, :tanggal_lahir,
                :alamat, :no_telp, :jenis_kelamin)");
        } else {
            $query = $this->db->prepare("UPDATE Pengguna.Admin 
                SET Nama = :nama, NIK = :nik, Tempat_lahir = :tempat_lahir,
                tanggal_lahir = :tanggal_lahir, Alamat = :alamat, 
                Nomor_telepon = :no_telp, Jenis_kelamin = :jenis_kelamin
                WHERE NIDN = :id");
            $query->bindValue(":id", $id);
        }
        $query->bindValue(":nama", $nama);
        $query->bindValue(":nik", $nik);
        $query->bindValue(":tempat_lahir", $tempat_lahir);
        $query->bindValue(":tanggal_lahir", $tanggal_lahir);
        $query->bindValue(":alamat", $alamat);
        $query->bindValue(":no_telp", $no_telp);
        $query->bindValue(":jenis_kelamin", $jenis_kel);
        $query->execute();

        if ($id === '') {
            // TODO : add user
            // $query = $this->db->prepare("INSERT INTO Pengguna.[User] (username, level, password)
            //     VALUES (:username, :level, :password)");
        } else {
            $query = $this->db->prepare("UPDATE Pengguna.[User] 
            SET level = :level, password = :password
            WHERE username = :username");
        }
        $query->bindValue(":password", $password);
        $query->bindValue(":username", $id);
        $query->bindValue(":level", $level);
        $query->execute();
    }
}
