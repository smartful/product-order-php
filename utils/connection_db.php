<?php
//On se connecte au SGBD Mysql
try {
  $bdd = new PDO('mysql:host=localhost;dbname=productorder','root','');
} catch (Exception $error) {
  die('Error :'.$error->getMessage());
}