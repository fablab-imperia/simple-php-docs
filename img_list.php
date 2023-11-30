<?php
require_once "private/path_extract.php";
require_once "private/image.php";

$p = new Path();
$p->build_from_query_param($_GET["path"]);

$immagini = $p->get_images();


echo "<ul>";
foreach ($immagini as $img)
{
    $url = $img->as_url() . "&show";
    echo "<li>" . $img->get_filename() . '<a href="' . $url . '">' . '<img class="thumbnail" src="' . $url . '"/>' . "</li>";
}
echo "</ul>";
?>