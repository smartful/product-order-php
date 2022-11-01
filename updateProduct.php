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

        <!-- On charge le produit -->
        <?php
        //On se connecte au la SGBD Mysql
        include("./utils/connexion_db.php");

        $products = $bdd->prepare("
            SELECT id, reference, designation, unit_price, rate FROM products
            WHERE id = :product_id;
        ");
        $id = htmlspecialchars($_GET["id"]);
        $products->execute([
            "product_id"=> $id,
        ]);
        $data = $products->fetch();
        ?>

        <div id="corps">
            <h1>Modification d'un produit</h1>
            <form method="post" action="updateProductProcess.php">
                <input type="hidden" name="id_product" value="<?= $data["id"]; ?>"/>
                <fieldset>
                    <legend>Information du produit</legend>
                    <table>
                        <tr>
                            <td><label for="reference">Référence</label> </td>
                            <td><input type="text" name="reference" id="reference" size=10 value="<?= $data["reference"]; ?>"/></td>
                        </tr>
                        <tr>
                            <td><label for="designation">Désignation</label> </td>
                            <td><input type="text" name="designation" id="designation" size=50 value="<?= $data["designation"]; ?>"/></td>
                        </tr>
                        <tr>
                            <td><label for="unit_price">Prix unitaire (en € HT)</label> </td>
                            <td><input type="number"  name="unit_price" id="unit_price" size=50 step="any" value="<?= $data["unit_price"]; ?>"/></td>
                        </tr>
                        <tr>
                            <td><label for="rate">Taux TVA (en %)</label> </td>
                            <td><input type="number" name="rate" id="rate" size=10 step="any" value="<?= $data["rate"]; ?>"/></td>
                        </tr>
                    </table>
                </fieldset>
                <p>
                    <input type="submit" value="Envoyer"/>
                </p>
            </form>
        </div>
        <?php include("./layout/footer.php"); ?>
    </body>
</html>