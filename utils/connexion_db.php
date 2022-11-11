<?php
//On se connecte au SGBD Mysql
try {
    $bdd = new PDO('mysql:host=localhost;dbname=productorder','root','');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $error) {
    die('Error :'.$error->getMessage());
}