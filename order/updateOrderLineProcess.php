<?php
session_start();
require("../layout/layoutFunctions.php");
require("../utils/calculs.php");
echo htmlHead("Formulaire de modification", "../style");
?>
    <body>
        <?php include("../layout/header.php"); ?>
        <!-- le menu principal -->
        <?= deconnexionMenu("../") ?>

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
            <h1>Traitement de la modification d'une ligne de commande</h1>
            <?php
            $displayText = "";
            if (empty($_POST['product_id']) AND empty($_POST['quantity'])) {
                $displayText .= "Vous n'avez pas saisie toutes les informations nécessaires<br/>";
                $displayText .= "Veillez, s'il vous plait, réessayer : <a href='../product/addProduct.php'>Formulaire d'ajout d'un produit</a>";
            } else {
                $orderId = intval($_POST['order_id']);
                $lineOrderId = intval($_POST['line_order_id']);
                $productId = intval($_POST['product_id']);
                $quantity = intval($_POST['quantity']);

                // On se connecte au la SGBD Mysql
                include("../utils/connexion_db.php");

                // On charge le produit
                $product = $bdd->prepare("
                    SELECT id, reference, designation, unit_price, rate FROM products
                    WHERE id = :product_id;
                ");
                $product->execute([
                    "product_id" => $productId,
                ]);
                $dataProduct = $product->fetch();

                // Mise à jour de la ligne de commande
                $orderLine = $bdd->prepare("
                    UPDATE order_lines
                    SET user_id = :user_id,
                        product_id = :product_id,
                        reference = :reference,
                        designation = :designation,
                        unit_price = :unit_price,
                        rate = :rate,
                        quantity = :quantity,
                        total_HT =:total_HT,
                        total_TTC = :total_TTC,
                        update_date = NOW()
                    WHERE id = :id_line_order;
                ");
                $totals = getTotalsOnLine($dataProduct["unit_price"], $dataProduct["rate"], $quantity);
                $totalHT = $totals["total_HT"];
                $totalTTC = $totals["total_TTC"];
                $orderLine->execute([
                    "id_line_order"=> $lineOrderId,
                    "user_id"=> $_SESSION["id"],
                    "product_id"=> $productId,
                    "reference"=> $dataProduct["reference"],
                    "designation"=> $dataProduct["designation"],
                    "unit_price"=> $dataProduct["unit_price"],
                    "rate"=> $dataProduct["rate"],
                    "quantity"=> $quantity,
                    "total_HT" => $totalHT,
                    "total_TTC" => $totalTTC
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
                    SET total_HT = :order_total_HT, total_TTC = :order_total_TTC, user_id = :user_id, update_date = NOW()
                    WHERE id = :id_order;
                ");
                $product->execute([
                    "order_total_HT"=> $orderTotalHT,
                    "order_total_TTC"=> $orderTotalTTC,
                    "user_id"=> $_SESSION["id"],
                    "id_order"=> $orderId
                ]);

                $displayText .= "Modification de la ligne de commande validé <br/><br/>";
                $displayText .= "-----------------------------<br/>";
                $displayText .= "Produit : [".$dataProduct["reference"]."] ".$dataProduct["designation"]."<br/>";
                $displayText .= "Prix unitaire : ".round($dataProduct["unit_price"], 2)." €<br/>";
                $displayText .= "Quantité : ".$quantity." €<br/>";
                $displayText .= "Taux TVA : ".$dataProduct["rate"]." %<br/>";
                $displayText .= "total HT : ".round($totalHT, 2)." €<br/>";
                $displayText .= "total TTC : ".round($totalTTC, 2)." €<br/>";
                $displayText .= "-----------------------------<br/><br/>";
                $displayText .= "L'impact sur la commande à bien été pris en compte<br/><br/>";
                $displayText .= "-----------------------------<br/>";
                $displayText .= "Numéro de commande : ".$orderId."<br/>";
                $displayText .= "total HT : ".round($orderTotalHT, 2)." €<br/>";
                $displayText .= "total TTC : ".round($orderTotalTTC, 2)." €<br/>";
                $displayText .= "-----------------------------<br/><br/>";
                $displayText .= "Vous pouvez voir la modification sur la <a href='detailOrder.php?id=".$orderId."'>page de la commande n°".$orderId."</a>.<br/><br/>";
            }

            echo $displayText;
            ?>
        </div>
        <?php include("../layout/footer.php"); ?>
    </body>
</html>