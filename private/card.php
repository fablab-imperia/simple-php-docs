<?php
require_once "path_extract.php";

function Card(Path $path)
{
    $name = $path->get_name();
    $href = $path->as_url();
    $style = "";
    if ($path->is_page())
    {
        $style = "background-color: black";
    }

    echo '<article class="card">';
    echo '<h3>' . $name . '</h3>';
    echo '<a style="' . $style . '" class="button" href="' . $href . '">Apri</a>';
    echo '</article>';
}
?>