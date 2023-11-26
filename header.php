<?php
require_once "CONST.php";
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <title><?php echo SITE_NAME . " - " . $GLOBALS["page_title"] ?></title>
  <!-- <link href="/mini-default.min.css" rel="stylesheet" /> -->
  <link href="/simple.min.css" rel="stylesheet" />
</head>
<body>
<header>
  <h1><?php echo SITE_NAME; ?></h1>
  <nav>
    <?php
    foreach ($GLOBALS["breadcrumb"]as $i => $path)
    {
      echo "<a href=\"" . $path->as_url() . "\">" . $path->get_name() . "</a>";
    }
    ?>
  </nav>
</header>
<main>