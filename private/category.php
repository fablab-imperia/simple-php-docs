<?php
require_once  __DIR__ . '/../parsedown-1.7.4/Parsedown.php';

require_once "path_extract.php";
$Parsedown = new Parsedown();
$Parsedown->setSafeMode(true);

class Category
{
    private $path;

    function __construct(Path $path_obj)
    {
       $this->path = $path_obj;
    }

    public function render()
    {
        // echo $this->subcategories;
        require_once "card.php";
        $children = $this->path->find_children();
        foreach ($children as $subcat)
        {
            Card($subcat->get_name(), $subcat->as_url());
            // echo "<li><a href=\"" . $subcat->as_url() . "\">" . "Pagina: " .  $subcat->get_name() . "</a></li>";
        }

        if (count($children)==0)
        {
            echo "<a class=\"button\" href=\"" . "/page_create.php?" . $this->path->as_query_only() . "\">Crea pagina o categoria</a>";
        }
    }
}
?>