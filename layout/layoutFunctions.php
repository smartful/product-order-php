<?php

function htmlHead(string $title, string $cssFileName): string {
  return <<<EOT
<!DOCTYPE html>
<html>
  <head>
    <title>$title</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="$cssFileName.css" />
  </head>
EOT;
}

function deconnexionMenu(string $filePosition = ""): string {
  return <<<EOT
<div id="menu">
    <div class="element_menu">
      <h3>Product Order</h3>
      <a href="{$filePosition}home.php">Home</a>
      <a href="{$filePosition}profil.php">Profil</a>
      <a href="{$filePosition}deconnexion.php" class="deconnexion_btn">Deconnexion</a>
    </div>
</div>
EOT;
}