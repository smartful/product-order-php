<?php
require("../layout/htmlHead.php");
session_start();
echo htmlHead("Commandes", "../style");
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
                SELECT id, total_HT, total_TTC FROM orders
                WHERE user_id = :user_id
                AND deleted = 0;
            ");
            $orders->execute([
                "user_id"=> $_SESSION["id"],
            ]);
            $data = $orders->fetchAll();
            ?>

            <table>
                <thead>
                    <tr>
                        <th>Numéro</th>
                        <th>Total HT</th>
                        <th>Total TTC</th>
                        <th>Détail</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for($i=0; $i<count($data); $i++) :?>
                        <tr>
                            <td><?= $data[$i]["id"]; ?></td>
                            <td><?= round($data[$i]["total_HT"], 2); ?> €</td>
                            <td><?= round($data[$i]["total_TTC"], 2); ?> €</td>
                            <td style="text-align:center;">
                                <a href="detailOrder.php?id=<?= $data[$i]["id"]; ?>">
                                    <img src="../images/details.png" />
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