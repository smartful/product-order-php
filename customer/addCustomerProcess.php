<?php
require("../layout/htmlHead.php");
session_start();
echo htmlHead("Formulaire d'ajout", "../style");
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
            <h1>Traitement de l'ajout d'un client</h1>
            <?php
            $displayText = "";
            if (empty($_POST['name'])
                    OR empty($_POST['typology'])
                    OR empty($_POST['address_1'])
                    OR empty($_POST['city'])
                    OR empty($_POST['email'])
                    OR empty($_POST['phone'])) {
                $displayText .= "Vous n'avez pas saisie toutes les informations nécessaires<br/>";
                $displayText .= "Veillez, s'il vous plait, réessayer : ";
                $displayText .= "<a href='addCustomer.php'>Formulaire d'ajout d'un client</a>";
            } else {
                $name = htmlspecialchars($_POST['name']);
                $isCompany = $_POST['typology'] == "company" ? 1 : 0;
                $address1 = htmlspecialchars($_POST['address_1']);
                $address2 = isset($_POST['address_2']) ? htmlspecialchars($_POST['address_2']) : "";
                $cityId = intval($_POST['city']);
                $email = htmlspecialchars($_POST['email']);
                $phone = htmlspecialchars($_POST['phone']);

                // On se connecte au la SGBD Mysql
                include("../utils/connexion_db.php");

                $product = $bdd->prepare("
                    INSERT INTO customers(user_id, name, is_company, address_1, address_2, city_id, email, 
                                            phone, add_date, update_date)
                    VALUES(:user_id, :name, :is_Company, :address_1, :address_2, :city_id, :email, 
                            :phone, NOW(), NOW());
                ");
                $product->execute([
                    "user_id"=> $_SESSION["id"],
                    "name"=> $name,
                    "is_Company"=> $isCompany,
                    "address_1"=> $address1,
                    "address_2"=> $address2,
                    "city_id"=> $cityId,
                    "email"=> $email,
                    "phone"=> $phone,
                ]);

                $displayText .= "Ajout du client validé <br/><br/>";
                $displayText .= "Vous pouvez voir l'ajout sur la <a href='customerList.php'>page des clients</a>.<br/><br/>";
            }

            echo $displayText;
            ?>
        </div>
        <?php include("../layout/footer.php"); ?>
    </body>
</html>