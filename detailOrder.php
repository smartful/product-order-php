<?php
require("./layout/htmlHead.php");
session_start();
echo htmlHead("Lignes d'une Commande", "style");
$orderId = htmlspecialchars($_GET["id"]);
?>
    <body>
    <?php include("./layout/header.php"); ?>
    <?php include("deconnexionMenu.php"); ?>

    <!-- le menu des activités -->
    <?php include("themesMenu.php"); ?>

    <div id="corps">
        <h1>Commandes</h1>
        <h2>Lignes de la commande n° <?= $orderId; ?></h2>
        <?php
            // On se connecte au la SGBD Mysql
            include("./utils/connexion_db.php");

            $orderLines = $bdd->prepare("
                SELECT id, reference, designation, unit_price, rate, quantity, total_HT, total_TTC FROM order_lines
                WHERE order_id = :order_id
                AND deleted = 0;
            ");
            $orderLines->execute([
                "order_id"=> $orderId,
            ]);
            $data = $orderLines->fetchAll();
            ?>

            <table>
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Désignation</th>
                        <th>Prix unitaire</th>
                        <th>Quantité</th>
                        <th>TVA</th>
                        <th>Total HT</th>
                        <th>Total TTC</th>
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
                            <td><?= $data[$i]["quantity"]; ?></td>
                            <td><?= $data[$i]["rate"]; ?> %</td>
                            <td><?= $data[$i]["total_HT"]; ?> €</td>
                            <td><?= $data[$i]["total_TTC"]; ?> €</td>
                            <td style="text-align:center;">
                                <a href="updateOrderLines.php?id=<?= $data[$i]["id"]; ?>">
                                    <img src="./images/modifier.png" />
                                </a>
                            </td>
                            <td style="text-align:center;">
                                <a href="deleteOrderLines.php?id=<?= $data[$i]["id"]; ?>">
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