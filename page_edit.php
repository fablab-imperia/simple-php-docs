<?php
include "private/path_extract.php";
require_once "private/page.php";
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
        $page = new Page($p);
        $page->save_edit(
            $_POST["titolo"],
            $_POST["contenuto"]
        );
    }
}


$page = new Page($p);
$GLOBALS["page_title"] = "Modifica pagina " . $page->get_title();
require "private/header.php";
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

<section>
<details>
    <summary>Immagini</summary>
    <header>Caricamento immagini</header>
        <?php require "img.php"; ?>
</details>
</section>

<section>
    <h1>Anteprima pagina salvata:</h1>
    <?php
    echo $page->render();
    ?>
</section>


<?php
require "private/footer.php";
?>