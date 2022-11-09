<?php
require("./layout/htmlHead.php");
echo htmlHead("Product Order", "style");
?>
    <body>
        <?php include("./layout/header.php"); ?>
        <?php include("menu.php"); ?>

        <div id="corps">
            <h1>Bienvenue chez Product Order</h1>
            <p>
                Si vous avez déjà un compte, vous pouvez saisir vos accès :
            </p>

            <form method="post" action="loginProcess.php">
                <fieldset>
                    <legend>Vos accès</legend>
                    <table>
                        <tr>
                            <td><label for="email">Email</label> </td>
                            <td><input type=text name="email" id="email"/></td>
                        </tr>
                        <tr>
                            <td><label for="pass">Mot de passe</label> </td>
                            <td><input type=password name="pass" id="pass"/></td>
                        </tr>
                    </table>
                </fieldset>
                <p>
                    <input type="submit" value="Envoyer"/>
                </p>
            </form>

            <p>
                Sinon vous pouvez inscrire votre entreprise : <br/>
                <button class="cta_button actionButton">
                    <a href="registerForm.php">Inscription</a>
                </button>
            </p>
        </div>
        <?php include("./layout/footer.php"); ?>
    </body>
</html>