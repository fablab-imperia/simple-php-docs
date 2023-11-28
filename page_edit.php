<?php
include "private/path_extract.php";
require_once "private/page.php";
require "private/header.php";
require_once "private/CONST.php";


$p = new Path();
$p->build_from_query_param($_GET["path"]);
$GLOBALS["breadcrumb"] = $p->get_breadcrumb_data();
if (!$p->is_page())
{
    echo "not a page";
    die;
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (isset($_POST["titolo"]) && isset($_POST["contenuto"]))
    {
        $titolo = preg_replace(REGEXP_TITLE_FILTER, "", $_POST["titolo"]);
        $contenuto = preg_replace(REGEXP_CONTENT_FILTER, "", $_POST["contenuto"]);
        file_put_contents(
            $p->as_md_file(),
            "+++\ntitle=\"" . $titolo . "\"\n+++\n" .
            $contenuto
        );
    }
}


$page = new Page($p);
?>

<?php
echo "<a href=\"" . $p->as_url() . "\">Torna in visualizzazione</a>";
?>

<section>
<form action="<?php echo $p->as_url_mut(); ?>" method="post">
    <button type="submit">Salva</button>
    <label for="titolo">Titolo</label>
    <input required maxlength=20 type="text" name="titolo" id="titolo" value="<?php echo $page->get_title();?>">
    <label for="contenuto">Contenuto</label>
    <textarea required name="contenuto" id="contenuto" cols="100" rows="25"><?php echo $page->get_content_only();?></textarea>
    <button type="submit">Salva</button>
</form>
</section>
<h1>Anteprima pagina salvata:</h1>
<?php
echo $page->render();
?>

<?php
require "private/footer.php";
?>