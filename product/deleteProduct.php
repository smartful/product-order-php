<?php
require("../layout/htmlHead.php");
session_start();
echo htmlHead("Confirmation de suppression", "../style");
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

        <!-- On charge le produit -->
        <?php
        //On se connecte au la SGBD Mysql
        include("../utils/connexion_db.php");

        $products = $bdd->prepare("
            SELECT id, reference, designation, unit_price, rate FROM products
            WHERE id = :product_id;
        ");
        $id = intval($_GET["id"]);
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
                    <td><label for="unit_price">Prix unitaire (HT)</label> </td>
                    <td><?= round($data["unit_price"], 2); ?> €</td>
                </tr>
                <tr>
                    <td><label for="rate">Taux TVA</label> </td>
                    <td><?= $data["rate"]; ?> %</td>
                </tr>
            </table>

            <form method="post" action="deleteProductProcess.php">
                <input type="hidden" name="product_id" value="<?= $data["id"]; ?>"/>
                <button class="button"><a href="productList.php">Annuler</a></button>
                <input type="submit" value="Oui" class="button deleteButton"/>
            </form>
        </div>
        <?php include("../layout/footer.php"); ?>
    </body>
</html>