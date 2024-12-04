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
                    <div class="login-form">
                        <div class="form-row">
                            <label for="email">Email</label>
                            <input type=text name="email" id="email"/>
                        </div>

                        <div class="form-row">
                            <label for="pass">Mot de passe</label>
                            <input type=password name="pass" id="pass"/>
                        </div>
                    </div>
                </fieldset>
                <p>
                    <input type="submit" value="Envoyer" class="cta_button validationButton"/>
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