<?php
require("../layout/layoutFunctions.php");
session_start();
echo htmlHead("Produits", "../style");
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
                    <li><a href="../customer/customerList.php">Clients</a></li>
                    <li><a href="../order/orderList.php">Commandes</a></li>
                </ul>
            </div>
        </div>

        <div id="corps">
            <h1>Produit</h1>
            <h2>Ajouter un produit</h2>
            <p>
                <a href="addProduct.php">Formulaire d'ajout</a>
            </p>
            <h2>Liste des produits</h2>
            <?php
            // On se connecte au la SGBD Mysql
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
            $data = $products->fetchAll();
            ?>

            <table>
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Désignation</th>
                        <th>Prix unitaire (HT)</th>
                        <th>Taux TVA</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for($i=0; $i<count($data); $i++) :?>
                        <tr>
                            <td><?= $data[$i]["reference"]; ?></td>
                            <td><?= $data[$i]["designation"]; ?></td>
                            <td><?= round($data[$i]["unit_price"], 2); ?> €</td>
                            <td><?= $data[$i]["rate"]; ?> %</td>
                            <td style="text-align:center;">
                                <a href="updateProduct.php?id=<?= $data[$i]["id"]; ?>">
                                    <img src="../images/modifier.png" />
                                </a>
                            </td>
                            <td style="text-align:center;">
                                <a href="deleteProduct.php?id=<?= $data[$i]["id"]; ?>">
                                    <img src="../images/supprimer.png" />
                                </a>
                            </td>
                        </tr>
                    <?php endfor;?>
                </tbody>
            </table>
        </div>
        <?php include("../layout/footer.php"); ?>
    </body>
</html>