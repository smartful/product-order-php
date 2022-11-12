<?php
require("../layout/htmlHead.php");
session_start();
echo htmlHead("Suppression d'une ligne de commande", "../style");
$lineOrderId = intval($_POST['line_order_id']);
$orderId = intval($_POST['order_id']);
?>
    <body>
        <?php include("../layout/header.php"); ?>
        <!-- le menu principal -->
        <div id="menu">
            <div class="element_menu">
                <h3>Product Order</h3>
                <ul>
                    <li><a href="../home.php">Home</a></li>
                    <li><a href="../profil.php">Profil</a></li>
                    <li><a href="../deconnexion.php" class="deconnexion_btn">Deconnexion</a></li>
                </ul>
            </div>
        </div>

        <!-- le menu des activités -->
        <div id="menu_right">
            <div class="element_menu">
                <h3>Activités</h3>
                <ul>
                    <li><a href="../product/productList.php">Produits</a></li>
                    <li><a href="../customer/customerList.php">Clients</a></li>
                    <li><a href="orderList.php">Commandes</a></li>
                </ul>
            </div>
        </div>

        <div id="corps">
            <h1>Traitement de la suppression d'une ligne de commande</h1>
            <?php
            $displayText = "";
            // On se connecte au la SGBD Mysql
            include("../utils/connexion_db.php");

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
            $displayText .= "total HT : ".round($orderTotalHT, 2)." €<br/>";
            $displayText .= "total TTC : ".round($orderTotalTTC, 2)." €<br/>";
            $displayText .= "-----------------------------<br/><br/>";
            $displayText .= "Vous pouvez voir la suppression sur la <a href='detailOrder.php?id=".$orderId."'>page de la commande n°".$orderId."</a>.<br/><br/>";

            echo $displayText;
            ?>
        </div>
        <?php include("../layout/footer.php"); ?>
    </body>
</html>