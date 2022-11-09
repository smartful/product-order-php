<?php
require("../layout/htmlHead.php");
session_start();
echo htmlHead("Confirmation de suppression", "../style");
$orderId = intval($_GET["id"]);
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

        <!-- On charge le produit -->
        <?php
        //On se connecte au la SGBD Mysql
        include("../utils/connexion_db.php");

        // Récupérer les lignes de commandes
        $orderLines = $bdd->prepare("
            SELECT id, reference, designation, unit_price, rate, quantity, total_HT, total_TTC
            FROM order_lines
            WHERE order_id = :order_id
            AND deleted = 0;
        ");
        $orderLines->execute([
            "order_id"=> $orderId,
        ]);
        $data = $orderLines->fetchAll();

        // Calculer le Total HT et le Total TTC
        $totalHT = 0;
        $totalTTC = 0;
        for ($i=0; $i < count($data); $i++) {
            $totalHT += $data[$i]["total_HT"];
            $totalTTC += $data[$i]["total_TTC"];
        }
        ?>

        <div id="corps">
            <h1>Suppression d'une commande</h1>
            <p>
                Êtes vous sur de vouloir <strong>supprimer</strong> la commande suivante ?
            </p>

            <h2>Information de la commande</h2>
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
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i=0; $i < count($data); $i++) :?>
                        <tr>
                            <td><?= $data[$i]["reference"]; ?></td>
                            <td><?= $data[$i]["designation"]; ?></td>
                            <td><?= round($data[$i]["unit_price"], 2); ?> €</td>
                            <td><?= $data[$i]["quantity"]; ?></td>
                            <td><?= $data[$i]["rate"]; ?> %</td>
                            <td><?= round($data[$i]["total_HT"], 2); ?> €</td>
                            <td><?= round($data[$i]["total_TTC"], 2); ?> €</td>
                        </tr>
                    <?php endfor;?>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?= round($totalHT, 2); ?> €</td>
                        <td><?= round($totalTTC, 2); ?> €</td>
                    </tr>
                </tfoot>
            </table>

            <form method="post" action="deleteOrderProcess.php">
                <input type="hidden" name="order_id" value="<?= $orderId; ?>"/>
                <button class="button"><a href="orderList.php">Annuler</a></button>
                <input type="submit" value="Oui" class="button deleteButton"/>
            </form>
        </div>
        <?php include("../layout/footer.php"); ?>
    </body>
</html>