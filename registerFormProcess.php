<?php
require("./layout/htmlHead.php");
session_start();
echo htmlHead("Product Order", "style");
?>
    <body>
        <?php include("./layout/header.php"); ?>
        <?php include("menu.php"); ?>

        <div id="corps">
            <p>
                <?php
                if ($_POST['firstname'] != ""
                        AND $_POST['lastname'] != ""
                        AND $_POST['email'] != ""
                        AND $_POST['pass'] != ""
                        AND $_POST['confirm_pass'] != "") {
                    $firstname = htmlspecialchars($_POST['firstname']);
                    $lastname = htmlspecialchars($_POST['lastname']);
                    $email = htmlspecialchars($_POST['email']);
                    $pass = htmlspecialchars($_POST['pass']);
                    $confirmPass = htmlspecialchars($_POST['confirm_pass']);

                    if ($pass == $confirmPass) {
                        $emailRegex = "#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#";
                        $passwordRegex = "#^[a-zA-Z0-9éèùà@&]{8,15}$#";
                        if (preg_match($emailRegex, $email)
                                AND preg_match($passwordRegex, $pass)) {
                            //On se connecte au la SGBD Mysql
                            include("./utils/connexion_db.php");

                            //On ajoute les données entrée dans la table membres
                            $membres = $bdd->prepare("
                                INSERT INTO users(firstname, lastname, email, password, register_date)
                                VALUES(:prenom, :nom, :courriel, :pass, NOW());
                            ");
                            $membres->execute([
                                "prenom"=> $firstname,
                                "nom"=> $lastname,
                                "courriel"=> $email,
                                "pass"=> password_hash($pass, PASSWORD_BCRYPT)
                            ]);
                            //On met un lien vers la page perso
                            echo "Inscription validé <br/><br/>";
                            echo "Pour continuer veuillez vous rendre sur la page <strong>home</strong>, et vous connecter.<br/><br/>";
                            echo "Merci !";
                        } else {
                            echo "Il y a un problème dans les données d'inscription que vous avez saisi ! <br/>";
                            echo "Il s'agit d'un email au format invalide, ou d'un mot de passe incorrecte. <br/>";
                            echo "Pour rappel, un mot de passe doit avoir au moins 8 caractères et être composé des caractères suivant : <br/>";
                            echo "Majuscules, minuscules, chiffres et des caractères spéciaux suivant : <strong>éèùà@&</strong>";
                            echo "Veillez, s'il vous plait, réessayer : <a href='index.php'>Home</a>";
                        }
                    } else {
                        echo 'Votre mot de passe de confirmation est différent de votre mot de passe. <br/>';
                        echo "Veillez, s'il vous plait, réessayer : <a href='index.php'>Home</a>";
                    }
                } else {
                    echo "Vous n'avez pas saisie toutes les informations nécessaires<br/>";
                    echo "Veillez, s'il vous plait, réessayer : <a href='index.php'>Home</a>";
                }
                ?>
            </p>
        </div>
        <?php include("./layout/footer.php"); ?>
  </body>
</html>
  