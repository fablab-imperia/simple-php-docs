<?php
require_once "CONST.php";
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <title><?php echo SITE_NAME . " - " . $GLOBALS["page_title"] ?></title>
  <!-- <link href="/mini-default.min.css" rel="stylesheet" /> -->
  <link href="<?php echo SITE_URL . "/assets/simple.css" ?>" rel="stylesheet" />
  <link href="<?php echo SITE_URL . "/assets/style.css" ?>" rel="stylesheet" />
  <script src="<?php echo SITE_URL . "/assets/lunr.js" ?>"></script>
</head>
<body data-siteurl="<?php echo SITE_URL; ?>">
<header>
  <img class="fablab_logo" src="<?php echo SITE_URL; ?>/assets/logo.png" alt="FablabImperia logo">
  <h1><?php echo SITE_NAME; ?></h1>
  <nav>
    <?php
    foreach ($GLOBALS["breadcrumb"] as $i => $path)
    {
      $cur_class = "";
      if ($i == count($GLOBALS["breadcrumb"]) -1)
      {
        $cur_class = "current";
      }
      echo "<a class=\"" . $cur_class . "\" href=\"" . $path->as_url() . "\">" . $path->get_name() . "</a>";
    }
    ?>
  </nav>

  <div>
    <label class="search_button button" for="search_button_checkbox">
      <img src="<?php echo SITE_URL;?>/assets/magnifying_glass_icon.svg" alt="">
    </label>
    
  </div>
</header>
<main>
<input type="checkbox" name="" id="search_button_checkbox">
<div class="modal">
  <div>
    <header>
      <label class="button" for="search_button_checkbox">X</label>
      <input id="id_search_wiki" type="text">
    </header>
    <main>
      <h5>Risultati:</h5> 
      <div id="content_search_results">
        
      </div>
    </main>

  </div>
  
</div>