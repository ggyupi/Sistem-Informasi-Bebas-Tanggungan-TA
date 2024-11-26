<?php

function statusBadge($type, $icon, $text)
{
    echo '<div class="status-badge ' . $type . '-bg">';
    echo '<div class="status-badge-icon ' . $type . '">';
    echo SvgIcons::getIcon($icon);
    echo '</div>';
    echo $text;
    echo '</div>';
}
