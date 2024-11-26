<?php

function iconButton($id, $icon, $color = 'black')
{
    echo '<button class="btn btn-icon" type="button" ' . ($id !== '' ? 'data-bs-toggle="modal" data-bs-target="#' . $id . '"' : '') . '>';
    echo SvgIcons::getIconWithColor($icon, $color);
    echo '</button>';
}
