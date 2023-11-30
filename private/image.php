<?php
require_once "path_extract.php";
require_once "CONST.php";

class Image
{
    private Path $path;
    private string $nome;
    private string $estensione;

    function __construct(Path $path, ?string $nome_img)
    {
        if (!isset($nome_img))
        {
            http_response_code(403);
            echo "Percorso vuoto";
            die;
        }
        if (!$path->is_page())
        {
            http_response_code(403);
            echo "Il percorso non può ottenere immagini";
            die;
        }
        preg_match(
            REGEXP_IMG_NAME_EXTRACT,
            $nome_img,
            $matches
        );
        if (isset($matches) && count($matches) != 3)
        {
            http_response_code(403);
            echo "Formattazione nome img errato";
            die;
        }
        $this->path = $path;
        $this->nome = $matches[1];
        $this->estensione = $matches[2];
    }

    public function save_new($tmp_path)
    {
        move_uploaded_file(
            $tmp_path,
            $this->as_full_file_path()
        );
    }

    function as_full_file_path() : string
    {
        $img_path = $this->path->as_folder_path() . "/" . $this->nome . "." . $this->estensione;
        return $img_path;
    }

    function get_filename() : string
    {
        return $this->nome . "." . $this->estensione;
    }

    public function dump()
    {
        if ($this->estensione=="png")
        {
            $mime = "image/png";
        }
        else
        {
            $mime = "image/jpg";
        }
        
        $img_path = $this->as_full_file_path();
        if (!file_exists($img_path))
        {
            http_response_code(404);
            echo "Img non esiste ";
            die;
        }
        header("Content-Type: " . $mime);
        header("Content-Length: " . filesize($img_path));
        readfile($img_path);
    }

    public function as_url() : string
    {
        return SITE_URL . "/img.php?" . $this->path->as_query_only() . "&img=" . urlencode(
            $this->nome . "." . $this->estensione
        );
    }
}
?>