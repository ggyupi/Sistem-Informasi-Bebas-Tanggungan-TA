<!-- <div class="modal fade" id="dialog-logout" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Logout</h1>
            </div>
            <div class="modal-body">
                Logout dan Hapus Sesi Saat ini
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-bs-dismiss="modal"><?= SvgIcons::getIcon(Icons::Close) ?>Ga Jadi</button>
                <form method="post" action="logout">
                    <button type="submit" class="btn btn-danger"><?= SvgIcons::getIcon(Icons::Logout) ?>Logout</button>
                </form>
            </div>
        </div>
    </div>
</div> -->

<?php
function dialogYesNo($id = '', $title = 'Yes/No Dialog', $message = 'message', $textYes = 'Ya', $textNo = 'Tidak', $static = true)
{
    echo '<div class="modal fade" id="'  . 'dialog-' . $id . '" ' . ($static ? 'data-bs-backdrop="static"' : '') . ' data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">';
    echo '<div class="modal-dialog modal-dialog-centered">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<h1 class="modal-title fs-5" id="staticBackdropLabel">' . $title . '</h1>';
    echo '</div>';
    echo '<div class="modal-body">';
    echo $message;
    echo '</div>';
    echo '<div class="modal-footer">';
    echo '<button type="button" class="btn btn-outline" data-bs-dismiss="modal">' . $textNo . '</button>';
    echo '<button type="submit" class="btn btn-danger">' . $textYes . '</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
?>