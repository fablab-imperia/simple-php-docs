<?php require "private/path_extract.php";
require_once "private/image.php";
$p = new Path();
$p->build_from_query_param($_GET["path"]);
$img = new Image($p, $_GET["img"]);
$img->dump(); ?>