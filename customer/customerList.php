<?php
require("../layout/htmlHead.php");
session_start();
echo htmlHead("Clients", "../style");
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
                <li><a href="../order/orderList.php">Commandes</a></li>
            </ul>
        </div>
    </div>

    <div id="corps">
        <h1>Clients</h1>
        <h2>Ajouter un client</h2>
        <p>
            <a href="addCustomer.php">Formulaire d'ajout</a>
        </p>
        <h2>Liste des clients</h2>
        <?php
            // On se connecte au la SGBD Mysql
            include("../utils/connexion_db.php");

            $customers = $bdd->prepare("
                SELECT customers.id, customers.name, customers.is_company 
                FROM customers
                INNER JOIN users ON users.id = customers.user_id
                INNER JOIN companies ON companies.id = users.company_id
                WHERE users.company_id = :company_id
                AND customers.deleted = 0;
            ");
            $customers->execute([
                "company_id"=> $_SESSION["company_id"],
            ]);
            $data = $customers->fetchAll();
            ?>

            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Typologie</th>
                        <th>Détails</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for($i=0; $i<count($data); $i++) :?>
                        <tr>
                            <td><?= $data[$i]["name"]; ?></td>
                            <td><?= $data[$i]["is_company"] ? "Entreprise" : "Particulier"; ?></td>
                            <td style="text-align:center;">
                                <a href="detailCustomer.php?id=<?= $data[$i]["id"]; ?>">
                                    <img src="../images/details.png" />
                                </a>
                            </td>
                            <td style="text-align:center;">
                                <a href="deleteCustomer.php?id=<?= $data[$i]["id"]; ?>">
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