<?php

require_once '../app/core/IUserApp.php';

class Mahasiswa implements IUserApp
{
    private $db;
    public $NIM;
    public $nama;
    public $idProdi;
    public $username;

    public function __construct($db, $username)
    {
        $this->db = $db->getConnection();
        $output = $this->getMahasiswaBasicInformation($username);
        $this->NIM = $output['NIM'];
        $this->nama = $output['Nama'];
        $this->idProdi = $output['ID_prodi'];
    }

    public function getPeopleId()
    {
        return $this->NIM;
    }

    public function getPeopleName()
    {
        return $this->nama;
    }

    public function getMahasiswaBasicInformation($username)
    {
        $query = $this->db->prepare("SELECT NIM, Nama, ID_prodi FROM Pengguna.Mahasiswa WHERE username = :username");
        $query->bindValue(":username", $username);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
