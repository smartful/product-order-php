<?php
require("../layout/layoutFunctions.php");
session_start();
echo htmlHead("Formulaire de suppression", "../style");
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
                    <li><a href="customerList.php">Clients</a></li>
                    <li><a href="../order/orderList.php">Commandes</a></li>
                </ul>
            </div>
        </div>

        <div id="corps">
            <h1>Traitement de la suppression d'un client</h1>
            <?php
            $displayText = "";
            if (empty($_POST['customer_id'])) {
                $displayText .= "Aucun identifiant client n'est identifié<br/>";
                $displayText .= "Veillez, s'il vous plait, réessayer : <a href='customerList.php'>Page des clients</a>";
            } else {
                $customerId = intval($_POST['customer_id']);

                // On se connecte au la SGBD Mysql
                include("../utils/connexion_db.php");

                $product = $bdd->prepare("
                    UPDATE customers
                    SET user_id = :user_id, deleted = 1, delete_date = NOW()
                    WHERE id = :customer_id;
                ");
                $product->execute([
                    "user_id"=> $_SESSION["id"],
                    "customer_id"=> $customerId
                ]);

                $displayText .= "Suppression du client validé <br/><br/>";
                $displayText .= "Vous pouvez constatez la suppression sur la <a href='customerList.php'>page des clients</a>.<br/><br/>";
            }

            echo $displayText;
            ?>
        </div>
        <?php include("../layout/footer.php"); ?>
    </body>
</html>