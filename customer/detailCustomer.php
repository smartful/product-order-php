<?php
require("../layout/htmlHead.php");
session_start();
echo htmlHead("Clients", "../style");
$customerId = intval($_GET["id"]);
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
                <li><a href="customerList.php">Clients</a></li>
                <li><a href="../order/orderList.php">Commandes</a></li>
            </ul>
        </div>
    </div>

    <div id="corps">
        <h1>Client</h1>
        
        <?php
            // On se connecte au la SGBD Mysql
            include("../utils/connexion_db.php");

            $customers = $bdd->prepare("
                SELECT customers.*, cities.city_name, cities.postal_code
                FROM customers
                LEFT JOIN cities ON cities.id = customers.city_id
                INNER JOIN users ON users.id = customers.user_id
                INNER JOIN companies ON companies.id = users.company_id
                WHERE users.company_id = :company_id
                AND customers.id = :customer_id
                AND customers.deleted = 0;
            ");
            $customers->execute([
                "customer_id" => $customerId,
                "company_id" => $_SESSION["company_id"],
            ]);
            $data = $customers->fetch();
            $customers->closeCursor();
        ?>

        <?php if ($data == false): ?>
            <?= "Vous n'êtes pas autorisé à accéder à ce client ! <br/><br/>"; ?>
            <?= "Retournez sur la <a href='customerList.php'>page des clients</a>.<br/>"; ?>
        <?php else: ?>
            <h2>Information sur le client : <strong> <?= $data["name"]; ?> <strong></h2>
            <table>
                <thead>
                    <tr>
                        <th>Adresse 1</th>
                        <th>Adresse 2</th>
                        <th>Ville</th>
                        <th>Code postal</th>
                        <th>E-mail</th>
                        <th>Téléphone</th>
                        <th>Modifier</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $data["address_1"]; ?></td>
                        <td><?= $data["address_2"]; ?></td>
                        <td><?= $data["city_name"]; ?></td>
                        <td><?= $data["postal_code"]; ?></td>
                        <td><?= $data["email"]; ?></td>
                        <td><?= $data["phone"]; ?></td>
                        <td style="text-align:center;">
                            <a href="updateCustomer.php?id=<?= $data["id"]; ?>">
                                <img src="../images/modifier.png" />
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <?php include("../layout/footer.php"); ?>
    </body>
</html>