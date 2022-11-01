<?php
require("./layout/htmlHead.php");
session_start();
echo htmlHead("Formulaire de modification", "style");
?>
    <body>
        <?php include("./layout/header.php"); ?>
        <?php include("deconnexionMenu.php"); ?>

        <!-- le menu des activités -->
        <?php include("themesMenu.php"); ?>

        <div id="corps">
            <h1>Traitement de la modification d'un produit</h1>
            <?php
            if (empty($_POST['id_product'])
                    OR empty($_POST['reference'])
                    OR empty($_POST['designation'])
                    OR empty($_POST['unit_price'])
                    OR empty($_POST['rate'])) {
                echo "Vous n'avez pas saisie toutes les informations nécessaires<br/>";
                echo "Veillez, s'il vous plait, réessayer : <a href='updateProduct.php'>Formulaire de modification d'un produit</a>";
            } else {
                $idProduct = intval($_POST['id_product']);
                $reference = htmlspecialchars($_POST['reference']);
                $designation = htmlspecialchars($_POST['designation']);
                $unitPrice = htmlspecialchars($_POST['unit_price']);
                $rate = htmlspecialchars($_POST['rate']);

                //On se connecte au la SGBD Mysql
                include("./utils/connexion_db.php");

                $product = $bdd->prepare("
                    UPDATE products
                    SET reference = :reference, designation = :designation, unit_price = :unit_price, rate = :rate, update_date = NOW()
                    WHERE id = :id_product;
                ");
                $product->execute([
                    "reference"=> $reference,
                    "designation"=> $designation,
                    "unit_price"=> $unitPrice,
                    "rate"=> $rate,
                    "id_product"=> $idProduct
                ]);

                echo "Modification du produit validé <br/><br/>";
                echo "Vous pouver voir la modification sur <a href='productList.php'>la page des produits</a>.<br/><br/>";
            }
            ?>
        </div>
        <?php include("./layout/footer.php"); ?>
    </body>
</html>