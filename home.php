<?php
require("./layout/layoutFunctions.php");
session_start();
echo htmlHead("Home", "style");
?>
    <body>
    <?php include("./layout/header.php"); ?>
    <!-- le menu principal -->
    <?= deconnexionMenu() ?>

    <!-- le menu des activités -->
    <?php include("themesMenu.php"); ?>

    <div id="corps">
        <h1><?= $_SESSION["company_name"]; ?></h1>
        <p>
            Bienvenue <strong><?= $_SESSION["firstname"]; ?> <?= $_SESSION["lastname"]; ?></strong>. <br/>
            Position : <?= $_SESSION["position"]; ?><br/>
            Vous pouvez créer des produits et des bon de commandes en allant dans les activités.
        </p>
    </div>
    <?php include("./layout/footer.php"); ?>
    </body>
</html>