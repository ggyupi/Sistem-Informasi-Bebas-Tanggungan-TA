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
        $output = $this->getAdminBasicInformation($username);
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

    public function getAdminBasicInformation($username)
    {
        $query = $this->db->prepare("SELECT NIDN, Nama FROM Pengguna.Admin WHERE username = :username");
        $query->bindValue(":username", $username);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
