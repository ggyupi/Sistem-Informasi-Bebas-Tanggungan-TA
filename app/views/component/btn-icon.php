<?php

function iconButton($id, $icon, $color = 'black', $onclick = '')
{
    return '<button class="btn btn-icon" type="button" ' 
    . ($id !== '' ? 'data-bs-toggle="modal" data-bs-target="#' . $id . '"' : ($onclick === '' ? 'data-bs-dismiss="modal"' : ''))
    . ($onclick !== '' ? ' onclick="' . $onclick . '"' : '') . '>'
    . SvgIcons::getIconWithColor($icon, $color) 
    . '</button>';
}
