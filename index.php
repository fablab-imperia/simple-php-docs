<?php

include "path_extract.php";
require_once "header.php";
require_once "category.php";

$p = new Path();
$p->build_from_query_param($_GET["path"]);
if ($p->is_category())
{
    echo "true";
}
else if ($p->is_page())
{
    echo "pagina";
}
else
{
    http_response_code(404);
    echo "Percorso \"" . $this->path . "\" inesistente";
    require "footer.php";
    die;
}

echo $p->as_md_file();
$c = new Category($p);
$c->render();

require "footer.php";
?>
