<?php
require_once  __DIR__ . '/../parsedown-1.7.4/Parsedown.php';

require_once "path_extract.php";
require_once "CONST.php";

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

        $sorted_children = array_merge(
            array_filter(
                $children,
                function($el) {return $el->is_category();}
            ),
            array_filter(
                $children,
                function($el) {return $el->is_page();}
            )
        );

        // if (count($children)==0)
        {
            echo "<a class=\"button\" href=\"" . SITE_URL . "/page_create.php?" . $this->path->as_query_only() . "\">Crea pagina o categoria</a>";
        }
        foreach ($sorted_children as $subcat)
        {
            Card($subcat);
            // echo "<li><a href=\"" . $subcat->as_url() . "\">" . "Pagina: " .  $subcat->get_name() . "</a></li>";
        }
    }
}
?>