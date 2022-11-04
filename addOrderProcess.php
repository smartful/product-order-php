<?php
session_start();
require("./layout/htmlHead.php");
require("./utils/constants.php");
require("./utils/calculs.php");
echo htmlHead("Formulaire d'ajout", "style");
?>
    <body>
        <?php include("./layout/header.php"); ?>
        <?php include("deconnexionMenu.php"); ?>

        <!-- le menu des activités -->
        <?php include("themesMenu.php"); ?>

        <div id="corps">
            <h1>Traitement de l'ajout d'une commande</h1>
            <?php
            $displayText = "";
            if (empty($_POST['product_id_0']) AND empty($_POST['quantity_0'])) {
                $displayText .= "Vous n'avez pas saisie toutes les informations nécessaires<br/>";
                $displayText .= "Veillez, s'il vous plait, réessayer : <a href='addOrder.php'>Formulaire d'ajout d'une commande</a>";
            } else {
                // filtrage des lignes vide
                $fillProducts = [];
                for ($i = 0; $i < MAX_ORDER_LINES; $i++) {
                    if (!empty($_POST["product_id_".$i]) AND !empty($_POST["quantity_".$i])) {
                        array_push(
                            $fillProducts,
                            [
                                "product_id" => intval($_POST["product_id_".$i]),
                                "quantity" => intval($_POST["quantity_".$i])
                            ]
                        );
                    }
                }

                // On se connecte au la SGBD Mysql
                include("./utils/connexion_db.php");

                // On crée la commande
                $order = $bdd->prepare("
                    INSERT INTO orders(user_id, total_HT, total_TTC, add_date, update_date)
                    VALUES(:user_id, :total_HT, :total_TTC, NOW(), NOW());
                ");
                $order->execute([
                    "user_id" => $_SESSION["id"],
                    "total_HT" => 0.0,
                    "total_TTC" => 0.0
                ]);
                $orderId = intval($bdd->lastInsertId());
                $displayText .= "Initialisation de la création de la commande <br/><br/>";

                // On crée les lignes de commandes
                $displayText .= "Création des lignes de commande :<br/>";
                $orderTotalHT = 0;
                $orderTotalTTC = 0;
                for ($i = 0; $i < count($fillProducts); $i++) {
                    // On sélection le produit
                    $product = $bdd->prepare("
                        SELECT id, reference, designation, unit_price, rate FROM products
                        WHERE id = :product_id;
                    ");
                    $product->execute([
                        "product_id"=> $fillProducts[$i]["product_id"],
                    ]);
                    $dataProduct = $product->fetch();

                    // On enregistre les données dans la base de donnée
                    $order = $bdd->prepare("
                        INSERT INTO order_lines(order_id, user_id, product_id, reference, designation,
                                                unit_price, rate, quantity, total_HT, total_TTC,
                                                add_date, update_date)
                        VALUES(:order_id, :user_id, :product_id, :reference, :designation,
                                :unit_price, :rate, :quantity, :total_HT, :total_TTC,
                                NOW(), NOW());
                    ");
                    $totals = getTotalsOnLine($dataProduct["unit_price"], $dataProduct["rate"], $fillProducts[$i]["quantity"]);
                    $totalHT = $totals["total_HT"];
                    $totalTTC = $totals["total_TTC"];
                    $orderTotalHT += $totalHT;
                    $orderTotalTTC += $totalTTC;
                    $order->execute([
                        "order_id" => $orderId,
                        "user_id" => $_SESSION["id"],
                        "product_id" => $dataProduct["id"],
                        "reference" => $dataProduct["reference"],
                        "designation" => $dataProduct["designation"],
                        "unit_price" => $dataProduct["unit_price"],
                        "rate" => $dataProduct["rate"],
                        "quantity" => $fillProducts[$i]["quantity"],
                        "total_HT" => $totalHT,
                        "total_TTC" => $totalTTC
                    ]);

                    $displayText .= "- <strong>[".$dataProduct["reference"]."] : ".$dataProduct["designation"]."</strong><br/>";
                    $displayText .= "quantité : ".$fillProducts[$i]["quantity"]."<br/>";
                    $displayText .= "prix unitaire : ".$dataProduct["unit_price"]."€<br/>";
                    $displayText .= "tva : ".$dataProduct["rate"]." %<br/>";
                    $displayText .= "total HT : ".$totalHT." €<br/>";
                    $displayText .= "total TTC : ".$totalTTC." €<br/><br/>";
                }

                // On renseigne le total_HT et total_TTC de la commande
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
                $displayText .= "Finalisation de la commande :<br/>";
                $displayText .= "-----------------------------<br/>";
                $displayText .= "Numéro de commande : ".$orderId."<br/>";
                $displayText .= "total HT : ".$orderTotalHT." €<br/>";
                $displayText .= "total TTC : ".$orderTotalTTC." €<br/>";
                $displayText .= "-----------------------------<br/><br/>";
                $displayText .= "Vous pouvez voir l'ajout sur la <a href='orderList.php'>page des commandes</a>.<br/><br/>";
            }

            echo $displayText;
            ?>
        </div>
        <?php include("./layout/footer.php"); ?>
    </body>
</html>