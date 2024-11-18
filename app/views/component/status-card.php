<?php

function statusCard($id, $title, $content)
{

    echo '<div class="card-status" id="' . $id . '">';
    echo '<h2>' . $title . '</h2>';
    echo '<div class="card-status-content-wrapper">';
    foreach ($content as $c) {
        $color = "";
        switch ($c['type']) {
            case 'bad':
                $color = 'danger';
                break;
            case 'warning':
                $color = 'warning';
                break;
            case 'good':
                $color = 'success';
                break;
            default:
                break;
        }
        echo '<div style="background-color: var(--bs-' . $color . '-bg-subtle)" class="card-status-content" >';
        echo '<div class="card-status-icon" style="background-color: var(--bs-' . $color . ')">';
        echo SvgIcons::getIcon($c['icon']);
        echo '</div>';
        echo '<h1>' . $c['title'] . '</h1>';
        echo '<h3>' . $c['subtitle'] . '</h3>';
        echo '<a href="' . $c['href'] . '">Klik lebih lanjut</a>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
}
