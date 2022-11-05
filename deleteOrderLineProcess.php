<?php
require("./layout/htmlHead.php");
session_start();
echo htmlHead("Suppression d'une ligne de commande", "style");
$lineOrderId = intval($_POST['line_order_id']);
$orderId = intval($_POST['order_id']);
?>
    <body>
        <?php include("./layout/header.php"); ?>
        <?php include("deconnexionMenu.php"); ?>

        <!-- le menu des activités -->
        <?php include("themesMenu.php"); ?>

        <div id="corps">
            <h1>Traitement de la suppression d'une ligne de commande</h1>
            <?php
            $displayText = "";
            // On se connecte au la SGBD Mysql
            include("./utils/connexion_db.php");

            // On réalise le soft delete
            $orderLine = $bdd->prepare("
                UPDATE order_lines
                SET deleted = 1, delete_date = NOW()
                WHERE id = :line_order_id;
            ");
            $orderLine->execute([
                "line_order_id"=> $lineOrderId
            ]);

            // On met à jour le total_HT et total_TTC de la commande
            $orderTotalHT = 0;
            $orderTotalTTC = 0;
            // Pour cela on sélectionne les totaux de toutes les lignes de la commande
            $orderLines = $bdd->prepare("
                SELECT total_HT, total_TTC FROM order_lines
                WHERE order_id = :order_id
                AND deleted = 0;
            ");
            $orderLines->execute([
                "order_id"=> $orderId,
            ]);
            $dataOrderLines = $orderLines->fetchAll();
            for ($i=0; $i < count($dataOrderLines); $i++) {
                $orderTotalHT += $dataOrderLines[$i]["total_HT"];
                $orderTotalTTC += $dataOrderLines[$i]["total_TTC"];
            }

            // Finalement on met à jour la commande
            $product = $bdd->prepare("
                UPDATE orders
                SET total_HT = :order_total_HT, total_TTC = :order_total_TTC
                WHERE id = :id_order;
            ");
            $product->execute([
                "order_total_HT"=> $orderTotalHT,
                "order_total_TTC"=> $orderTotalTTC,
                "id_order"=> $orderId
            ]);

            $displayText .= "Suppression de la ligne de commande validé <br/><br/>";
            $displayText .= "L'impact sur la commande à bien été pris en compte<br/><br/>";
            $displayText .= "-----------------------------<br/>";
            $displayText .= "Numéro de commande : ".$orderId."<br/>";
            $displayText .= "total HT : ".$orderTotalHT." €<br/>";
            $displayText .= "total TTC : ".$orderTotalTTC." €<br/>";
            $displayText .= "-----------------------------<br/><br/>";
            $displayText .= "Vous pouvez voir la suppression sur la <a href='detailOrder.php?id=".$orderId."'>page de la commande n°".$orderId."</a>.<br/><br/>";

            echo $displayText;
            ?>
        </div>
        <?php include("./layout/footer.php"); ?>
    </body>
</html>