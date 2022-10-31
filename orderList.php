<?php
require("./layout/htmlHead.php");
session_start();
echo htmlHead("Order", "style");
?>
    <body>
    <?php include("./layout/header.php"); ?>
    <?php include("deconnexionMenu.php"); ?>

    <!-- le menu des activités -->
    <?php include("themesMenu.php"); ?>

    <div id="corps">
        <h1>Commandes</h1>
        <h2>Ajouter une commande</h2>
        <p>
            <a href="addOrder.php">Formulaire d'ajout</a>
        </p>
        <h2>Liste des commandes</h2>
    </div>
    <?php include("./layout/footer.php"); ?>
    </body>
</html>