<?php
require_once "image.php";
require_once "CONST.php";

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
        preg_replace(REGEXP_PATH_QUERYSTRING, "", $path),
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
        // $this->folders_array = array_filter(
        //     sanitize_address($query_param_path),
        //     function ($v){return strlen($v) > 0;}
        // );
        $this->build_from_array(
            sanitize_address($query_param_path),
            function ($v){return strlen($v) > 0;}
        );
        
        // $this->file_path_folder = __DIR__ . "/../" . implode(
        //     "/",
        //     array_merge(["content"], $this->folders_array)
        // );
        // echo $this->file_path_folder;
    }

    function build_from_array(array $folders)
    {
        $this->folders_array = $folders;
        $this->file_path_folder = __DIR__ . "/../" . implode(
            "/",
            array_merge(["content"], $this->folders_array)
        );
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
        return SITE_URL . "/index.php?path=" . implode("|", $this->folders_array );
    }

    public function as_url_mut() : string
    {
        return SITE_URL . "/page_edit.php?path=" . implode("|", $this->folders_array );
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

    public function create(string $nome, string $nome_cartella, bool $is_page) : Path
    {
        $p = new Path();
        $p->build_from_array(
            array_merge($this->folders_array, [$nome_cartella])
        );
        if (!$this->is_page() && !is_dir($p->as_folder_path()))
        {
            mkdir($this->file_path_folder . "/" . $nome_cartella);
            if ($is_page)
            {
                file_put_contents(
                    $this->file_path_folder . "/" . $nome_cartella . "/index.md",
                    "+++\ntitle=\"" . $nome . "\"\n+++"
                );
            }
            return $p;
        }
        else
        {
            http_response_code(403);
            echo "Impossibile creare contenuti dentro a una pagina";
            require "footer.php";
            die;
        }
    }

    public function get_images()
    {
        if (!$this->is_page())
        {
            http_response_code(403);
            echo "Il percorso non può ottenere immagini";
            die;
        }

        $images = [];
        $fs_iterator = new FileSystemIterator($this->file_path_folder);
        foreach ($fs_iterator as $file)
        {
            if (
                preg_match(
                    REGEXP_IMG_NAME_EXTRACT,
                    $file->getBaseName()
                )
            )
            {
                $img = new Image($this, $file->getBaseName());
                array_push($images, $img);
            }
        }
        return $images;
    }
} ?>