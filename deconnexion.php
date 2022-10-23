<?php
require("./layout/htmlHead.php");
session_start();
echo htmlHead("Inscription", "style");
?>
    <body>
        <?php
        session_destroy();
        header('Location: index.php');
        ?>
    </body>
</html>