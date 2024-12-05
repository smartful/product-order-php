<?php
require("../layout/layoutFunctions.php");
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
                    <li><a href="../customer/customerList.php">Clients</a></li>
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
            SELECT OL.id, OL.reference, OL.designation, OL.unit_price, OL.rate, OL.quantity, OL.total_HT, OL.total_TTC
            FROM order_lines AS OL
            INNER JOIN users ON users.id = OL.user_id
            INNER JOIN companies ON companies.id = users.company_id
            WHERE users.company_id = :company_id
            AND OL.order_id = :order_id
            AND OL.deleted = 0;
        ");
        $orderLines->execute([
            "order_id"=> $orderId,
            "company_id"=> $_SESSION["company_id"],
        ]);
        $data = $orderLines->fetchAll();
        ?>

        <div id="corps">
            <h1>Suppression d'une commande</h1>
            <?php if ($data == false): ?>
                <?= "Vous n'êtes pas autorisé à accéder à cette commande ! <br/><br/>"; ?>
                <?= "Retournez sur la <a href='orderList.php'>page des commandes</a>.<br/>"; ?>
            <?php else: ?>
                <?php
                    // Calculer le Total HT et le Total TTC
                    $totalHT = 0;
                    $totalTTC = 0;
                    for ($i=0; $i < count($data); $i++) {
                        $totalHT += $data[$i]["total_HT"];
                        $totalTTC += $data[$i]["total_TTC"];
                    }
                ?>
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
                    <input type="submit" value="Oui" class="button actionButton"/>
                </form>
            <?php endif; ?>
        </div>
        <?php include("../layout/footer.php"); ?>
    </body>
</html>