<?php
include "path_extract.php";
require_once "page.php";
require_once "header.php";


$p = new Path();
$p->build_from_query_param($_GET["path"]);
if (!$p->is_page())
{
    echo "not a page";
    die;
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (isset($_POST["titolo"]) && isset($_POST["contenuto"]))
    {
        $titolo = preg_replace("/[^a-zA-Z0-9 ]/", "", $_POST["titolo"]);
        $contenuto = preg_replace("/[^a-zA-Z0-9_\"` '\\-\n|]/", "", $_POST["contenuto"]);
        file_put_contents(
            $p->as_md_file(),
            "+++\ntitolo=\"" . $titolo . "\"\n+++\n" .
            $contenuto
        );
    }
}


$page = new Page($p);
?>

<form action="<?php echo $p->as_url_mut(); ?>" method="post">
    <label for="titolo">Titolo</label>
    <input required maxlength=20 type="text" name="titolo" id="titolo">
    <label for="contenuto">Contenuto</label>
    <textarea required name="contenuto" id="contenuto" cols="100" rows="10"><?php echo $page->get_content_only();?></textarea>
    <button type="submit">Salva</button>
</form>

<?php
echo $page->render();
?>

<?php
require "footer.php";
?>