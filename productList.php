<?php
require("./layout/htmlHead.php");
session_start();
echo htmlHead("Product", "style");
?>
    <body>
        <?php include("./layout/header.php"); ?>
        <?php include("deconnexionMenu.php"); ?>

        <!-- le menu des activités -->
        <?php include("themesMenu.php"); ?>

        <div id="corps">
            <h1>Produit</h1>
            <h2>Ajouter un produit</h2>
            <p>
                <a href="addProduct.php">Formulaire d'ajout</a>
            </p>
            <h2>Liste des produits</h2>
            <?php
            //On se connecte au la SGBD Mysql
            include("./utils/connexion_db.php");

            $products = $bdd->prepare("
                SELECT id, reference, designation, unit_price, rate FROM products
                WHERE user_id = :user_id
                AND deleted = 0;
            ");
            $products->execute([
                "user_id"=> $_SESSION["id"],
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
                            <td><?= $data[$i]["unit_price"]; ?> €</td>
                            <td><?= $data[$i]["rate"]; ?> %</td>
                            <td style="text-align:center;">
                                <a href="updateProduct.php?id=<?= $data[$i]["id"]; ?>">
                                    <img src="./images/modifier.png" />
                                </a>
                            </td>
                            <td style="text-align:center;">
                                <a href="deleteProduct.php?id=<?= $data[$i]["id"]; ?>">
                                    <img src="./images/supprimer.png" />
                                </a>
                            </td>
                        </tr>
                    <?php endfor;?>
                </tbody>
            </table>
        </div>
        <?php include("./layout/footer.php"); ?>
    </body>
</html>