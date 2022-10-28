<?php
require("./layout/htmlHead.php");
session_start();
echo htmlHead("Inscription", "style");
?>
    <body>
        <?php include("./layout/header.php"); ?>
        <?php include("deconnexionMenu.php"); ?>

        <div id="corps">
            <?php
            //On se connecte au SGBD Mysql
            include("./utils/connexion_db.php"); 

            // On vérifie que c'est le bon utilisateur
            if ($_POST['email']!='' AND $_POST['pass']!='') {
                //On supprime le html qu'un utilisateur malveillant aurait pu introduire
                $email = htmlspecialchars($_POST['email']);
                $pass = htmlspecialchars($_POST['pass']);

                $verif = $bdd->prepare("SELECT password 
                                        FROM users 
                                        WHERE email= ?") or die (print_r($bdd->errorInfo()));
                $verif->execute([$email]);
                $userPass = $verif->fetch();

                if (password_verify($pass, $userPass['password'])) {
                    $verif->closeCursor();
                    $correctPassword = true;
                } else {
                    $verif->closeCursor();
                    header('Location: index.php');
                }
            } else {
                header('Location: index.php');
            }

            // On récupère les infos de l'utilisateur
            if ($correctPassword) {
                $user = $bdd->prepare("SELECT * 
                                        FROM users 
                                        WHERE email= :email AND password = :password");
                $user->execute([
                    "email" => $email,
                    "password" => $userPass['password']
                ]);
                $data = $user->fetch();
                $_SESSION["id"] = $data["id"];
                $_SESSION["email"] = $data["email"];
                $_SESSION["firstname"] = $data["firstname"];
                $_SESSION["lastname"] = $data["lastname"];
                $user->closeCursor();
                header("Location: home.php");
            } else {
                header("Location: index.php");
            }
            ?>
        </div>
        <?php include("./layout/footer.php"); ?>
    </body>
</html>