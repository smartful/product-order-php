<?php
require("../layout/layoutFunctions.php");
require("../utils/constants.php");
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
                    <li><a href="../product/productList.php">Produits</a></li>
                    <li><a href="../customer/customerList.php">Clients</a></li>
                    <li><a href="orderList.php">Commandes</a></li>
                </ul>
            </div>
        </div>

        <!-- On charge les produits -->
        <?php
        //On se connecte au la SGBD Mysql
        include("../utils/connexion_db.php");

        $products = $bdd->prepare("
            SELECT products.id, products.reference, products.designation, products.unit_price, products.rate 
            FROM products
            INNER JOIN users ON users.id = products.user_id
            INNER JOIN companies ON companies.id = users.company_id
            WHERE users.company_id = :company_id
            AND products.deleted = 0;
        ");
        $products->execute([
            "company_id"=> $_SESSION["company_id"],
        ]);
        $dataProduct = $products->fetchAll();
        $products->closeCursor();

        $customers = $bdd->prepare("
            SELECT customers.id, customers.name
            FROM customers
            INNER JOIN users ON users.id = customers.user_id
            INNER JOIN companies ON companies.id = users.company_id
            WHERE users.company_id = :company_id
            AND customers.deleted = 0;
        ");
        $customers->execute([
            "company_id"=> $_SESSION["company_id"],
        ]);
        $dataCustomers = $customers->fetchAll();
        $customers->closeCursor();
        ?>

        <div id="corps">
            <h1>Ajout d'une commande</h1>
            <form method="post" action="addOrderProcess.php">
                <fieldset>
                    <legend>Information sur le client</legend>
                    <table>
                        <thead>
                            <tr>
                                <th>Client</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="customer_id">
                                        <option value=""></option>
                                        <?php foreach($dataCustomers as $customers): ?>
                                            <option value="<?= $customers["id"]; ?>">
                                                <?= $customers["name"]; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </fieldset>
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