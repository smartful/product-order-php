<?php
require("../layout/htmlHead.php");
require("../utils/constants.php");
session_start();
echo htmlHead("Formulaire d'ajout", "../style");
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
                    <li><a href="../product/productList.php">Produits</a></li>
                    <li><a href="orderList.php">Commandes</a></li>
                </ul>
            </div>
        </div>

        <!-- On charge les produits -->
        <?php
        //On se connecte au la SGBD Mysql
        include("../utils/connexion_db.php");

        $products = $bdd->prepare("
            SELECT id, reference, designation, unit_price, rate FROM products
            WHERE deleted = 0;
        ");
        $products->execute();
        $dataProduct = $products->fetchAll();
        ?>

        <div id="corps">
            <h1>Ajout d'une commande</h1>
            <form method="post" action="addOrderProcess.php">
                <fieldset>
                    <legend>Information du de la commande</legend>
                    <table>
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Quantité</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($i = 0; $i < MAX_ORDER_LINES; $i++): ?>
                                <tr>
                                    <td>
                                        <select name="product_id_<?= $i; ?>">
                                            <option value=""></option>
                                            <?php foreach($dataProduct as $product): ?>
                                                <option value="<?= $product["id"]; ?>">
                                                    [<?= $product["reference"]; ?>] <?= $product["designation"]; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td><input type="number" name="quantity_<?= $i; ?>" size=10/></td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </fieldset>
                <p>
                    <input type="submit" value="Envoyer"/>
                </p>
            </form>
        </div>
        <?php include("../layout/footer.php"); ?>
    </body>
</html>