<?php
require("../layout/htmlHead.php");
session_start();
$orderId = intval($_GET["id"]);
// On se connecte au la SGBD Mysql
include("../utils/connexion_db.php");

// On récupère les informations de l'entreprise
$company = $bdd->prepare("
    SELECT companies.*, cities.city_name, cities.postal_code
    FROM companies
    INNER JOIN cities ON cities.id = companies.city_id
    WHERE companies.id = :company_id;
");
$company->execute([
    "company_id"=> $_SESSION["company_id"],
]);
$dataCompany = $company->fetch();
$company->closeCursor();

// On récupère les informations de la commande
$order = $bdd->prepare("
    SELECT orders.total_HT, orders.total_TTC, DATE_FORMAT(orders.add_date, '%d/%m/%Y') AS add_date,
        customers.name, customers.address_1, customers.address_1, cities.city_name, cities.postal_code
    FROM orders
    INNER JOIN customers ON customers.id = orders.customer_id
    INNER JOIN cities ON cities.id = customers.city_id
    INNER JOIN users ON users.id = orders.user_id
    INNER JOIN companies ON companies.id = users.company_id
    WHERE orders.id = :order_id;
");
$order->execute([
    "order_id"=> $orderId,
]);
$dataOrder = $order->fetch();
$order->closeCursor();

// On récupère les lignes de commande
$orderLines = $bdd->prepare("
    SELECT OL.reference, OL.designation, OL.unit_price, OL.rate, OL.quantity, OL.total_HT, OL.total_TTC
    FROM order_lines AS OL
    INNER JOIN orders ON orders.id = OL.order_id
    WHERE OL.order_id = :order_id;
");
$orderLines->execute([
    "order_id"=> $orderId,
]);
$dataOrderLines = $orderLines->fetchAll();
$orderLines->closeCursor();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Commande n°<?= $orderId; ?></title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="../print.css" media="print" />
        <link rel="stylesheet" href="../style_print.css" />
    </head>
    <body>
        <?php if ($dataOrder == false): ?>
            <?= "Vous n'êtes pas autorisé à accéder à cette commande ! <br/><br/>"; ?>
            <?= "Retournez sur la <a href='orderList.php'>page des commandes</a>.<br/>"; ?>
        <?php else: ?>
            <div class="addresses_container">
                <div id="company">
                    <?= $dataCompany["name"]; ?><br/>
                    <?= $dataCompany["address_1"]; ?><br/>
                    <?php if (!empty($dataCompany["address_2"])): ?>
                        <?= $dataCompany["address_2"]; ?><br/>
                    <?php endif; ?>
                    <?= $dataCompany["postal_code"]." ".$dataCompany["city_name"]; ?><br/>
                </div>
                <div id="customer">
                    <?= $dataOrder["name"]; ?><br/>
                    <?= $dataOrder["address_1"]; ?><br/>
                    <?php if (!empty($dataOrder["address_2"])): ?>
                        <?= $dataOrder["address_2"]; ?><br/>
                    <?php endif; ?>
                    <?= $dataOrder["postal_code"]." ".$dataOrder["city_name"]; ?><br/>
                </div>
            </div>
            <h1>Commande n°<?= $orderId; ?></h1>
            <h3>Date de création : <?= $dataOrder["add_date"]; ?></h3>
            <div class="order_lines">
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
                        <?php for ($i=0; $i < count($dataOrderLines); $i++) :?>
                            <tr>
                                <td><?= $dataOrderLines[$i]["reference"]; ?></td>
                                <td><?= $dataOrderLines[$i]["designation"]; ?></td>
                                <td><?= round($dataOrderLines[$i]["unit_price"], 2); ?> €</td>
                                <td><?= $dataOrderLines[$i]["quantity"]; ?></td>
                                <td><?= $dataOrderLines[$i]["rate"]; ?> %</td>
                                <td><?= round($dataOrderLines[$i]["total_HT"], 2); ?> €</td>
                                <td><?= round($dataOrderLines[$i]["total_TTC"], 2); ?> €</td>
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
                            <td><strong><?= round($dataOrder["total_HT"], 2); ?> €</strong></td>
                            <td><strong><?= round($dataOrder["total_TTC"], 2); ?> €</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <form>
                <button id="retour"><a href="orderList.php">Retour</a></button>
                <input id="impression" name="impression" type="button" onclick="printOrder()" value="Imprimer" />
            </form>
            <footer>
                <?= $dataCompany["name"]." - siret : ".$dataCompany["siret"]."<br/>"; ?>
                <?= $dataCompany["address_1"]." ".(!empty($dataCompany["address_2"]) ? $dataCompany["address_2"] : "")." "; ?>
                <?= $dataCompany["postal_code"]." ".$dataCompany["city_name"]; ?>
            </footer>
        <?php endif; ?>
        <script type="text/javascript">
            function printOrder(){
                window.print();
            }
        </script>
    </body>
</html>