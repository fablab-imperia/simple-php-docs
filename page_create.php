<?php
include "private/path_extract.php";
require_once "private/category.php";
require_once "private/page.php";
require_once "private/CONST.php";

$GLOBALS["page_title"] = "Creazione pagina";

$p = new Path();
$p->build_from_query_param($_GET["path"]);
$GLOBALS["breadcrumb"] = $p->get_breadcrumb_data();

if (isset($_POST["nome"]) && isset($_POST["tipo_creazione"]))
{
    $nome = $_POST["nome"];
    $tipo = $_POST["tipo_creazione"];
    $nome_cartella = preg_replace(
        "/[^a-zA-Z0-9]/",
        "_",
        strtolower($nome)
    );
    if (strlen($nome_cartella)==0 || (
        $tipo != "pagina" && $tipo != "sottocategoria"
    ))
    {
        http_response_code(403);
        echo "Campi non validi";
        require "footer.php";
        die;
    }

    $new_page = $p->create($nome, $nome_cartella, $tipo == "pagina");
    header("Location: " . $new_page->as_url());
}

require "private/header.php";
?>
<h1>Crea pagina o sottocategoria</h1>

<form action="<?php echo SITE_URL . "/page_create.php?" . $p->as_query_only(); ?>" method="post">
    <input pattern="[a-zA-Z 0-9]+" type="text" required name="nome">
    <select name="tipo_creazione" required>
        <option value="pagina">Pagina</option>
        <option value="sottocategoria">Sottocategoria</option>
    </select>
    <button type="submit">Crea</button>
</form>