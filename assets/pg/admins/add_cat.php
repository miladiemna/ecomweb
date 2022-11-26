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
    <?php include("./sidebar.php"); ?>
        <div class="content-bar">

            <div class="path-bar">
                <div class="url-path active-path">Menu Principal</div>
                <div class="url-path slash">/</div>
                <div class="url-path active-path">Catégories</div>
                <div class="url-path slash">/</div>
                <div class="url-path">Ajouter une catégorie</div>
            </div>

            <?php

            if (isset($_POST["cat_sub"])) {
                $cat_name = $_POST["cat_name"];

                if (empty($cat_name)) {
                        echo "<div style='margin: 20px; font-size: 18px; padding: 10px 15px; background-color: #ffe6e6;'>Remplissez les cases vides</div>";
                    }
                    else {

                        $sql2 = "SELECT * FROM category ORDER BY id DESC LIMIT 1";
                        $result2 = $conn->query($sql2);

                        $row2 = $result2->fetch_assoc();

                        $num_rows = $result2->num_rows;

                        if ($num_rows < 0) {
                            $num_count = "1";
                        }
                        else {
                            $num_count = $row2["list_num"] + 1;
                        }

                        $sql = "INSERT category SET cat_name='$cat_name', listorder='$num_count'";
                        
                        if ($conn->query($sql) === TRUE) {
                            echo "<div style='margin: 20px; font-size: 18px; padding: 10px 15px; background-color: #e6fff5;'>Catégorie ajoutée avec succès</div>";
                        }
                        else {
                            echo "<div style='margin: 20px; font-size: 18px; padding: 10px 15px; background-color: #ffe6e6;'>Une erreur s'est produite: " . $conn->error . "</div>";
                        }

                    }
            }


            ?>

            <div class="container-form">
                <form action="" method="post">
                    <input type="text" name="cat_name" id="" placeholder="Nom">

                    <p>
                        <input type="submit" name="cat_sub" value="Enregitrer">
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