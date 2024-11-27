<?php

function iconButton($id, $icon, $color = 'black', $onclick = '')
{
    echo '<button class="btn btn-icon" type="button" ' . ($id !== '' ? 'data-bs-toggle="modal" data-bs-target="#' . $id . '"' : '') . ' onclick="' . $onclick . '">';
    echo SvgIcons::getIconWithColor($icon, $color);
    echo '</button>';
}
