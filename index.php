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


$c = new Category($_GET["path"]);
$c->render();

if ($c->num_subcategories()==0)
{
    $file_path = $c->get_folder_path() . "/index.md";
    if (is_file($file_path))
    {
        $full_text = file_get_contents($file_path);
        echo $Parsedown->text($full_text);
    }

}

?>
