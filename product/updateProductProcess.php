<?php
require("../layout/htmlHead.php");
session_start();
echo htmlHead("Formulaire de modification", "../style");
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
                    <li><a href="../customer/customerList.php">Clients</a></li>
                    <li><a href="../order/orderList.php">Commandes</a></li>
                </ul>
            </div>
        </div>

        <div id="corps">
            <h1>Traitement de la modification d'un produit</h1>
            <?php
            $displayText = "";
            if (empty($_POST['id_product'])
                    OR empty($_POST['reference'])
                    OR empty($_POST['designation'])
                    OR empty($_POST['unit_price'])
                    OR empty($_POST['rate'])) {
                $displayText .= "Vous n'avez pas saisie toutes les informations nécessaires<br/>";
                $displayText .= "Veillez, s'il vous plait, réessayer : <a href='updateProduct.php'>Formulaire de modification d'un produit</a>";
            } else {
                $idProduct = intval($_POST['id_product']);
                $reference = htmlspecialchars($_POST['reference']);
                $designation = htmlspecialchars($_POST['designation']);
                $unitPrice = htmlspecialchars($_POST['unit_price']);
                $rate = htmlspecialchars($_POST['rate']);

                //On se connecte au la SGBD Mysql
                include("../utils/connexion_db.php");

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

                $displayText .= "Modification du produit validé <br/><br/>";
                $displayText .= "Vous pouver voir la modification sur la <a href='productList.php'>page des produits</a>.<br/><br/>";
            }

            echo $displayText;
            ?>
        </div>
        <?php include("../layout/footer.php"); ?>
    </body>
</html>