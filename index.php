<?php
require("./layout/htmlHead.php");
echo htmlHead("Product Order", "style");
?>
    <body>
        <div id="en_tete"></div>
        <?php include("menu.php"); ?>

        <div id="corps">
            <p>
                Bienvenue chez Product Order. <br/>
                Vous pouvez vous inscrire
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
        </div>
        <?php include("./layout/footer.php"); ?>
    </body>
</html>