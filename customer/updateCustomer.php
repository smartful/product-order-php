<?php
require("../layout/layoutFunctions.php");
session_start();
echo htmlHead("Formulaire de modification", "../style");
// On se connecte au la SGBD Mysql
include("../utils/connexion_db.php");
$cities = $bdd->query('SELECT * FROM cities ORDER BY city_name;');
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

        <!-- On charge le produit -->
        <?php
        $customer = $bdd->prepare("
            SELECT customers.*, cities.id AS cities_id, cities.city_name, cities.postal_code
            FROM customers
            LEFT JOIN cities ON cities.id = customers.city_id
            INNER JOIN users ON users.id = customers.user_id
            INNER JOIN companies ON companies.id = users.company_id
            WHERE users.company_id = :company_id
            AND customers.id = :customer_id;
        ");
        $id = intval($_GET["id"]);
        $customer->execute([
            "customer_id"=> $id,
            "company_id"=> $_SESSION["company_id"],
        ]);
        $data = $customer->fetch(PDO::FETCH_ASSOC);
        ?>

        <div id="corps">
            <h1>Modification d'un client</h1>
            <?php if ($data == false): ?>
                <?= "Vous n'êtes pas autorisé à accéder à ce client ! <br/><br/>"; ?>
                <?= "Retournez sur la <a href='customerList.php'>page des clients</a>.<br/>"; ?>
            <?php else: ?>
                <form method="post" action="updateCustomerProcess.php">
                    <input type="hidden" name="id_customer" value="<?= $data["id"]; ?>"/>
                    <fieldset>
                        <legend>Information du produit</legend>
                        <p>Champs sont obligatoires : *</p>
                        <table class="table_form">
                            <tr>
                                <td><label for="name">Nom*</label> </td>
                                <td>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        size=10
                                        value="<?= $data["name"]; ?>"
                                    />
                                </td>
                            </tr>
                            <tr>
                                <td><label for="designation">Typologie*</label> </td>
                                <td>
                                    <input
                                        type="radio"
                                        id="company"
                                        name="typology"
                                        value="company"
                                        <?= $data["is_company"] ? "checked" : ""; ?>
                                    >
                                    <label for="company">Entreprise</label>
                                    <input
                                        type="radio"
                                        id="individual"
                                        name="typology"
                                        value="individual"
                                        <?= $data["is_company"] ? "" : "checked"; ?>
                                    >
                                    <label for="individual">Particulier</label>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="address_1">adresse 1*</label> </td>
                                <td>
                                    <input
                                        type="text"
                                        name="address_1"
                                        id="address_1"
                                        value="<?= $data["address_1"]; ?>"
                                    />
                                </td>
                            </tr>
                            <tr>
                                <td><label for="address_2">adresse 2</label> </td>
                                <td>
                                    <input
                                        type="text"
                                        name="address_2"
                                        id="address_2"
                                        value="<?= $data["address_2"]; ?>"
                                    />
                                </td>
                            </tr>
                            <tr>
                                <td><label for="rate">Ville*</label> </td>
                                <td>
                                    <input
                                        type="text"
                                        name="city_display"
                                        id="city_display"
                                        value="<?= "[".$data['postal_code']."] ".$data['city_name']; ?>"
                                        autocomplete="off"
                                    />
                                    <input type="hidden" name="city_id" id="city_id" value=<?= $data["city_id"]; ?>/>
                                    <div id="suggestions" class="suggestions"></div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="email">E-mail*</label> </td>
                                <td>
                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        value="<?= $data["email"]; ?>"
                                    />
                                </td>
                            </tr>
                            <tr>
                                <td><label for="phone">Téléphone*</label> </td>
                                <td>
                                    <input
                                        type="phone"
                                        name="phone"
                                        id="phone"
                                        value="<?= $data["phone"]; ?>"
                                    />
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                    <p>
                        <button class="cta_button"><a href="customerList.php">Annuler</a></button>
                        <input type="submit" value="Envoyer" class="cta_button validationButton"/>
                    </p>
                </form>
            <?php endif; ?>
        </div>
        <script src="../js/ajax/citiesAutocomplete.js"></script>
        <?php include("../layout/footer.php"); ?>
    </body>
</html>