<?php
require("../layout/layoutFunctions.php");
session_start();
echo htmlHead("Commandes", "../style");
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
            </ul>
        </div>
    </div>

    <div id="corps">
        <h1>Commandes</h1>
        <h2>Ajouter une commande</h2>
        <p>
            <a href="addOrder.php">Formulaire d'ajout</a>
        </p>
        <h2>Liste des commandes</h2>
        <?php
            // On se connecte au la SGBD Mysql
            include("../utils/connexion_db.php");

            $orders = $bdd->prepare("
                SELECT orders.id, orders.total_HT, orders.total_TTC, customers.name
                FROM orders
                INNER JOIN customers ON customers.id = orders.customer_id
                INNER JOIN users ON users.id = orders.user_id
                INNER JOIN companies ON companies.id = users.company_id
                WHERE users.company_id = :company_id
                AND orders.deleted = 0;
            ");
            $orders->execute([
                "company_id"=> $_SESSION["company_id"],
            ]);
            $data = $orders->fetchAll();
            ?>

            <table>
                <thead>
                    <tr>
                        <th>Numéro</th>
                        <th>Client</th>
                        <th>Total HT</th>
                        <th>Total TTC</th>
                        <th>Détail</th>
                        <th>Impression</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for($i=0; $i<count($data); $i++) :?>
                        <tr>
                            <td><?= $data[$i]["id"]; ?></td>
                            <td><?= $data[$i]["name"]; ?></td>
                            <td><?= round($data[$i]["total_HT"], 2); ?> €</td>
                            <td><?= round($data[$i]["total_TTC"], 2); ?> €</td>
                            <td style="text-align:center;">
                                <a href="detailOrder.php?id=<?= $data[$i]["id"]; ?>">
                                    <img src="../images/details.png" />
                                </a>
                            </td>
                            <td style="text-align:center;">
                                <a href="printOrder.php?id=<?= $data[$i]["id"]; ?>">
                                    <img src="../images/print.png" />
                                </a>
                            </td>
                            <td style="text-align:center;">
                                <a href="deleteOrder.php?id=<?= $data[$i]["id"]; ?>">
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