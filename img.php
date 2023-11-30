<?php
require_once "private/path_extract.php";
require_once "private/image.php";
require_once "private/CONST.php";

$p = new Path();
$p->build_from_query_param($_GET["path"]);

if (isset($_GET["img"]))
{
    $img = new Image($p, $_GET["img"]);
    $img->dump();
    exit;
}


require_once "private/header.php";
$immagini = $p->get_images();


echo "<ul>";
foreach ($immagini as $img)
{
    $url = $img->as_url() . "&show";
    echo "<li>" . $img->get_filename() . '<a href="' . $url . '">' . '<img class="thumbnail" src="' . $url . '"/>' . "</li>";
}
echo "</ul>";
echo "<a class=\"button\" href=\"" . SITE_URL . "/img_upload.php?" . $p->as_query_only() . "\">" . "Carica nuova immagine" . "</a>";


require_once "private/footer.php";
?>