<?php
require("./layout/layoutFunctions.php");
session_start();
echo htmlHead("Product Order", "style");
?>
    <body>
        <?php include("./layout/header.php"); ?>
        <?php include("menu.php"); ?>

        <div id="corps">
            <p>
                <?php
                $displayText = "";
                if ($_POST['company_name'] != ""
                        AND $_POST['siret'] != ""
                        AND $_POST['address_1'] != ""
                        AND $_POST['city'] != ""
                        AND $_POST['firstname'] != ""
                        AND $_POST['lastname'] != ""
                        AND $_POST['position'] != ""
                        AND $_POST['email'] != ""
                        AND $_POST['pass'] != ""
                        AND $_POST['confirm_pass'] != "") {
                    $companyName = htmlspecialchars($_POST['company_name']);
                    $siret = htmlspecialchars($_POST['siret']);
                    $address1 = htmlspecialchars($_POST['address_1']);
                    $address2 = isset($_POST['address_2']) ? htmlspecialchars($_POST['address_2']) : "";
                    $cityId = intval($_POST['city']);
                    $firstname = htmlspecialchars($_POST['firstname']);
                    $lastname = htmlspecialchars($_POST['lastname']);
                    $position = htmlspecialchars($_POST['position']);
                    $email = htmlspecialchars($_POST['email']);
                    $pass = htmlspecialchars($_POST['pass']);
                    $confirmPass = htmlspecialchars($_POST['confirm_pass']);

                    if ($pass == $confirmPass) {
                        $emailRegex = "#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#";
                        $passwordRegex = "#^[a-zA-Z0-9éèùà@&]{8,15}$#";
                        if (preg_match($emailRegex, $email)
                                AND preg_match($passwordRegex, $pass)) {
                            // On se connecte au la SGBD Mysql
                            include("./utils/connexion_db.php");

                            // On enregistre l'entreprise
                            $company = $bdd->prepare("
                                INSERT INTO companies(name, siret, address_1, address_2, city_id, add_date, update_date)
                                VALUES(:company_name, :siret, :address_1, :address_2, :city_id, NOW(), NOW());
                            ");
                            $company->execute([
                                "company_name"=> $companyName,
                                "siret"=> $siret,
                                "address_1"=> $address1,
                                "address_2"=> $address2,
                                "city_id"=> $cityId,
                            ]);
                            $companyId = (int) $bdd->lastInsertId();

                            // On enregistre le user
                            $user = $bdd->prepare("
                                INSERT INTO users(firstname, lastname, company_id, position, email, password, register_date)
                                VALUES(:prenom, :nom, :company_id, :position, :courriel, :pass, NOW());
                            ");
                            $user->execute([
                                "prenom"=> $firstname,
                                "nom"=> $lastname,
                                "company_id"=> $companyId,
                                "position"=> $position,
                                "courriel"=> $email,
                                "pass"=> password_hash($pass, PASSWORD_BCRYPT)
                            ]);
                            // On met un lien vers la page perso
                            $displayText .= "Inscription validé <br/><br/>";
                            $displayText .= "Pour continuer veuillez vous rendre sur la page <strong>home</strong>, et vous connecter.<br/><br/>";
                            $displayText .= "Merci !";
                        } else {
                            $displayText .= "Il y a un problème dans les données d'inscription que vous avez saisi ! <br/>";
                            $displayText .= "Il s'agit d'un email au format invalide, ou d'un mot de passe incorrecte. <br/>";
                            $displayText .= "Pour rappel, un mot de passe doit avoir au moins 8 caractères et être composé des caractères suivant : <br/>";
                            $displayText .= "Majuscules, minuscules, chiffres et des caractères spéciaux suivant : <strong>éèùà@&</strong>";
                            $displayText .= "Veillez, s'il vous plait, réessayer : <a href='index.php'>Home</a>";
                        }
                    } else {
                        $displayText .= 'Votre mot de passe de confirmation est différent de votre mot de passe. <br/>';
                        $displayText .= "Veillez, s'il vous plait, réessayer : <a href='index.php'>Home</a>";
                    }
                } else {
                    $displayText .= "Vous n'avez pas saisie toutes les informations nécessaires<br/>";
                    $displayText .= "Veillez, s'il vous plait, réessayer : <a href='index.php'>Home</a>";
                }

                echo $displayText;
                ?>
            </p>
        </div>
        <?php include("./layout/footer.php"); ?>
  </body>
</html>
  