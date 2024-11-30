<?php

require_once '../app/core/IUserApp.php';
require_once '../app/core/Model.php';

class Mahasiswa extends Model implements IUserApp
{
    public $NIM;
    public $nama;
    public $idProdi;
    public $username;


    public function __construct($db, $username = null)
    {
        parent::__construct($db);
        if ($username !== null) {
            $output = $this->getMahasiswaInformation($username);
            $this->NIM = $output['NIM'];
            $this->nama = $output['Nama'];
            $this->idProdi = $output['ID_prodi'];
        }
    }

    public function getPeopleId()
    {
        return $this->NIM;
    }

    public function getPeopleName()
    {
        return $this->nama;
    }

    public function getMahasiswaInformation($username)
    {
        $query = $this->db->prepare("SELECT NIM, Nama, ID_prodi FROM Pengguna.Mahasiswa WHERE username = :username");
        $query->bindValue(":username", $username);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllMahasiswaInformation()
    {
        $query = $this->db->prepare("SELECT m.NIM nim, m.Nama nama,
            p.Nama_Prodi program_studi, p.Jurusan jurusan
            FROM Pengguna.Mahasiswa m 
            INNER JOIN prodi.Prodi p ON m.ID_prodi = p.ID
            ORDER BY nama ASC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
