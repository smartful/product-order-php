<?php
require("./layout/htmlHead.php");
echo htmlHead("Inscription", "style");
?>
    <body>
        <div id="en_tete"></div>
        <!-- le menu -->
        <?php include("menu.php"); ?>
        
        <?php
            //On se connecte au SGBD Mysql
            include("./utils/connection_bd.php"); 
        ?>
        
        <!-- le corps -->
        <div id="corps">
            <form method="post" action="formulaire_post.php">
                <fieldset>
                    <legend>Main Description</legend>
                    <table>
                        <tr>
                            <td><label for="first_name">Prénom</label> </td>
                            <td><input type=text name="first_name" id="first_name"/></td>
                        </tr>
                        <tr>
                            <td><label for="name">Nom</label> </td>
                            <td><input type=text name="name" id="name"/></td>
                        </tr>
                    </table>
                </fieldset>

                <p>
                    Votre mot de passe doit contenir au moins 8 caractères alphanumeriques.
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