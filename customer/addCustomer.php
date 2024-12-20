<?php
require("../layout/layoutFunctions.php");
session_start();
echo htmlHead("Formulaire d'ajout", "../style");
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

        <div id="corps">
            <h1>Ajout d'un client</h1>
            <form method="post" action="addCustomerProcess.php">
                <fieldset>
                    <legend>Information du client</legend>
                    <p>Champs sont obligatoires : *</p>
                    <table class="table_form">
                        <tr>
                            <td><label for="name">Nom*</label> </td>
                            <td><input type="text" name="name" id="name" size=10/></td>
                        </tr>
                        <tr>
                            <td><label>Typologie*</label> </td>
                            <td>
                                <input type="radio" id="company" name="typology" value="company" checked>
                                <label for="company">Entreprise</label>
                                <input type="radio" id="individual" name="typology" value="individual">
                                <label for="individual">Particulier</label>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="address_1">Adresse 1*</label> </td>
                            <td><input type=text name="address_1" id="address_1"/></td>
                        </tr>
                        <tr>
                            <td><label for="address_2">Adresse 2</label> </td>
                            <td><input type=text name="address_2" id="address_2"/></td>
                        </tr>
                        <tr>
                            <td><label for="city">Ville*</label> </td>
                            <td>
                                <input
                                    type="text"
                                    name="city_display"
                                    id="city_display"
                                    placeholder="Sélectionner une ville ou entrer le code postal..."
                                    autocomplete="off"
                                />
                                <input type="hidden" name="city_id" id="city_id" />
                                <div id="suggestions" class="suggestions"></div>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="email">E-mail*</label> </td>
                            <td><input type=email name="email" id="email"/></td>
                        </tr>
                        <tr>
                            <td><label for="phone">Téléphone*</label> </td>
                            <td><input type=phone name="phone" id="phone"/></td>
                        </tr>
                    </table>
                </fieldset>
                <p>
                    <input type="submit" value="Envoyer" class="cta_button validationButton"/>
                </p>
            </form>
        </div>
        <script src="../js/ajax/citiesAutocomplete.js"></script>
        <?php include("../layout/footer.php"); ?>
    </body>
</html>