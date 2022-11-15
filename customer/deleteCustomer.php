<?php
require("../layout/htmlHead.php");
session_start();
echo htmlHead("Confirmation de suppression", "../style");
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

        <!-- On charge le client -->
        <?php
        //On se connecte au la SGBD Mysql
        include("../utils/connexion_db.php");

        $customers = $bdd->prepare("
            SELECT customers.*, cities.city_name, cities.postal_code
            FROM customers
            LEFT JOIN cities ON cities.id = customers.city_id
            INNER JOIN users ON users.id = customers.user_id
            INNER JOIN companies ON companies.id = users.company_id
            WHERE users.company_id = :company_id
            AND customers.id = :customer_id;
        ");
        $id = intval($_GET["id"]);
        $customers->execute([
            "customer_id"=> $id,
            "company_id"=> $_SESSION["company_id"],
        ]);
        $data = $customers->fetch();
        ?>

        <div id="corps">
            <h1>Suppression d'un client</h1>
            <?php if ($data == false): ?>
                <?= "Vous n'êtes pas autorisé à accéder à ce client ! <br/><br/>"; ?>
                <?= "Retournez sur la <a href='productList.php'>page des clients</a>.<br/>"; ?>
            <?php else: ?>
                <p>
                    Êtes vous sur de vouloir <strong>supprimer</strong> le client suivant ?
                </p>

                <h2>Information du client</h2>
                <table>
                    <tr>
                        <td>Nom</td>
                        <td><?= $data["name"]; ?></td>
                    </tr>
                    <tr>
                        <td>Typologie</td>
                        <td><?= $data["is_company"] ? "Entreprise" : "Particulier"; ?></td>
                    </tr>
                    <tr>
                        <td>Addresse 1</td>
                        <td><?= $data["address_1"]; ?></td>
                    </tr>
                    <tr>
                        <td>Addresse 2</td>
                        <td><?= $data["address_2"]; ?></td>
                    </tr>
                    <tr>
                        <td>Ville</td>
                        <td><?= $data["city_name"]; ?></td>
                    </tr>
                    <tr>
                        <td>Code Postal</td>
                        <td><?= $data["postal_code"]; ?></td>
                    </tr>
                    <tr>
                        <td>E-mail</td>
                        <td><?= $data["email"]; ?></td>
                    </tr>
                    <tr>
                        <td>Téléphone</td>
                        <td><?= $data["phone"]; ?></td>
                    </tr>
                </table>

                <form method="post" action="deleteCustomerProcess.php">
                    <input type="hidden" name="customer_id" value="<?= $data["id"]; ?>"/>
                    <button class="button"><a href="customerList.php">Annuler</a></button>
                    <input type="submit" value="Oui" class="button actionButton"/>
                </form>
            <?php endif; ?>
        </div>
        <?php include("../layout/footer.php"); ?>
    </body>
</html>