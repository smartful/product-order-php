<?php
require("./layout/htmlHead.php");
session_start();
echo htmlHead("Suppression d'un produit", "style");
?>
    <body>
        <?php include("./layout/header.php"); ?>
        <?php include("deconnexionMenu.php"); ?>

        <!-- le menu des activités -->
        <?php include("themesMenu.php"); ?>

        <div id="corps">
            <h1>Traitement de la suppression d'un produit</h1>
            <?php
            if (empty($_POST['id_product'])) {
                echo "Aucun identifiant produit n'est identifié<br/>";
                echo "Veillez, s'il vous plait, réessayer : <a href='deleteProduct.php'>Page de suppression d'un produit</a>";
            } else {
                $idProduct = intval($_POST['id_product']);

                //On se connecte au la SGBD Mysql
                include("./utils/connexion_db.php");

                $product = $bdd->prepare("
                    UPDATE products
                    SET deleted = 1, delete_date = NOW()
                    WHERE id = :id_product;
                ");
                $product->execute([
                    "id_product"=> $idProduct
                ]);

                echo "Suppression du produit validé <br/><br/>";
                echo "La <a href='productList.php'>page des produits</a>.<br/><br/>";
            }
            ?>
        </div>
        <?php include("./layout/footer.php"); ?>
    </body>
</html>