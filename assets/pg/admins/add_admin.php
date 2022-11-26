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
            <div style="color: #522a34;"class="menu-item" onclick="window.open('../../../setting', '_self');">Paramètres</div>
            <div style="color: #522a34;" class="menu-item" onclick="window.open('logout', '_self');">Déconnexion</div>
        </div>
    </div>

    <div class="content">
        <?php  include("./sidebar.php"); ?>
        <div class="content-bar">

            <div class="path-bar">
                <div class="url-path active-path">Menu Principal</div>
                <div class="url-path slash">/</div>
                <div class="url-path active-path">Admins</div>
                <div class="url-path slash">/</div>
                <div class="url-path">Ajouter un nouveau Admin</div>
            </div>

            <?php

            if (isset($_POST["admin_sub"])) {

                $admin_name     = htmlspecialchars($_POST["admin_name"]);
                $admin_email    = htmlspecialchars($_POST["admin_email"]);
                $admin_pass     = htmlspecialchars($_POST["admin_pass"]);
                $admin_pass2     = htmlspecialchars($_POST["admin_pass2"]);

                if (empty($admin_name) ||
                    empty($admin_email) ||
                    empty($admin_pass)) {
                        echo "<div style='margin: 20px; font-size: 18px; padding: 10px 15px; background-color: #ffe6e6;'>إملأ الفراغات</div>";
                    }
                    else {

                        if ($admin_pass === $admin_pass2) {
                            $sql = "INSERT admin_login SET admin_user='$admin_name', admin_email='$admin_email', admin_pass='$admin_pass'";
                        
                            if ($conn->query($sql) === TRUE) {
                                echo "<div style='margin: 20px; font-size: 18px; padding: 10px 15px; background-color: #e6fff5;'>Admin ajouté avec succès</div>";
                            }
                            else {
                                echo "<div style='margin: 20px; font-size: 18px; padding: 10px 15px; background-color: #ffe6e6;'>Une erreur s'est produite: " . $conn->error . "</div>";
                            }
                        }
                        else {
                            echo "<div style='margin: 20px; font-size: 18px; padding: 10px 15px; background-color: #ffe6e6;'>Mot de passe incorrect</div>";
                        }

                    }
            }

            ?>

            <div class="container-form">
                <form action="" method="post">
                    <input type="text" name="admin_name" id="" placeholder="Nom d'untilisateur">
                    <input type="text" name="admin_email" id="" placeholder="Adresse e-mail">
                    <input type="password" name="admin_pass" id="" placeholder="Mot de passe">
                    <input type="password" name="admin_pass2" id="" placeholder="Veuillez repéter votre mot de passe">

                    <p>
                        <input type="submit" name="admin_sub" value="Enregister">
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