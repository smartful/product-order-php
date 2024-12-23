<?php
require("../layout/layoutFunctions.php");
session_start();
echo htmlHead("Formulaire d'ajout", "../style");
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
            <h1>Traitement de l'ajout d'un produit</h1>
            <?php
            $displayText = "";
            if (empty($_POST['reference'])
                    OR empty($_POST['designation'])
                    OR empty($_POST['unit_price'])
                    OR empty($_POST['rate'])) {
                $displayText .= "Vous n'avez pas saisie toutes les informations nécessaires<br/>";
                $displayText .= "Veillez, s'il vous plait, réessayer : ";
                $displayText .= "<a href='addProduct.php'>Formulaire d'ajout d'un produit</a>";
            } else {
                $reference = htmlspecialchars($_POST['reference']);
                $designation = htmlspecialchars($_POST['designation']);
                $unitPrice = htmlspecialchars($_POST['unit_price']);
                $rate = htmlspecialchars($_POST['rate']);

                // On se connecte au la SGBD Mysql
                include("../utils/connexion_db.php");

                $product = $bdd->prepare("
                    INSERT INTO products(user_id, reference, designation, unit_price, rate, add_date, update_date)
                    VALUES(:user_id, :reference, :designation, :unitPrice, :rate, NOW(), NOW());
                ");
                $product->execute([
                    "user_id"=> $_SESSION["id"],
                    "reference"=> $reference,
                    "designation"=> $designation,
                    "unitPrice"=> $unitPrice,
                    "rate"=> $rate
                ]);

                $displayText .= "Ajout du produit validé <br/><br/>";
                $displayText .= "Vous pouvez voir l'ajout sur la <a href='productList.php'>page des produits</a>.<br/><br/>";
            }

            echo $displayText;
            ?>
        </div>
        <?php include("../layout/footer.php"); ?>
    </body>
</html>