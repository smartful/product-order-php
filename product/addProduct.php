<?php
require("../layout/layoutFunctions.php");
session_start();
echo htmlHead("Formulaire d'ajout", "../style");
?>
    <body>
        <?php include("../layout/header.php"); ?>
        <!-- le menu principal -->
        <?= deconnexionMenu("../") ?>

        <!-- le menu des activités -->
        <div id="menu_right">
            <div class="element_menu">
                <h3>Activités</h3>
                <ul>
                    <li><a href="productList.php">Produits</a></li>
                    <li><a href="../customer/customerList.php">Clients</a></li>
                    <li><a href="../order/orderList.php">Commandes</a></li>
                </ul>
            </div>
        </div>

        <div id="corps">
            <h1>Ajout d'un produit</h1>
            <form method="post" action="addProductProcess.php">
                <fieldset>
                    <legend>Information du produit</legend>
                    <table>
                        <tr>
                            <td><label for="reference">Référence</label> </td>
                            <td><input type="text" name="reference" id="reference" size=10/></td>
                        </tr>
                        <tr>
                            <td><label for="designation">Désignation</label> </td>
                            <td><input type="text" name="designation" id="designation" size=50/></td>
                        </tr>
                        <tr>
                            <td><label for="unit_price">Prix unitaire (en € HT)</label> </td>
                            <td><input type="number"  name="unit_price" id="unit_price" size=50 step="any"/></td>
                        </tr>
                        <tr>
                            <td><label for="rate">Taux TVA (en %)</label> </td>
                            <td><input type="number" name="rate" id="rate" size=10 step="any"/></td>
                        </tr>
                    </table>
                </fieldset>
                <p>
                    <input type="submit" value="Envoyer"/>
                </p>
            </form>
        </div>
        <?php include("../layout/footer.php"); ?>
    </body>
</html>