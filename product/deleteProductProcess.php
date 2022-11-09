<?php
require("../layout/htmlHead.php");
session_start();
echo htmlHead("Suppression d'un produit", "../style");
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
                    <li><a href="productList.php">Produits</a></li>
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
                    SET deleted = 1, delete_date = NOW()
                    WHERE id = :product_id;
                ");
                $product->execute([
                    "product_id"=> $productId
                ]);

                $displayText .= "Suppression du produit validé <br/><br/>";
                $displayText .= "La <a href='productList.php'>page des produits</a>.<br/><br/>";
            }

            echo $displayText;
            ?>
        </div>
        <?php include("../layout/footer.php"); ?>
    </body>
</html>