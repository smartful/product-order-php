<?php
require("./layout/htmlHead.php");
session_start();
echo htmlHead("Suppression d'une commande", "style");

?>
    <body>
        <?php include("./layout/header.php"); ?>
        <?php include("deconnexionMenu.php"); ?>

        <!-- le menu des activités -->
        <?php include("themesMenu.php"); ?>

        <div id="corps">
            <h1>Traitement de la suppression d'une commande</h1>
            <?php
            $displayText = "";
            if (empty($_POST['order_id'])) {
                $displayText .= "Aucun identifiant commande n'est identifié<br/>";
                $displayText .= "Veillez, s'il vous plait, réessayer : <a href='orderList.php'>Page des commandes</a>";
            } else {
                $orderId = intval($_POST['order_id']);
                // On se connecte au la SGBD Mysql
                include("./utils/connexion_db.php");

                $orderLine = $bdd->prepare("
                    UPDATE orders
                    SET deleted = 1, delete_date = NOW()
                    WHERE id = :order_id;
                ");
                $orderLine->execute([
                    "order_id"=> $orderId
                ]);

                $displayText .= "Suppression de la commande n°".$orderId." validé <br/><br/>";
                $displayText .= "Vous pouvez voir la suppression sur la <a href='orderList.php'>page des commandes</a>.<br/><br/>";
            }

            echo $displayText;
            ?>
        </div>
        <?php include("./layout/footer.php"); ?>
    </body>
</html>