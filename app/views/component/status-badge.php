<?php

function statusBadge($type, $icon, $text)
{
    return '
    <div class="status-badge ' . $type . '-bg">
        <div class="status-badge-icon ' . $type . '">
            ' . SvgIcons::getIcon($icon) . '
        </div>
        ' . $text . '
    </div>';
}
