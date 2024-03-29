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
            <div style="color: #522a34;" onclick="window.open('setting', '_self');">Paramètres</div>
            <div style="color: #522a34;" class="menu-item" onclick="window.open('logout', '_self');">Déconnexion</div>
        </div>
    </div>

    <div class="content">
    <?php  include("./sidebar.php"); ?>
        <div class="content-bar">

            <div class="path-bar">
                <div class="url-path active-path">Acceuil</div>
                <div class="url-path slash">/</div>
                <div class="url-path active-path">Catégories</div>
                <div class="url-path slash">/</div>
                <div class="url-path">Modifier une catégorie</div>
            </div>

            <?php

            $cat_id = $_GET["cat_id"];

            if (isset($_POST["cat_sub"])) {
                $cat_name = $_POST["cat_name"];

                if (empty($cat_name)) {
                        echo "<div style='margin: 20px; font-size: 18px; padding: 10px 15px; background-color: #f0e6d3;'>Remplissez les cases vides</div>";
                    }
                    else {

                        $sql = "UPDATE category SET cat_name='$cat_name' WHERE id='$cat_id'";
                        
                        if ($conn->query($sql) === TRUE) {
                            echo "<div style='margin: 20px; font-size: 18px; padding: 10px 15px; background-color: #f0e6d3;'>Catégorie mise à jour avec succès</div>";
                        }
                        else {
                            echo "<div style='margin: 20px; font-size: 18px; padding: 10px 15px; background-color: #f0e6d3;'>Une erreur s'est produite " . $conn->error . "</div>";
                        }

                    }
            }

            $sql2 = "SELECT cat_name FROM category WHERE id='$cat_id'";
            $result2 = $conn->query($sql2);

            $row2 = $result2->fetch_assoc();

            ?>

            <div class="container-form">
                <form action="" method="post">
                    <input type="text" name="cat_name" id="" value="<?php echo $row2["cat_name"]; ?>" placeholder="Nom">

                    <p>
                        <input type="submit" name="cat_sub" value="Enregistrer">
                    </p>
                </form>
            </div>

        </div>
    </div>
    
    <script src="ckeditor/ckeditor.js"></script>
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor 4
        // instance, using default configuration.
        CKEDITOR.replace('editor1');
        CKEDITOR.editorConfig = function( config ) {
            config.language = 'ar';
            config.uiColor = '#F7B42C';
            config.height = 300;
            config.toolbarCanCollapse = true;
        };
    </script>

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