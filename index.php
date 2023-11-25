<?php

include "path_extract.php";
require_once "header.php";
require_once "category.php";
require_once "page.php";

$p = new Path();
$p->build_from_query_param($_GET["path"]);
if ($p->is_category())
{
    $c = new Category($p);
    $c->render();
}
else if ($p->is_page())
{
    $page = new Page($p);
    $page->render();
}
else
{
    http_response_code(404);
    echo "Percorso \"" . $this->path . "\" inesistente";
    require "footer.php";
    die;
}

require "footer.php";
?>
