<?php

include "private/path_extract.php";
require_once "private/category.php";
require_once "private/page.php";

$p = new Path();
$p->build_from_query_param($_GET["path"]);
$GLOBALS["breadcrumb"] = $p->get_breadcrumb_data();
if ($p->is_category())
{
    require "private/header.php";
    $c = new Category($p);
    $c->render();
}
else if ($p->is_page())
{
    $page = new Page($p);
    $GLOBALS["page_title"] = $page->get_title();
    require "private/header.php";
    $page->render();
    $page->get_title();
}
else
{
    http_response_code(404);
    require "private/header.php";
    echo "Percorso \"" . $p->as_url() . "\" inesistente";
}
require "private/footer.php";
?>
