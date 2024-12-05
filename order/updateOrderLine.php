<?php
require("../layout/layoutFunctions.php");
session_start();
echo htmlHead("Formulaire de modification", "../style");
$lineOrderId = intval($_GET["id"]);
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
                    <li><a href="../product/productList.php">Produits</a></li>
                    <li><a href="../customer/customerList.php">Clients</a></li>
                    <li><a href="orderList.php">Commandes</a></li>
                </ul>
            </div>
        </div>

        <!-- On charge la ligne de commande et le produit -->
        <?php
        //On se connecte au la SGBD Mysql
        include("../utils/connexion_db.php");

        // On charge la ligne de commande
        $lineOrder = $bdd->prepare("
            SELECT OL.id, OL.order_id, OL.product_id, OL.reference, OL.designation, OL.quantity 
            FROM order_lines AS OL
            INNER JOIN users ON users.id = OL.user_id
            INNER JOIN companies ON companies.id = users.company_id
            WHERE users.company_id = :company_id
            AND OL.id = :line_order_id;
        ");
        $lineOrder->execute([
            "line_order_id" => $lineOrderId,
            "company_id"=> $_SESSION["company_id"],
        ]);
        $dataLineOrder = $lineOrder->fetch();
        ?>

        <div id="corps">
            <h1>Modification d'une ligne de commande</h1>
            <?php if ($dataLineOrder == false): ?>
                <?= "Vous n'êtes pas autorisé à accéder à cette commande ! <br/><br/>"; ?>
                <?= "Retournez sur la <a href='orderList.php'>page des commandes</a>.<br/>"; ?>
            <?php else: ?>
                <?php
                    // On charge les produits
                        $products = $bdd->prepare("
                        SELECT products.id, products.reference, products.designation, products.unit_price, products.rate 
                        FROM products
                        INNER JOIN users ON users.id = products.user_id
                        INNER JOIN companies ON companies.id = users.company_id
                        WHERE products.deleted = 0
                        AND products.id <> :product_id
                        AND users.company_id = :company_id;
                    ");
                    $products->execute([
                        "product_id" => $dataLineOrder["product_id"],
                        "company_id"=> $_SESSION["company_id"],
                    ]);
                    $dataProduct = $products->fetchAll();
                ?>
                <form method="post" action="updateOrderLineProcess.php">
                    <input type="hidden" name="order_id" value="<?= $dataLineOrder["order_id"]; ?>"/>
                    <input type="hidden" name="line_order_id" value="<?= $dataLineOrder["id"]; ?>"/>
                    <fieldset>
                    <legend>Information de la commande</legend>
                        <table>
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Quantité</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="product_id">
                                            <option value="<?= $dataLineOrder["product_id"]; ?>">
                                                [<?= $dataLineOrder["reference"]; ?>] <?= $dataLineOrder["designation"]; ?>
                                            </option>
                                            <?php foreach ($dataProduct as $product): ?>
                                                <option value="<?= $product["id"]; ?>">
                                                    [<?= $product["reference"]; ?>] <?= $product["designation"]; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="quantity" size=10 value="<?= $dataLineOrder["quantity"]; ?>"/>
                                    </td>
                                </tr>
                            </tbody>
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