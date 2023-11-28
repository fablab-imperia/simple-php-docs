<?php
require "private/path_extract.php";
require_once "private/image.php";

$p = new Path();
$p->build_from_query_param($_GET["path"]);
$img = new Image($p, $_GET["img"]);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["show"]))
{
    $img->dump();
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"]) && isset($_FILES["fileToUpload"]))
{
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check)
    {
        $img->save_new($_FILES["fileToUpload"]["tmp_name"]);
    }
    else
    {
        http_response_code(403);
        echo "Dati immagine non validi";
    }
}
?>

<form action="<?php echo $img->as_url(); ?>" method="post" enctype="multipart/form-data">
    <label for="fileToUpload">Immagina da caricare</label>
  <input required type="file" accept="image/png,image/jpg" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>