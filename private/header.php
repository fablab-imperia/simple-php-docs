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
</head>
<body>
<header>
  <img class="fablab_logo" src="<?php echo SITE_URL; ?>/assets/fablab_logo.png" alt="FablabImperia logo">
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
</header>
<main>