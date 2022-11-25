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
     <div class="header-title">Tableau de board/div>

        <div class="side-menu">
            <div class="menu-item" onclick="window.open('setting', '_self');">Paramètres</div>
            <div style="color: #E74C3C;" class="menu-item" onclick="window.open('logout', '_self');">Déconnexion</div>
        </div>
    </div>

    <div class="content">
    <?php  include("./sidebar.php"); ?>
        <div class="content-bar">

            <div class="path-bar">
                <div class="url-path active-path">Acceuil</div>
                <div class="url-path slash">/</div>
                <div class="url-path active-path">Administrateurs</div>
                <div class="url-path slash">/</div>
                <div class="url-path">Modifier un administrateur</div>
            </div>

            <?php

            $drc_id = $_GET["drc_id"];

            if (isset($_POST["admin_sub"])) {

                $admin_name     = htmlspecialchars($_POST["admin_name"]);
                $admin_email    = htmlspecialchars($_POST["admin_email"]);
                $admin_pass     = htmlspecialchars($_POST["admin_pass"]);
                $admin_pass2     = htmlspecialchars($_POST["admin_pass2"]);

                if (empty($admin_name) ||
                    empty($admin_email) ||
                    empty($admin_pass)) {
                        echo "<div style='margin: 20px; font-size: 18px; padding: 10px 15px; background-color: #ffe6e6;'>Remplissez les cases vides</div>";
                    }
                    else {

                        if ($admin_pass === $admin_pass2) {
                            $sql = "UPDATE admin_login SET admin_user='$admin_name', admin_email='$admin_email', admin_pass='$admin_pass' WHERE admin_id='$drc_id'";
                        
                            if ($conn->query($sql) === TRUE) {
                                echo "<div style='margin: 20px; font-size: 18px; padding: 10px 15px; background-color: #e6fff5;'>Administrateur mis à jour</div>";
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

            $sql2 = "SELECT admin_user, admin_email FROM admin_login WHERE admin_id='$drc_id'";
            $result2 = $conn->query($sql2);

            $row2 = $result2->fetch_assoc();

            ?>

            <div class="container-form">
                <form action="" method="post">
                    <input type="text" name="admin_name" id="" value="<?php echo $row2['admin_user']; ?>" placeholder="Nom d'utilisateur">
                    <input type="text" name="admin_email" id="" value="<?php echo $row2['admin_email']; ?>" placeholder="Adresse e-mail">
                    <input type="password" name="admin_pass" id="" placeholder="Mot de passe">
                    <input type="password" name="admin_pass2" id="" placeholder="Veuillez resaisir votre mot de passe">

                    <p>
                        <input type="submit" name="admin_sub" value="Enregistrer">
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