<?php

/**
 * This is a component for displaying a yes/no dialog.
 * 
 * @param string $id The id of the dialog. Default is an empty string.
 * @param string $title The title of the dialog. Default is 'Yes/No Dialog'.
 * @param string $message The message to be displayed in the dialog. Default is 'message'.
 * @param string $textYes The text of the yes button. Default is 'Ya'.
 * @param string $textNo The text of the no button. Default is 'Tidak'.
 * @param bool $static If true, the dialog will not be closed when the user clicks outside of the dialog. Default is true.
 * 
 * Example:
 * dialogYesNo('dialog-id', 'Confirm Delete', 'Are you sure you want to delete this file?', 'Delete', 'Cancel', false);
 */
function dialogYesNo($id = '', $title = 'Yes/No Dialog', $message = 'message', $textYes = 'Ya', $textNo = 'Tidak', $static = true)
{
    echo '<div class="modal fade" id="'  . $id . '" ' . ($static ? 'data-bs-backdrop="static"' : '') . ' data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">';
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
