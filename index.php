<!DOCTYPE html>
<html>
  <head>
    <title>Product Order</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
  <!-- l'en tête -->
  <div id="en_tete"></div>
  
  <!-- le menu -->
  <?php include("menu.php"); ?>
  
  <!-- le corps -->
  <div id="corps">
    <p>
      Bienvenue chez Product Order. <br/>
      Vous pouvez vous inscrire
    </p>
    
    <form method="post" action="main.php">
      <fieldset>
        <legend>Vos accès</legend>
        <table>
          <tr>
            <td><label for="email">Email</label> </td>
            <td><input type=text name="email" id="email"/><br/></td>
          </tr>
          <tr>
            <td><label for="pass">Mot de passe</label> </td>
            <td><input type=password name="pass" id="pass"/><br/></td>
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