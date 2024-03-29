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
            <div style="color: #522a34;"class="menu-item" onclick="window.open('setting', '_self');">Paramètres</div>
            <div style="color: #522a34;" class="menu-item" onclick="window.open('logout', '_self');">Déconnexion</div>
        </div>
    </div>

    <?php  include("./sidebar.php"); ?>
        <div class="content-bar">

            <div class="path-bar">
                <div class="url-path active-path">Acceuil</div>
                <div class="url-path slash">/</div>
                <div class="url-path active-path">Code promotion</div>
                <div class="url-path slash">/</div>
                <div class="url-path">Modofier le code promotion</div>
            </div>

            <?php

            $dis_id = $_GET["dis_id"];

            if (isset($_POST["coupon_sub"])) {

                $coupon_name = $_POST["discount_code"];
                $coupon_end_date = $_POST["discount_end_date"];



                if (empty($coupon_name) ||
                    empty($coupon_end_date)) {
                    echo "<div style='margin: 20px; font-size: 18px; padding: 10px 15px; background-color: #ffe6e6;'>Remplissez les cases vides</div>";
                }
                else {

                    $sql = "UPDATE coupons SET coupon_name='$coupon_name', date='$coupon_end_date' WHERE id='$dis_id'";
                    
                    if ($conn->query($sql) === TRUE) {
                        echo "<div style='margin: 20px; font-size: 18px; padding: 10px 15px; background-color: #f0e6d3;'>Code promotion mis à jour</div>";
                    }
                    else {
                        echo "<div style='margin: 20px; font-size: 18px; padding: 10px 15px; background-color: #f0e6d3;'>Une erreur s'est produite " . $conn->error . "</div>";
                    }

                }
            }

            $sql2 = "SELECT * FROM coupons WHERE id='$dis_id'";
            $result2 = $conn->query($sql2);

            $row2 = $result2->fetch_assoc();

            ?>

            <div class="container-form">
                <form action="" method="post">
                    <input type="text" name="discount_code" id="" value="<?php echo $row2['coupon_name']; ?>" placeholder="Code promotion">
                    <input type="date" name="discount_end_date" id="" value="<?php echo $row2['date']; ?>" placeholder="Date d'expiration du code promotion">

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