<?php
require_once "path_extract.php";

function Card(Path $path)
{
    $name = $path->get_name();
    $href = $path->as_url();
    if ($path->is_page())
    {
        $button_class = "pagebutton";
    }
    else
    {
        $button_class = "";
    }

    echo '<article class="card">';
    echo '<h3>' . $name . '</h3>';
    echo '<a class="button ' . $button_class . '" href="' . $href . '">Apri</a>';
    echo '</article>';
}
?>