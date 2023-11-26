<?php
require_once __DIR__ .'/parsedown-1.7.4/Parsedown.php';

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
        echo "<ul>";
        foreach ($this->path->find_children() as $subcat)
        {
            
            echo "<li><a href=\"" . $subcat->as_url() . "\">" . "Pagina: " .  $subcat->get_name() . "</a></li>";
        }
        echo "</ul>";
    }
}
?>