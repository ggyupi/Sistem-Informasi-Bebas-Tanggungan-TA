<?php

/**
 * example 
 * 
 * @param string $id
 * @param string $title
 * @param array $content [ 
 *  [
 *      'type' => 'success|danger|warning',
 *      'icon' => string,
 *      'title' => string,
 *      'subtitle' => string,
 *      'href' => string,
 *      'id' => string
 *  ]
 * ]
 * @return void
 * 
 * @example
 * statusCard(
 *      'test-card',
 *      'Test',
 *      [[
 *          'type' => 'success',
 *          'icon' => Icons::Close,
 *          'title' => '1 Buku',
 *          'subtitle' => 'Terpinjam',
 *          'href' => '',
 *          'id' => 'test'
 *      ], [
 *          'type' => 'danger',
 *          'icon' => Icons::Logout,
 *          'title' => '1 Buku',
 *          'subtitle' => 'Terpinjam',
 *          'href' => ''
 *      ]]
 * );
 */
function statusCard($id, $title, $content)
{

    echo '<div class="card-status" id="' . $id . '">';
    echo '<h2>' . $title . '</h2>';
    echo '<div class="card-status-content-wrapper">';
    foreach ($content as $c) {
        $hrefId = $c['id'] ?? "";
        $color = $c['type'];
        echo '<div class="card-status-content ' . $color . '-bg" >';
        echo '<div class="card-status-icon ' . $color . '">';
        echo SvgIcons::getIcon($c['icon']);
        echo '</div>';
        echo '<h1>' . $c['title'] . '</h1>';
        echo '<h3>' . $c['subtitle'] . '</h3>';
        if ($c['href'] !== 'null') {
            echo '<a type="submit" id="' . $hrefId . '" href="' . $c['href'] . '">Klik lebih lanjut</a>';
        }
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
}
