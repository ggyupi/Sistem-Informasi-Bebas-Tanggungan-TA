<?php

require_once '../app/core/Model.php';

class Login extends Model
{
    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function getUser($username, $password, $level)
    {
        $query = $this->db->prepare("SELECT * FROM Pengguna.[User] WHERE Username = :username AND Password = :password AND Level LIKE '%' + :level + '%'");
        $query->bindValue(":username", $username);
        $query->bindValue(":password", $password);
        $query->bindValue(":level", $level);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
