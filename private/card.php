<?php
function Card(string $name, string $href)
{
    echo '<article class="card">';
    echo '<h3>' . $name . '</h3>';
    echo '<a class="button" href="' . $href . '">Apri</a>';
    echo '</article>';
}
?>