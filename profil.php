<?php
require("./layout/htmlHead.php");
session_start();
echo htmlHead("Profil", "style");
?>
    <body>
    <?php include("./layout/header.php"); ?>
    <?php include("deconnexionMenu.php"); ?>

    <!-- le menu des activités -->
    <?php include("themesMenu.php"); ?>

    <div id="corps">
        <table >
            <tr>
                <td>Mes informations</td>
                <td>    </td>
            </tr>
            <tr>
                <td class="description">Entreprise </td>
                <td><?= htmlspecialchars($_SESSION['company_name']); ?></td>
            </tr>
            <tr>
                <td class="description">Prénom </td>
                <td><?= htmlspecialchars($_SESSION['firstname']); ?></td>
            </tr>
            <tr>
                <td class="description">Nom </td>
                <td><?= htmlspecialchars($_SESSION['lastname']); ?></td>
            </tr>
            <tr>
                <td class="description">Position </td>
                <td><?= htmlspecialchars($_SESSION['position']); ?></td>
            </tr>
            <tr>
                <td class="description">E-mail </td>
                <td><?= htmlspecialchars($_SESSION['email']); ?></td>
            </tr>
        </table>

        <br/><br/><br/><br/>

        <!-- <a href="change_password.php?id_user=<?php echo $_SESSION['id']?>">Changer de mot de passe</a> -->

        <br/><br/><br/><br/>

        <!-- <a href="erase.php?id=<?php echo $_SESSION['id']?>">Supprimer votre compte</a> -->
    </div>
    <?php include("./layout/footer.php"); ?>
    </body>
</html>