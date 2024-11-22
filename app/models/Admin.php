<?php

require_once '../app/core/IUserApp.php';

class Admin implements IUserApp
{
    private $db;
    public $NIDN;
    public $nama;
    public $adminApa;
    public $username;

    public function __construct($db, $username, $adminApa)
    {
        $this->db = $db->getConnection();
        $output = $this->getAdminBasicInformation($username);
        $this->NIDN = $output['NIDN'];
        $this->nama = $output['Nama'];
        $this->adminApa = $adminApa;
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
