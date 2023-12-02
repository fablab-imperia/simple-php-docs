<?php
require_once "private/CONST.php";
require_once "private/path_extract.php";
require_once "private/image.php";
$p = new Path();
$p->build_from_query_param($_GET["path"]);
$GLOBALS["breadcrumb"] = $p->get_breadcrumb_data();

if (
    $_SERVER["REQUEST_METHOD"] == "POST"
    && isset($_POST["submit"])
    && isset($_POST["filename"])
    && isset($_POST["tipo_estensione"])
    && isset($_FILES["fileToUpload"])
    )
{
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check)
    {
        $img = new Image($p, $_POST["filename"] . "." . $_POST["tipo_estensione"]);
        $img->save_new($_FILES["fileToUpload"]["tmp_name"]);
        header("Location: " . SITE_URL . "/img.php?" . $p->as_query_only());
        exit;
    }
    else
    {
        http_response_code(403);
        echo "Dati immagine non validi";
        die;
    }
}
?>

<?php

$GLOBALS["breadcrumb"] = $p->get_breadcrumb_data();
$GLOBALS["page_title"] = "Carica immagine";
require_once "private/header.php";
?>
<h1>Carica nuova immagine</h1>
<form action="<?php echo SITE_URL . "/img_upload.php?" . $p->as_query_only(); ?>" method="post" enctype="multipart/form-data">
    <label for="fileToUpload">Immagina da caricare</label>
    <input required type="file" accept="image/png,image/jpg" name="fileToUpload" id="fileToUpload">

    <label for="img_filename_field">
        Nome file
        <br>
        <small>
            Il nome, tutto minuscolo e senza estensione, con cui verrà salvata l'immagine sul server.
            Se si inserisce un nome file di una immagine già esistente, questa verrà sovrascritta.
        </small>
    </label>
    <input type="text" name="filename" id="img_filename_field" required pattern="[a-z0-9_]+">

    <div>
        <label for="tipo_estensione">Estensione file</label>
        <select required name="tipo_estensione" id="tipo_estensione">
        <option selected default value="" >Scegli estensione</option>
        <option value="png">PNG</option>
        <option value="jpg">JPG</option>
    </select>
    </div>
    <input type="submit" value="Upload Image" name="submit">
</form>

<section>
    <header>
        <h4>Immagini già caricate</h4>
    </header>
    <?php require "img.php";?>
</section>
<?php

require_once "private/footer.php";
?>