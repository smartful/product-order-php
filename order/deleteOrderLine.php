<?php
require("../layout/htmlHead.php");
session_start();
echo htmlHead("Confirmation de suppression", "../style");
$orderId = intval($_GET["order_id"]);
$idOrderLine = intval($_GET["id"]);
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

        $orderLine = $bdd->prepare("
            SELECT id,order_id, reference, designation, unit_price, rate, quantity, total_HT, total_TTC
            FROM order_lines
            WHERE id = :id_line_order;
        ");
        $orderLine->execute([
            "id_line_order"=> $idOrderLine,
        ]);
        $data = $orderLine->fetch();
        ?>

        <div id="corps">
            <h1>Suppression d'une ligne de commande</h1>
            <p>
                Êtes vous sur de vouloir <strong>supprimer</strong> la ligne de commande suivante ?
            </p>

            <h2>Rappel de la ligne de commande</h2>
            <table>
                <tr>
                    <td><label for="reference">Référence</label> </td>
                    <td><?= $data["reference"]; ?></td>
                </tr>
                <tr>
                    <td><label for="designation">Désignation</label> </td>
                    <td><?= $data["designation"]; ?></td>
                </tr>
                <tr>
                    <td><label for="unit_price">Prix unitaire</label> </td>
                    <td><?= round($data["unit_price"], 2); ?> €</td>
                </tr>
                <tr>
                    <td><label for="rate">Taux TVA</label> </td>
                    <td><?= $data["rate"]; ?> %</td>
                </tr>
                <tr>
                    <td><label for="quantity">Quantités</label> </td>
                    <td><?= $data["quantity"]; ?></td>
                </tr>
                <tr>
                    <td><label for="total_HT">Total HT</label> </td>
                    <td><?= round($data["total_HT"], 2); ?> €</td>
                </tr>
                <tr>
                    <td><label for="total_TTC">Total TTC</label> </td>
                    <td><?= round($data["total_TTC"], 2); ?> €</td>
                </tr>
            </table>

            <form method="post" action="deleteOrderLineProcess.php">
                <input type="hidden" name="line_order_id" value="<?= $data["id"]; ?>"/>
                <input type="hidden" name="order_id" value="<?= $orderId; ?>"/>
                <button class="button"><a href="detailOrder.php?id=<?= $orderId; ?>">Annuler</a></button>
                <input type="submit" value="Oui" class="button actionButton"/>
            </form>
        </div>
        <?php include("../layout/footer.php"); ?>
    </body>
</html>