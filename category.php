<?php
require_once __DIR__ .'/parsedown-1.7.4/Parsedown.php';

$Parsedown = new Parsedown();
$Parsedown->setSafeMode(true);

class Category
{
    protected $path;
    protected $path_array;
    protected $subcategories;

    function __construct($not_sanitized_path_str)
    {
        if ( is_null($not_sanitized_path_str))
        {
            $not_sanitized_path_str = "";
        }
        $this->path_array = sanitize_address($not_sanitized_path_str);
        $this->path = "content/" . implode("/", $this->path_array);

        if ( !is_dir($this->path))
        {
            http_response_code(404);
            echo "Percorso \"" . $this->path . "\" inesistente";
            die;
        }

        $this->subcategories = [];
        foreach (new FilesystemIterator($this->path) as $file) {
            if ( is_dir($file)) { array_push($this->subcategories, $file->getBaseName()); }
            // if ( is_file($file)) { echo '<br>file: ' . $file->getBaseName(); }
        }
    }

    public function render()
    {
        // echo $this->subcategories;
        foreach ($this->subcategories as $subcat)
        {
            $subcat_filepath = "content/" . implode("/",  array_merge($this->path_array, [$subcat, "index.md"]) );
            $query_param = implode("|",  array_merge($this->path_array, [$subcat]) );
            if (is_file($subcat_filepath))
            {
                echo "<a href=\"/index.php?path=" . $query_param . "\">" . "Pagina: " .  $subcat . "</a><br>";
            }
            else
            {
                echo "<a href=\"/index.php?path=" . $query_param . "\">" . "Categoria: " . $subcat . "</a><br>";
            }
            
        }
    }

    public function get_folder_path() : string
    {
        return $this->path;
    }

    public function num_subcategories() : int
    {
        return count($this->subcategories);
    }
}
?>