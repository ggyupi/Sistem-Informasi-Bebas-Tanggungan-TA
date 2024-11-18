<div class="modal fade" id="dialog-logout" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Logout</h1>
            </div>
            <div class="modal-body">
                Logout dan Hapus Sesi Saat ini
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-bs-dismiss="modal"><?= SvgIcons::getIcon(Icons::Close)?>Ga Jadi</button>
                <form method="post" action="logout">
                    <button type="button" class="btn btn-danger"><?= SvgIcons::getIcon(Icons::Logout) ?>Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>