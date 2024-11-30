<?php

require_once '../app/core/Model.php';

enum TingkatDokumen: String
{
    case Jurusan = "Jurusan";
    case Pusat = "Pusat";
}

enum StatusDokumen: String
{
    case Menunggu = "Menunggu";
    case Diverifikasi = "Diverifikasi";
    case Ditolak = "Ditolak";
}

class Dokumen extends Model
{
    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function updateUploadDokumen(
        $idDokumen,
        $NIM,
        $adminID = '',
        $status = StatusDokumen::Menunggu,
        $komentar = ''
    ) {
        $query = $this->db->prepare("UPDATE dokumen.Upload_dokumen 
            SET NIDN = :adminID, Status = :status 
            WHERE ID_dokumen = :idDokumen AND NIM = :NIM");
        $query->bindValue(":adminID", $adminID);
        $query->bindValue(":status", $status->value);
        $query->bindValue(":idDokumen", $idDokumen);
        $query->bindValue(":NIM", $NIM);
        $query->execute();

        if ($komentar !== '') {
            $query = $this->db->prepare("SELECT ID FROM dokumen.Upload_dokumen 
            WHERE ID_dokumen = :idDokumen AND NIM = :NIM");
            $query->bindValue(":idDokumen", $idDokumen);
            $query->bindValue(":NIM", $NIM);
            $query->execute();
            $result = $query->fetch();
            $idUpload = $result['ID'];

            $query = $this->db->prepare("SELECT COUNT(*) FROM dokumen.Komentar WHERE ID_upload = :idUpload");
            $query->bindValue(":idUpload", $idUpload);
            $query->execute();
            $count = $query->fetchColumn();

            if ($count > 0) {
                $query = $this->db->prepare("UPDATE dokumen.Komentar SET isi_komentar = :komentar WHERE ID_upload = :idUpload");
            } else {
                $query = $this->db->prepare("INSERT INTO dokumen.Komentar (isi_komentar, ID_upload) VALUES (:komentar, :idUpload)");
            }
            $query->bindValue(":komentar", $komentar);
            $query->bindValue(":idUpload", $idUpload);
            $query->execute();
        }
    }

    public function getDokumenListAllWithUpload($tingkatDokumen)
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

    public function getDokumenList($tingkatDokumen)
    {
        $query = $this->db->prepare("SELECT li.ID id, 
            li.Nama_dokumen dokumen
            FROM dokumen.Dokumen li
            WHERE Tingkat = :tingkatDokumen");
        $query->bindValue(":tingkatDokumen", $tingkatDokumen->value);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDokumenListUploadByNIM($nim)
    {
        $query = $this->db->prepare("SELECT up.ID id,
            up.Path_dokumen path_dokumen, up.Status status, up.tanggal tanggal_upload,
            ad.Nama nama_admin, k.isi_komentar, k.tanggal tanggal_komentar
            FROM dokumen.Upload_dokumen up 
            LEFT JOIN pengguna.Admin ad
            on up.NIDN = ad.NIDN
            LEFT JOIN dokumen.Komentar k
            on up.ID = k.ID_upload
            WHERE NIM = :nim");
        $query->bindValue(":nim", $nim);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
