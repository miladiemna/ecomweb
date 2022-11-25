<?php

require_once("inc/conn.inc.php");

session_start();

if (!$_SESSION["admin_user"]) {
    header("Location: admin");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WoneyMaroc | Tableau de board</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="header">
        <div class="header-title">Tableau de board</div>

        <div class="side-menu">
            <div class="menu-item" onclick="window.open('../../../setting', '_self');">Paramètres</div>
            <div style="color: #E74C3C;" class="menu-item" onclick="window.open('logout', '_self');">Déconnexion</div>
        </div>
    </div>

    <div class="content">
        <div class="side-bar">
            <div class="item-bar" onclick="window.open('../../../home', '_self');">Acceuil</div>
            <div class="item-bar" onclick="window.open('../../../products', '_self');">Produits</div>
            <div id="req1" class="item-bar" onclick="sub_menu_open();">Commandes</div>
            <div id="req2" class="item-bar" onclick="sub_menu_close();">Commandes</div>

            <div id="sub-menu" class="sub-menu">
                <div onclick="window.open('requests', '_self')">Toutes les commandes</div>
                <div onclick="window.open('req1', '_self')">En attentes de confirmation</div>
                <div onclick="window.open('req2', '_self')">En attente de livraision</div>
                <div onclick="window.open('req3', '_self')">Livrées</div>
                <div onclick="window.open('req4', '_self')">Annulées</div>
                <div onclick="window.open('req5', '_self')">Récéptionnées avec sucès</div>
            </div>

            <div class="item-bar" onclick="window.open('../../../discounts', '_self');">Code promotion</div>
            <div class="item-bar" onclick="window.open('../../../cat', '_self');">Catégories</div>
            <div class="item-bar" onclick="window.open('../../../director', '_self');">Administrateurs</div>
            <div class="item-bar" onclick="window.open('../../../setting', '_self');">Paramètres</div>
        </div>
        <div class="content-bar">

            <div class="path-bar">
                <div class="url-path active-path">Acceuil</div>
                <div class="url-path slash">/</div>
                <div class="url-path active-path">Code promotion</div>
                <div class="url-path slash">/</div>
                <div class="url-path">Ajouter code promotion</div>
            </div>

            <?php

            if (isset($_POST["coupon_sub"])) {

                $coupon_name = $_POST["discount_code"];
                $coupon_end_date = $_POST["discount_end_date"];



                if (empty($coupon_name) ||
                    empty($coupon_end_date)) {
                    echo "<div style='margin: 20px; font-size: 18px; padding: 10px 15px; background-color: #ffe6e6;'>Remplissez les cases vides</div>";
                }
                else {

                    $sql = "INSERT INTO coupons (coupon_name, date) VALUES('$coupon_name', '$coupon_end_date')";
                    
                    if ($conn->query($sql) === TRUE) {
                        echo "<div style='margin: 20px; font-size: 18px; padding: 10px 15px; background-color: #e6fff5;'>Code promo ajouté avec succès</div>";
                    }
                    else {
                        echo "<div style='margin: 20px; font-size: 18px; padding: 10px 15px; background-color: #ffe6e6;'>Une erreur s'est produite: " . $conn->error . "</div>";
                    }

                }
            }

            ?>

            <div class="container-form">
                <form action="" method="post">
                    <input type="text" name="discount_code" id="" placeholder="Code promo">
                    <input type="date" name="discount_end_date" id="" placeholder="Date d'expiration du code promotion">

                    <p>
                        <input type="submit" name="coupon_sub" value="Enregistrer">
                    </p>
                </form>
            </div>

        </div>
    </div>

    <script>
        function sub_menu_open() {
            document.getElementById("req1").style.display = "none";
            document.getElementById("req2").style.display = "block";
            document.getElementById("sub-menu").style.height = "260px";
        }

        function sub_menu_close() {
            document.getElementById("req1").style.display = "block";
            document.getElementById("req2").style.display = "none";
            document.getElementById("sub-menu").style.height = "0px";
        }
    </script>
</body>
</html>