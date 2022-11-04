<?php
require("./layout/htmlHead.php");
session_start();
echo htmlHead("Formulaire de modification", "style");
$lineOrderId = htmlspecialchars($_GET["id"]);
?>
    <body>
        <?php include("./layout/header.php"); ?>
        <?php include("deconnexionMenu.php"); ?>

        <!-- le menu des activités -->
        <?php include("themesMenu.php"); ?>

        <!-- On charge la ligne de commande et le produit -->
        <?php
        //On se connecte au la SGBD Mysql
        include("./utils/connexion_db.php");

        // On charge la ligne de commande
        $lineOrder = $bdd->prepare("
            SELECT id, order_id, product_id, reference, designation, quantity FROM order_lines
            WHERE id = :line_order_id
            AND deleted = 0;
        ");
        $lineOrder->execute([
            "line_order_id" => $lineOrderId,
        ]);
        $dataLineOrder = $lineOrder->fetch();

        // On charge les produits
        $products = $bdd->prepare("
            SELECT id, reference, designation, unit_price, rate FROM products
            WHERE deleted = 0
            AND id <> :product_id;
        ");
        $products->execute([
            "product_id" => $dataLineOrder["product_id"],
        ]);
        $dataProduct = $products->fetchAll();
        ?>

        <div id="corps">
            <h1>Modification d'un produit</h1>
            <form method="post" action="updateOrderLineProcess.php">
                <input type="hidden" name="order_id" value="<?= $dataLineOrder["order_id"]; ?>"/>
                <input type="hidden" name="line_order_id" value="<?= $dataLineOrder["id"]; ?>"/>
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
        </div>
        <?php include("./layout/footer.php"); ?>
    </body>
</html>