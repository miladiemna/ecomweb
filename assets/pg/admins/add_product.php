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
                <div class="url-path active-path">Acceuil</div>
                <div class="url-path slash">/</div>
                <div class="url-path active-path">Produits</div>
                <div class="url-path slash">/</div>
                <div class="url-path">Ajouter un produit</div>
            </div>

            <?php

                if (isset($_POST["sub_form"])) {

                    $product_title = $_POST["product_title"];
                    $original_price = $_POST["original_price"];
                    $old_price = $_POST["old_price"];
                    $shipping_price = $_POST["shipping_price"];
                    $description = htmlspecialchars($_POST["editor1"]);
                    $shipping_info = $_POST["shipping_info"];
                    $product_images = $_FILES["product_images"];
                    $category_type = $_POST["cat_type"];
                    

                    

                        $sql = "INSERT INTO products (title, disc, price, old_price, shipping, shipping_info, cat_type) VALUES ('$product_title', '$description', '$original_price', '$old_price', '$shipping_price', '$shipping_info', '$category_type')";
                        
                        if ($conn->query($sql) === TRUE) {
                            echo "<div style='margin: 20px; font-size: 18px; padding: 10px 15px; background-color: #f5eee2;'>Produit ajouté avec succès</div>";
                        }
                        else {
                            echo "<div style='margin: 20px; font-size: 18px; padding: 10px 15px; background-color: #f5eee2;'>Une erreu s'est produite: " . $conn->error . "</div>";
                        }

                        $sql2 = "SELECT * FROM products ORDER BY id DESC";
                        $result2 = $conn->query($sql2);

                        $row2 = $result2->fetch_assoc();

                        if($result2->num_rows === "0") {
                            $product_id = "1";
                        }
                        else {
                            $product_id = $row2["id"]; // intval($row2["id"]+1);
                        }
                        
                        mkdir('products_img/' . $product_id, 0777, true);
                        chmod('products_img/' . $product_id, 0777);

                        $file_count = count($_FILES["product_images"]["name"]);

                        for($i=0;$i<$file_count;$i++) {
                            $product_images = $_FILES["product_images"]["tmp_name"][$i];
                            $file_name = $_FILES["product_images"]["name"][$i];
                            move_uploaded_file($product_images, 'products_img/' . $product_id . '/' . $file_name);
                        }

                    }

                // }
            
            
            ?>

            <div class="container-form">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="text" name="product_title" id="" placeholder="Nom du produit">
                    <input type="text" name="original_price" id="" placeholder="Nouveau Prix ">
                    <input type="text" name="old_price" id="" placeholder="Ancien Prix">
                    <input type="text" name="shipping_price" id="" placeholder=" Frais de livraison">
                    <textarea name="editor1" id="editor1"></textarea>
                    <textarea style="height: 100px;" name="shipping_info" id="" placeholder="Détail du produit"></textarea>

                    <?php

                        $sql5 = "SELECT * FROM category";
                        $result5 = $conn->query($sql5);

                    ?>

                    <select name="cat_type" style="margin: 20px;" class="my-font">

                        <option value="" selected="selected">Catégorie</option>

                    <?php

                        while ($row5 = $result5->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $row5["cat_name"]; ?>" class="my-font"><?php echo $row5["cat_name"]; ?></option>
                            <?php
                        }

                    ?>

                    </select>

                    <input id="files" type="file" name="product_images[]" multiple id="" value="">
                    <input type="button" class="file-btn" value="Ajouter une photo du produit" onclick="document.getElementById('files').click();">

                    <p>
                        <input type="submit" name="sub_form" value="Enregistrer">
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