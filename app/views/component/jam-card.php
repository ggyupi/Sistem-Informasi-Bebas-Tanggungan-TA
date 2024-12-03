<?php

/**
 * example 
 * 
 * @param string $id
 * @param string $title
 * @param string $subtitle
 * @return void
 * 
 * @example
 * statusCard(
 *      'test-card',
 *      'Test',
 *      'hai'
 * );
 */
function jamCard($id, $title, $subtitle)
{
    echo '
    <div class="jam-card" id="' . $id . '">
        <div class="jam-card-content">
            <h1>' . $title . '</h1>
            <h3>' . $subtitle . '</h3>
        </div>
    </div>';
}

