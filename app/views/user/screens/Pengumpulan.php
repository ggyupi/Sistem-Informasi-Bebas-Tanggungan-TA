<?php
include_once VIEWS . 'component/status-badge.php';
include_once VIEWS . 'component/btn-icon.php';
?>

<style>
    #pengumpulan-page {
        display: flex;
        flex-direction: column;
        gap: 24px;
        flex: 1;
        overflow-y: auto;
    }

    #total-tanggungan-bottom .flex-row {
        gap: 12px;
    }
</style>

<div id="pengumpulan-page">
    <div id="page-content-top">
        <h1>Dokumen <strong><?= $data['user']->getPeopleName() ?></strong></h1>
    </div>

    <div id="page-content-middle">
        <div id="page-content-middle-left">
            <div id="total-tanggungan">
                <div class="d-flex flex-row align-items-center justify-content-between" id="total-tanggungan-top">
                    <div class="d-flex flex-row align-items-center">
                        <h2>Tanggungan Jurusan</h2>
                        <div class="status-badge-text slim primary">3</div>
                    </div>
                    <p>12 Desember 2024</p>
                </div>
                <div class="d-flex flex-row" style="gap: 12px;" id="total-tanggungan-bottom">
                    <div class="d-flex flex-row align-items-center">
                        <div class="status-badge-text success">3</div>
                        <h5>Terverfikasi</h5>
                    </div>
                    <div class="d-flex flex-row align-items-center">
                        <div class="status-badge-text">3</div>
                        <h5>Pending</h5>
                    </div>
                    <div class="d-flex flex-row align-items-center">
                        <div class="status-badge-text danger">3</div>
                        <h5>Tertanggung</h5>
                    </div>
                </div>
            </div>

            <div id="list-dokumen-wrapper">
                <h2>Daftar Dokumen Jurusan</h2>
                <div class="d-flex flex-column" id="list-dokumen">
                    <div class="list-dokumen-item">
                        <div class="status-badge-text success"><?= SvgIcons::getIconWithColor(Icons::Check, 'white') ?></div>
                        <p>Surat Bebas Tanggungan Jurusan</p>
                    </div>
                    <div class="list-dokumen-item">
                        <div class="status-badge-text success"><?= SvgIcons::getIconWithColor(Icons::Check, 'white') ?></div>
                        <p>Surat Bebas Tanggungan Jurusan</p>
                    </div>
                    <div class="list-dokumen-item">
                        <div class="status-badge-text success"><?= SvgIcons::getIconWithColor(Icons::Check, 'white') ?></div>
                        <p>Surat Bebas Tanggungan Jurusan</p>
                    </div>
                    <div class="list-dokumen-item">
                        <div class="status-badge-text success"><?= SvgIcons::getIconWithColor(Icons::Check, 'white') ?></div>
                        <p>Surat Bebas Tanggungan Jurusan</p>
                    </div>
                    <div class="list-dokumen-item">
                        <div class="status-badge-text success"><?= SvgIcons::getIconWithColor(Icons::Check, 'white') ?></div>
                        <p>Surat Bebas Tanggungan Jurusan</p>
                    </div>
                    <div class="list-dokumen-item">
                        <div class="status-badge-text success"><?= SvgIcons::getIconWithColor(Icons::Check, 'white') ?></div>
                        <p>Surat Bebas Tanggungan Jurusan</p>
                    </div>
                    <div class="list-dokumen-item">
                        <div class="status-badge-text success"><?= SvgIcons::getIconWithColor(Icons::Check, 'white') ?></div>
                        <p>Surat Bebas Tanggungan Jurusan</p>
                    </div>
                </div>
            </div>
        </div>

        <form id="form-pengumpulan">
            <div id="form-pengumpulan-item">
                <div class="border-bottom" id="form-pengumpulan-item-header">
                    <h2>Nama Dokumen</h2>
                    <div class="d-flex flex-row align-items-center">
                        <p>12 Desember 2024</p>
                        <?= statusBadge('success', Icons::Check, 'Terverfikasi') ?>
                    </div>
                </div>

                <div id="form-pengumpulan-upload-wrapper">
                    <h3>Bukti Mendukung</h3>
                    <label for="file-input" class="form-pengumpulan-upload">
                        <p id="upload-placeholder">Upload Dokumen Disini min</p>
                        <div class="d-none" id="upload-terlampir-wrapper">
                            <div id="upload-terlampir">
                                <?= SvgIcons::getIconWithFill(Icons::Document, 'var(--bs-tertiary-color)') ?>
                                <p>Surat Bebas Tanggungan Jurusan</p>
                            </div>
                            <div id="upload-actions">
                                <?= iconButton('btn-upload', Icons::Upload, 'var(--bs-emphasis-color)') ?>
                                <?= iconButton('btn-download', Icons::Download, 'var(--bs-emphasis-color)') ?>
                                <?= iconButton('btn-OpenInNewTab', Icons::OpenInNewTab, 'var(--bs-emphasis-color)') ?>
                            </div>
                        </div>
                    </label>
                    <input type="file" class="d-none" id="file-input">
                    </input>
                </div>

                <div class="toggle-komentar komentar-expand">
                    <?= SvgIcons::getIcon(Icons::Message) ?>
                    <h3>Komentar</h3>
                </div>

                <div id="komentar-wrapper">
                    <div id="komentar-people">
                        <div class="member-picture">
                            <img src="<?= IMGS; ?>anggota/Raruu.webp" />
                        </div>
                        <h4>Admin E <?= SvgIcons::getIconWithColor(Icons::Minidot) ?></h4>
                        <p id="tgl-komentar">12 Desember 2024</p>
                    </div>
                    <div id="komentar-text-wrapper">
                        <p>Pesankan dulu le</p>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <div class="d-flex flex-row align-items-center justify-content-between" id="page-content-bottom">
        <h2>Silahkan Upload</h2>
        <button class="btn btn-secondary">Upload</button>
    </div>
</div>