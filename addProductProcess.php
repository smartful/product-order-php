<?php
require("./layout/htmlHead.php");
session_start();
echo htmlHead("Formulaire d'ajout", "style");
?>
    <body>
        <?php include("./layout/header.php"); ?>
        <?php include("deconnexionMenu.php"); ?>

        <!-- le menu des activités -->
        <?php include("themesMenu.php"); ?>

        <div id="corps">
            <h1>Traitement de l'ajout d'un produit</h1>
            <?php
            if (empty($_POST['reference'])
                    OR empty($_POST['designation'])
                    OR empty($_POST['unit_price'])
                    OR empty($_POST['rate'])) {
                echo "Vous n'avez pas saisie toutes les informations nécessaires<br/>";
                echo "Veillez, s'il vous plait, réessayer : <a href='addProduct.php'>Formulaire d'ajout d'un produit</a>";
            } else {
                $reference = htmlspecialchars($_POST['reference']);
                $designation = htmlspecialchars($_POST['designation']);
                $unitPrice = htmlspecialchars($_POST['unit_price']);
                $rate = htmlspecialchars($_POST['rate']);

                //On se connecte au la SGBD Mysql
                include("./utils/connexion_db.php");

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

                echo "Ajout du produit validé <br/><br/>";
                echo "Vous pouver voir l'ajout sur <a href='productList.php'>la page des produits</a>.<br/><br/>";
            }

            ?>
        </div>
        <?php include("./layout/footer.php"); ?>
    </body>
</html>