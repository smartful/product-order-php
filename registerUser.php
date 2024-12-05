<?php
require("./layout/layoutFunctions.php");
echo htmlHead("Inscription", "style");
?>
    <body>
        <?php include("./layout/header.php"); ?>
        <!-- le menu -->
        <?php include("menu.php"); ?>

        <!-- le corps -->
        <div id="corps">
            <form method="post" action="registerFormProcess.php">
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