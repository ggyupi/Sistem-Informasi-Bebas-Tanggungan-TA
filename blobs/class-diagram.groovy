@startuml
skinparam classAttributeIconSize 0


abstract Controller {
    + view() : void
    + logout() : void
    + setUiState() : void
    + error() : void
}

interface IUserApp {
    + getPeopleId() : string
    + getPeopleName() : string
}

class Mahasiswa {
    + NIM : string
    + nama : string
    + username : string
    + getMahasiswaInformation() : array
    + getAllMahasiswaInformation() : array
}

class Admin {
    + idAdmin : string
    + nama : string
    + username : string
    + adminApa : enum
    + parseAdminApa(enum) : string
    + getAdminInformation(string) : array
    + getAdminList() : array
    + getAdminData(string) : array
    + saveAdminData(args) : boolean
    + deleteAdminById(string) : array
}

class Model {
    # db : Database
}


class Dokumen {
  + insertUploadDokumen(args)
  + updateUploadDokumen(args)
  + getDokumenListAllWithUpload(enum)
  + getDokumenList(enum)
  + getDokumenListUploadByNIM(args)
  + getAllDocumentStatus()
  + countDocumentStatusByTingkat()
  + getStatusDokumenByNIM(string)
  + setAdminNull(string)
  + getAllDocumentStatusByTingkat(string)
  + getTop3Pengumpulan(enum)
}

class Login {
  + getUser(args) : array
}

class LoginController {
  - login : Login
  + index() : void
  + login() : void
  + postLogin() : void
  + dologin() : void
}


class UserController {
  + index(string) : void
  + screen() : void
  + getDataPengumpulan() : string
  + getDataPengumpulanNotification() : string
  + uploadPengumpulan() : string
  + statusDokumen() : string
}

class AdminController {
  - admin : Admin
  - mahasiswa : Mahasiswa
  - dokumen : Dokumen
  + index(string) : void
  + screen() : void
  + getDataPengumpulan() : string
  + updateDataPengumpulan() : void
  + getAdminList() : string
  + getAdminData() : string
  + saveAdminData() : void
  + countDocumentStatus() : int
  + getCountStatus() : string
  + deleteAdmin() : string
  + getRecentDokumenGrouped() : string
  + getDataDokumenJurusan() : string
  + getDataDokumenPusat() : string
  + getDataDokumenSuper() : string
}

Model <|-- Login
Model <|-- Admin
Model <|-- Dokumen
Model <|-- Mahasiswa
IUserApp <|.. Mahasiswa
IUserApp <|.. Admin

Controller <|-- LoginController
LoginController --> Mahasiswa

Controller <|-- UserController
UserController --> Mahasiswa
UserController --> Dokumen

Controller <|-- AdminController
AdminController --> Admin
AdminController --> Dokumen
AdminController --> Mahasiswa
@enduml

