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