<?php
require("./layout/layoutFunctions.php");
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
                    <div class="group-form">
                        <div class="form-row">
                            <label for="company_name">Nom (raison social)</label>
                            <input type=text name="company_name" id="company_name"/>
                        </div>
                        <div class="form-row">
                            <label for="siret">SIRET (14 car.)</label>
                            <input type=text name="siret" id="siret"/>
                        </div>
                        <div class="form-row">
                            <label for="address_1">Adresse 1</label>
                            <input type=text name="address_1" id="address_1"/>
                        </div>
                        <div class="form-row">
                            <label for="address_2">Adresse 2</label>
                            <input type=text name="address_2" id="address_2"/>
                        </div>
                        <div class="form-row">
                            <label for="city">Ville</label>
                            <input name="city" list="city" placeholder="Sélectionner la ville ...">
                            <datalist  name="city" id="city">
                                <option value="" selected></option>
                                <?php for ($i = 0; $i < count($dataCities); $i++): ?>
                                    <option value=<?= $dataCities[$i]['id']; ?>>
                                        <?= "[".$dataCities[$i]['postal_code']."] ".$dataCities[$i]['city_name']; ?>
                                    </option>
                                <?php endfor; ?>
                            </datalist >
                        </div>
                    </div>
                </fieldset>

                <h2>Inscription du gérant</h2>
                <fieldset>
                    <legend>Description de l'utilisateur</legend>
                    <div class="group-form">
                        <div class="form-row">
                            <label for="firstname">Prénom</label>
                            <input type=text name="firstname" id="firstname"/>
                        </div>
                        <div class="form-row">
                            <label for="lastname">Nom</label>
                            <input type=text name="lastname" id="lastname"/>
                        </div>
                        <div class="form-row">
                            <label for="position">Position</label>
                            <select name="position" id="position">
                                <option value="CEO" selected>Gérant</option>
                                <option value="SALES">Commercial</option>
                                <option value="CLERK">Employé</option>
                            </select>
                        </div>
                    </div>
                </fieldset>

                <p>
                    Votre mot de passe doit contenir au moins 8 caractères alphanumeriques. <br/>
                    Voici les caractères spéciaux possible : <strong>éèùà@&</strong>
                </p>

                <fieldset>
                    <legend>Vos accès</legend>
                    <div class="group-form">
                        <div class="form-row">
                            <label for="email">Adresse E-mail</label>
                            <input type=email name="email" id="email"/>
                        </div>
                        <div class="form-row">
                            <label for="pass">Mot de passe</label>
                            <input type=password name="pass" id="pass"/>
                        </div>
                        <div class="form-row">
                            <label for="confirm_pass">Confirmation mot de passe</label>
                            <input type=password name="confirm_pass" id="confirm_pass"/>
                        </div>
                    </div>
                </fieldset>

                <p>
                    <input type="submit" value="Envoyer" class="cta_button validationButton"/>
                </p>
            </form>
        </div>
        <!-- le pied de page -->
        <?php include("./layout/footer.php"); ?>
    </body>
</html>