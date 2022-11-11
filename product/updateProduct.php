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

        <!-- On charge le produit -->
        <?php
        //On se connecte au la SGBD Mysql
        include("../utils/connexion_db.php");

        $product = $bdd->prepare("
            SELECT products.id, products.reference, products.designation, products.unit_price, products.rate 
            FROM products
            INNER JOIN users ON users.id = products.user_id
            INNER JOIN companies ON companies.id = users.company_id
            WHERE users.company_id = :company_id
            AND products.id = :product_id;
        ");
        $id = htmlspecialchars($_GET["id"]);
        $product->execute([
            "product_id"=> $id,
            "company_id"=> $_SESSION["company_id"],
        ]);
        $data = $product->fetch();
        ?>

        <div id="corps">
            <h1>Modification d'un produit</h1>
            <?php if ($data == false): ?>
                <?= "Vous n'êtes pas autorisé à accéder à ce produit ! <br/><br/>"; ?>
                <?= "Retournez sur la <a href='productList.php'>page des produits</a>.<br/>"; ?>
            <?php else: ?>
                <form method="post" action="updateProductProcess.php">
                    <input type="hidden" name="id_product" value="<?= $data["id"]; ?>"/>
                    <fieldset>
                        <legend>Information du produit</legend>
                        <table>
                            <tr>
                                <td><label for="reference">Référence</label> </td>
                                <td>
                                    <input
                                        type="text"
                                        name="reference"
                                        id="reference"
                                        size=10
                                        value="<?= $data["reference"]; ?>"
                                    />
                                </td>
                            </tr>
                            <tr>
                                <td><label for="designation">Désignation</label> </td>
                                <td>
                                    <input
                                        type="text"
                                        name="designation"
                                        id="designation"
                                        size=50
                                        value="<?= $data["designation"]; ?>"
                                    />
                                </td>
                            </tr>
                            <tr>
                                <td><label for="unit_price">Prix unitaire (en € HT)</label> </td>
                                <td>
                                    <input
                                        type="number"
                                        name="unit_price"
                                        id="unit_price"
                                        size=50
                                        step="any"
                                        value="<?= $data["unit_price"]; ?>"
                                    />
                                </td>
                            </tr>
                            <tr>
                                <td><label for="rate">Taux TVA (en %)</label> </td>
                                <td>
                                    <input
                                        type="number"
                                        name="rate"
                                        id="rate"
                                        size=10
                                        step="any"
                                        value="<?= $data["rate"]; ?>"
                                    />
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                    <p>
                        <input type="submit" value="Envoyer"/>
                    </p>
                </form>
            <?php endif; ?>
        </div>
        <?php include("../layout/footer.php"); ?>
    </body>
</html>