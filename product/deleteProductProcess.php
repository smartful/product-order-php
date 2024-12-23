<?php
require("../layout/layoutFunctions.php");
session_start();
echo htmlHead("Suppression d'un produit", "../style");
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
                    <li><a href="productList.php">Produits</a></li>
                    <li><a href="../customer/customerList.php">Clients</a></li>
                    <li><a href="../order/orderList.php">Commandes</a></li>
                </ul>
            </div>
        </div>

        <div id="corps">
            <h1>Traitement de la suppression d'un produit</h1>
            <?php
            $displayText = "";
            if (empty($_POST['product_id'])) {
                $displayText .= "Aucun identifiant produit n'est identifié<br/>";
                $displayText .= "Veillez, s'il vous plait, réessayer : <a href='productList.php'>Page des produits</a>";
            } else {
                $productId = intval($_POST['product_id']);

                // On se connecte au la SGBD Mysql
                include("../utils/connexion_db.php");

                $product = $bdd->prepare("
                    UPDATE products
                    SET user_id = :user_id, deleted = 1, delete_date = NOW()
                    WHERE id = :product_id;
                ");
                $product->execute([
                    "user_id"=> $_SESSION["id"],
                    "product_id"=> $productId
                ]);

                $displayText .= "Suppression du produit validé <br/><br/>";
                $displayText .= "Vous pouvez constatez la suppression sur la <a href='productList.php'>page des produits</a>.<br/><br/>";
            }

            echo $displayText;
            ?>
        </div>
        <?php include("../layout/footer.php"); ?>
    </body>
</html>