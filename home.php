<?php
require("./layout/htmlHead.php");
session_start();
echo htmlHead("Home", "style");
?>
    <body>
    <?php include("./layout/header.php"); ?>
    <?php include("deconnexionMenu.php"); ?>

    <!-- le menu des activités -->
    <?php include("themesMenu.php"); ?>

    <div id="corps">
        <h1>Product Order</h1>
    </div>
    <?php include("./layout/footer.php"); ?>
    </body>
</html>