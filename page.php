<?php
require_once __DIR__ .'/parsedown-1.7.4/Parsedown.php';

require_once "path_extract.php";



class Page
{
    private $path;

    function __construct(Path $path_obj)
    {
       $this->path = $path_obj;
    }

    public function render()
    {
        if ($this->path->is_page())
        {
            $Parsedown = new Parsedown();
            $Parsedown->setSafeMode(true);
            echo $Parsedown->text(
                $this->get_content_only()
            );
        }
        else
        {
            echo "Questa non è una pagina";
        }
    }

    public function get_full_file_content() : string
    {
        return file_get_contents($this->path->as_md_file());
    }

    public function get_content_only() : string
    {
        $s = file_get_contents($this->path->as_md_file());

        return substr(
            $s,
            strpos($s, "+++", 1) + 3
        );
    }


}
?>