<?php
// Funzione comoda per estrarre la querystring

// Restituisce l'array spezzettato del percorso
function sanitize_address(string $path) : array
{
    if (is_null($path) || $path == "")
    {
        return [];
    }
    $path = explode(
        "|",
        preg_replace("/[^a-zA-Z0-9_|\n?]/", "", $path),
        5
    );
    return $path;
}

class Path
{
    // Per esempio "abc|def" diventa ["abc", "def"]
    private $folders_array;
    // Per esempio "abc|def" diventa "content/abc/def"
    private $file_path_folder;

    public function build_from_query_param(?string $query_param_path)
    {
        if ( is_null($query_param_path))
        {
            $query_param_path = "";
        }
        $this->folders_array = array_filter(
            sanitize_address($query_param_path),
            function ($v){return strlen($v) > 0;}
        ) ;
        $this->file_path_folder = implode(
            "/",
            array_merge(["content"], $this->folders_array)
        );
    }

    function build_from_array(array $folders)
    {
        $this->folders_array = $folders;
        $this->file_path_folder = "content/" . implode("/", $this->folders_array);
    }

    public function as_md_file() : string
    {
        return $this->file_path_folder . "/index.md";
    }

    public function as_folder_path() : string
    {
        return $this->file_path_folder;
    }

    public function is_category() : bool
    {
        return (
            is_dir($this->file_path_folder) && !is_file($this->as_md_file())
        );
    }

    public function is_page() : bool
    {
        return is_file($this->as_md_file());
    }

    public function find_children() : array
    {
        $subcategories = [];
        $fs_iterator = new FileSystemIterator($this->file_path_folder);
        foreach ($fs_iterator as $file)
        {
            if (!is_dir(
                $file
            ))
            {
                continue;
            }
            $p = new Path();
            $p->build_from_array(
                array_merge($this->folders_array, [$file->getBaseName()])
            );
            array_push($subcategories, $p);
        }
        return $subcategories;
    }
    
    public function as_url() : string
    {
        return "/index.php?path=" . implode("|", $this->folders_array );
    }

    public function as_url_mut() : string
    {
        return "/page_edit.php?path=" . implode("|", $this->folders_array );
    }

    public function as_query_only() : string
    {
        return "path=" . implode("|", $this->folders_array );
    }

    public function get_name() : string
    {
        if (count($this->folders_array) == 0)
        {
            return "Home";
        }
        else
        {
            if ($this->is_page())
            {
                require_once "page.php";
                $p = new Page($this);
                // $p->build_from_array($this->folders_array);
                return $p->get_title();
            }
            return $this->folders_array[count($this->folders_array)-1];
        }
    }

    public function get_breadcrumb_data() : array
    {
        $ar = array();
        for ($i=0; $i<count($this->folders_array)+1; $i++)
        {
            $p = new Path();
            $p->build_from_array(
                array_slice(
                    $this->folders_array,
                    0,
                    count($this->folders_array)-$i
                )
                );
            array_push($ar, $p);
        }
        $ar = array_reverse($ar);
        return $ar;
    }

    public function create($nome, bool $is_page) : Path
    {
        if (!$this->is_page() && count($this->find_children())==0)
        {
            mkdir($this->file_path_folder . "/" . $nome);
            if ($is_page)
            {
                file_put_contents(
                    $this->file_path_folder . "/" . $nome . "/index.md",
                    "+++\ntitle=\"" . $nome . "\"\n+++"
                );
            }

            $p = new Path();
            $p->build_from_array(
                array_merge($this->folders_array, [$nome])
            );
            return $p;
        }
        else
        {
            http_response_code(403);
            echo "Impossibile creare la pagina qui";
            require "footer.php";
            die;
        }
    }
}

?>