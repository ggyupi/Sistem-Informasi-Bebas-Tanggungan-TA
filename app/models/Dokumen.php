<?php

require_once '../app/core/Model.php';

enum TingkatDokumen: String
{
    case Jurusan = "Jurusan";
    case Pusat = "Pusat";
}

class Dokumen extends Model
{
    public function __construct($db)
    {
        parent::__construct($db);
    }

    
    public function uploadDokumenList($id, $nim)
    {
        $placeholders = [];
        foreach ($nim as $index => $tmp) {
            $placeholders[] = ":nim$index";
        }
        $placeholderNim = implode(',', $placeholders);

        $query = $this->db->prepare("SELECT
            ID id, Path_dokumen path_dokumen, 
            Status status, tanggal
            FROM dokumen.Upload_dokumen 
            WHERE NIM IN ($placeholderNim)");

        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }    

    public function getDokumenList($tingkatDokumen)
    {
        $query = $this->db->prepare("SELECT li.ID id, 
            li.Nama_dokumen dokumen, up.Path_dokumen path_dokumen,
            up.Status status ,up.NIM nim FROM dokumen.Dokumen li
            LEFT JOIN dokumen.Upload_dokumen up 
            ON li.ID = up.ID_dokumen
            WHERE Tingkat = :tingkatDokumen");
        $query->bindValue(":tingkatDokumen", $tingkatDokumen->value);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
