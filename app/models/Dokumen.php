<?php

require_once '../app/core/Model.php';

enum TingkatDokumen: string
{
    case Jurusan = "Jurusan";
    case Pusat = "Pusat";
}

enum StatusDokumen: string
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

    public function insertUploadDokumen($idDokumen, $NIM, $path)
    {
        $checkQuery = $this->db->prepare("SELECT COUNT(*)
            FROM dokumen.Upload_dokumen 
            WHERE ID_dokumen = :idDokumen AND NIM = :NIM");
        $checkQuery->bindValue(":idDokumen", $idDokumen);
        $checkQuery->bindValue(":NIM", $NIM);
        $checkQuery->execute();
        if ($checkQuery->fetchColumn() > 0) {
            $this->updateUploadDokumen($idDokumen, $NIM, path: $path);
        } else {
            $insertQuery = $this->db->prepare("INSERT INTO dokumen.Upload_dokumen
                (ID_dokumen, NIM, Path_dokumen, Status) VALUES
                (:idDokumen, :NIM, :path, 'Menunggu')");
            $insertQuery->bindValue(":idDokumen", $idDokumen);
            $insertQuery->bindValue(":NIM", $NIM);
            $insertQuery->bindValue(":path", $path);
            $insertQuery->execute();
        }
    }

    public function updateUploadDokumen(
        $idDokumen,
        $NIM,
        $adminID = NULL,
        $status = StatusDokumen::Menunggu,
        $komentar = '',
        $path = null
    ) {
        $query = '';
        if ($path !== null) {
            $query = $this->db->prepare("UPDATE dokumen.Upload_dokumen 
                SET Path_dokumen = :path, NIDN = :adminID, Status = :status, tanggal = GETDATE() 
                WHERE ID_dokumen = :idDokumen AND NIM = :NIM");
            $query->bindValue(":path", $path);
        } else {
            $query = $this->db->prepare("UPDATE dokumen.Upload_dokumen 
            SET NIDN = :adminID, Status = :status, tanggal = GETDATE() 
            WHERE ID_dokumen = :idDokumen AND NIM = :NIM");
        }
        $query->bindValue(":adminID", $adminID);
        $query->bindValue(":status", $status->value);
        $query->bindValue(":idDokumen", $idDokumen);
        $query->bindValue(":NIM", $NIM);
        $query->execute();

        if ($komentar !== '' || $komentar == 'null') {
            $komentar = $komentar == 'null' ? '' : $komentar;
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

    public function getDokumenListUploadByNIM($tingkatDokumen, $nim)
    {
        $query = $this->db->prepare("SELECT up.ID_Dokumen id,
            up.Path_dokumen path_dokumen, up.Status status, up.tanggal tanggal_upload,
            ad.Nama nama_admin, k.isi_komentar, k.tanggal tanggal_komentar
            FROM dokumen.Dokumen li 
            LEFT JOIN dokumen.Upload_dokumen up 
            ON li.ID = up.ID_dokumen
            LEFT JOIN pengguna.Admin ad
            on up.NIDN = ad.NIDN
            LEFT JOIN dokumen.Komentar k
            on up.ID = k.ID_upload
            WHERE up.NIM = :nim AND li.Tingkat = :tingkatDokumen");
        $query->bindValue(":tingkatDokumen", $tingkatDokumen->value);
        $query->bindValue(":nim", $nim);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getAllDocumentStatus()
    {
        $query = $this->db->prepare("SELECT up.Status FROM dokumen.Upload_dokumen up");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_COLUMN);
    }

    public function countDocumentStatusByTingkat()
    {
        $query = $this->db->prepare("
        SELECT 
            d.Tingkat, 
            up.Status, 
            COUNT(*) as total 
        FROM dokumen.Upload_dokumen up
        JOIN dokumen.Dokumen d ON up.ID_dokumen = d.ID
        GROUP BY d.Tingkat, up.Status
    ");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        // Format hasil agar mudah digunakan
        $data = [];
        foreach ($result as $row) {
            $tingkat = $row['Tingkat'];
            $status = $row['Status'];
            $data[$tingkat][$status] = $row['total'];
        }
        return $data;
    }

    public function getRecentDokumenByTingkat($tingkat, $limit = 3)
    {
        $query = $this->db->prepare("
        SELECT d.id, d.dokumen, d.tanggal_upload, m.Nama AS mahasiswa, m.NIM 
        FROM Pengguna.Dokumen d
        INNER JOIN Pengguna.Mahasiswa m ON d.nim = m.NIM
        WHERE d.tingkat = :tingkat
        ORDER BY d.tanggal_upload DESC
        LIMIT :limit
    ");
        $query->bindValue(":tingkat", $tingkat, PDO::PARAM_STR);
        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStatusDokumenByNIM($nim)
    {
        $query = $this->db->prepare("
        SELECT d.ID id, d.nama_dokumen, u.Status status, d.tingkat
        FROM dokumen.Dokumen d 
        INNER JOIN dokumen.Upload_dokumen u ON d.id = u.ID_dokumen
        WHERE u.nim = :nim
    ");
        $query->bindValue(":nim", $nim, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function setAdminNull($id){
        $query = $this->db->prepare("UPDATE dokumen.Upload_dokumen SET NIDN = NULL WHERE NIDN = :id");
        $query->bindValue(":id", $id);
        $query->execute();
    }
}
