<?php
require("../layout/layoutFunctions.php");
session_start();
echo htmlHead("Formulaire de modification", "../style");
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
                    <li><a href="customerList.php">Clients</a></li>
                    <li><a href="../order/orderList.php">Commandes</a></li>
                </ul>
            </div>
        </div>

        <div id="corps">
            <h1>Traitement de la modification d'un client</h1>
            <?php
            $displayText = "";
            if (empty($_POST['id_customer'])
                    OR empty($_POST['name'])
                    OR empty($_POST['typology'])
                    OR empty($_POST['address_1'])
                    OR empty($_POST['city'])
                    OR empty($_POST['email'])
                    OR empty($_POST['phone'])) {
                $displayText .= "Vous n'avez pas saisie toutes les informations nécessaires<br/>";
                $displayText .= "Veillez, s'il vous plait, réessayer : ";
                $displayText .= "<a href='customerList.php'>Formulaire de modification d'un client</a>";
            } else {
                $idCustomer = intval($_POST['id_customer']);
                $name = htmlspecialchars($_POST['name']);
                $isCompany = $_POST['typology'] == "company" ? 1 : 0;
                $address1 = htmlspecialchars($_POST['address_1']);
                $address2 = isset($_POST['address_2']) ? htmlspecialchars($_POST['address_2']) : "";
                $cityId = intval($_POST['city']);
                $email = htmlspecialchars($_POST['email']);
                $phone = htmlspecialchars($_POST['phone']);

                //On se connecte au la SGBD Mysql
                include("../utils/connexion_db.php");

                $product = $bdd->prepare("
                    UPDATE customers
                    SET name = :name, is_company = :is_company, user_id = :user_id, address_1 = :address_1, address_2 = :address_2, 
                        city_id = :city_id, email = :email, phone = :phone, update_date = NOW()
                    WHERE id = :id_customer
                ");
                $product->execute([
                    "name"=> $name,
                    "is_company"=> $isCompany,
                    "user_id"=> $_SESSION["id"],
                    "address_1"=> $address1,
                    "address_2"=> $address2,
                    "city_id"=> $cityId,
                    "email"=> $email,
                    "phone"=> $phone,
                    "id_customer"=> $idCustomer
                ]);

                $displayText .= "Modification du client validée <br/><br/>";
                $displayText .= "Vous pouvez voir la modification sur la <a href='detailCustomer.php?id=".$idCustomer."'>page du client</a>.<br/><br/>";
            }

            echo $displayText;
            ?>
        </div>
        <?php include("../layout/footer.php"); ?>
    </body>
</html>