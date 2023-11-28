<?php
require_once  __DIR__ . '/../parsedown-1.7.4/Parsedown.php';

require_once "path_extract.php";
require_once "CONST.php";
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
            echo "<h1>" . $this->get_title() . "</h1>";
            echo "<a href=\"" . $this->path->as_url_mut() . "\">Modifica</a>";
            echo "<hr>";

            echo $Parsedown->text(
                $this->insert_relative_links(
                    $this->get_content_only()
                )
            );
        }
        else
        {
            http_response_code(503);
            echo "Questa non è una pagina";
            die;
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

    public function get_title() : ?string
    {
        $full_text = $this->get_full_file_content();
        $frontmatter_start_index = strpos($full_text, "+++")+3;
        if ($frontmatter_start_index==false)
        {
            http_response_code(503);
            echo "Frontmatter non valido";
            die;
        }
        $frontmatter_stop_index = strpos($full_text, "+++", $frontmatter_start_index);
        if ($frontmatter_stop_index==false)
        {
            http_response_code(503);
            echo "Frontmatter non valido";
            die;
        }

        $frontmatter = substr($full_text, $frontmatter_start_index, $frontmatter_stop_index-$frontmatter_start_index);
        preg_match(REGEXP_TITLE_EXTRACT, $frontmatter, $output);

        if (count($output) < 2)
        {
            http_response_code(503);
            echo "Frontmatter non valido, titolo assente";
            die;
        }

        return $output[1];
    }

    function insert_relative_links(string $text_content) : string
    {
        // Link ad altre pagine
        return preg_replace_callback(
            "/(!*)\[([a-zA-Z0-9 \_\.]*)]\(([|a-z_\.]+)\)/",
            function ($a){
                // if ($a[1]=="!")
                // {
                //     $new_url = "/index." . $tpath->as_query_only();
                // }
                // else
                // {
                //     $new_url = "/index." . $path->as_query_only();
                // }                
                return $a[1] . "[" . $a[2] . "](" . $a[3] . ")";
            },
            $text_content
        );
    }
}
?>