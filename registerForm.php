<?php
require("./layout/htmlHead.php");
echo htmlHead("Inscription", "style");
include("./utils/connexion_db.php");
$cities = $bdd->query('SELECT * FROM cities ORDER BY city_name;');
$dataCities = $cities->fetchAll();
$cities->closeCursor();
?>
    <body>
        <?php include("./layout/header.php"); ?>
        <!-- le menu -->
        <?php include("menu.php"); ?>

        <!-- le corps -->
        <div id="corps">
            
            <form method="post" action="registerFormProcess.php">
                <h2>Inscription de l'entreprise</h2>
                <fieldset>
                    <legend>Description Principale</legend>
                    <table class="table_form">
                        <tr>
                            <td><label for="company_name">Nom (raison social)</label> </td>
                            <td><input type=text name="company_name" id="company_name"/></td>
                        </tr>
                        <tr>
                            <td><label for="siret">SIRET (14 car.)</label> </td>
                            <td><input type=text name="siret" id="siret"/></td>
                        </tr>
                        <tr>
                            <td><label for="address_1">Adresse 1</label> </td>
                            <td><input type=text name="address_1" id="address_1"/></td>
                        </tr>
                        <tr>
                            <td><label for="address_2">Adresse 2</label> </td>
                            <td><input type=text name="address_2" id="address_2"/></td>
                        </tr>
                        <tr>
                            <td><label for="city">Ville</label> </td>
                            <td>
                                <input name="city" list="city" placeholder="Sélectionner la ville ...">
                                <datalist  name="city" id="city">
                                    <option value="" selected></option>
                                    <?php for ($i = 0; $i < count($dataCities); $i++): ?>
                                        <option value=<?= $dataCities[$i]['id']; ?>>
                                            <?= "[".$dataCities[$i]['postal_code']."] ".$dataCities[$i]['city_name']; ?>
                                        </option>
                                    <?php endfor; ?>
                                </datalist >
                            </td>
                        </tr>
                    </table>
                </fieldset>

                <h2>Inscription du gérant</h2>
                <fieldset>
                    <legend>Description Principale</legend>
                    <table>
                        <tr>
                            <td><label for="firstname">Prénom</label> </td>
                            <td><input type=text name="firstname" id="firstname"/></td>
                        </tr>
                        <tr>
                            <td><label for="lastname">Nom</label> </td>
                            <td><input type=text name="lastname" id="lastname"/></td>
                        </tr>
                        <tr>
                            <td><label for="position">Position</label> </td>
                            <td>
                                <select name="position" id="position">
                                <option value="CEO" selected>Gérant</option>
                                <option value="SALES">Commercial</option>
                                <option value="CLERK">Employé</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </fieldset>

                <p>
                    Votre mot de passe doit contenir au moins 8 caractères alphanumeriques. <br/>
                    Voici les caractères spéciaux possible : <strong>éèùà@&</strong>
                </p>

                <fieldset>
                    <legend>Vos accès</legend>
                    <table>
                        <tr>
                            <td><label for="email">Adresse E-mail</label> </td>
                            <td><input type=email name="email" id="email"/></td>
                        </tr>
                        <tr>
                            <td><label for="pass">Mot de passe</label> </td>
                            <td><input type=password name="pass" id="pass"/></td>
                        </tr>
                        <tr>
                            <td><label for="confirm_pass">Confirmation mot de passe</label></td>
                            <td><input type=password name="confirm_pass" id="confirm_pass"/></td>
                        </tr>
                    </table>
                </fieldset>

                <p>
                    <input type="submit" value="Envoyer"/>
                </p>
            </form>
        </div>
        <!-- le pied de page -->
        <?php include("./layout/footer.php"); ?>
    </body>
</html>