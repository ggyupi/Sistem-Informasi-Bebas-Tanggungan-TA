<?php

require_once '../app/core/IUserApp.php';
require_once '../app/core/Model.php';

enum TipeAdmin : String
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

    public function __construct($db, $username, $adminApa)
    {
        parent::__construct($db);
        $output = $this->getAdminInformation($username);
        $this->NIDN = $output['NIDN'];
        $this->nama = $output['Nama'];        
        $adminApa = substr($adminApa, strpos($adminApa, '-') + 1);
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

    public function getAdminList(){
        $query = $this->db->prepare("SELECT NIDN, Nama, NIDN id FROM Pengguna.Admin");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAdminData($id)
    {
        $query = $this->db->prepare("SELECT * FROM Pengguna.Admin WHERE NIDN = :id");
        $query->bindValue(":id", $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
