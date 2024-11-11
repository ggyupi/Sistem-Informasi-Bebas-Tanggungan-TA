<?php

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct(array $config)
    {
        $serverName = $config["server_name"];
        $database = $config["database"];
        $username = $config["username"];
        $password = $config["password"];

        try {
            $dsn = "sqlsrv:server=$serverName;Database=$database";
            $this->connection = new PDO($dsn, $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Koneksi gagal tuan: " . $e->getMessage());
        }
    }

    public static function getInstance(array $config)
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
