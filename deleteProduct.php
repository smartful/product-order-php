<?php
require("./layout/htmlHead.php");
session_start();
echo htmlHead("Confirmation de suppression", "style");
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
            <h1>Suppression d'un produit</h1>
            <p>
                Êtes vous sur de vouloir <strong>supprimer</strong> le produit suivant ?
            </p>

            <h2>Information du produit</h2>
            <table>
                <tr>
                    <td><label for="reference">Référence</label> </td>
                    <td><?= $data["reference"]; ?></td>
                </tr>
                <tr>
                    <td><label for="designation">Désignation</label> </td>
                    <td><?= $data["designation"]; ?></td>
                </tr>
                <tr>
                    <td><label for="unit_price">Prix unitaire (en € HT)</label> </td>
                    <td><?= $data["unit_price"]; ?></td>
                </tr>
                <tr>
                    <td><label for="rate">Taux TVA (en %)</label> </td>
                    <td><?= $data["rate"]; ?></td>
                </tr>
            </table>

            <form method="post" action="deleteProductProcess.php">
                <input type="hidden" name="id_product" value="<?= $data["id"]; ?>"/>
                <button class="button"><a href="productList.php">Annuler</a></button>
                <input type="submit" value="Oui" class="button deleteButton"/>
            </form>
        </div>
        <?php include("./layout/footer.php"); ?>
    </body>
</html>