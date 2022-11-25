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
            <div class="menu-item" onclick="window.open('setting', '_self');">Paramètres</div>
            <div style="color: #E74C3C;" class="menu-item" onclick="window.open('logout', '_self');">Déconnexion</div>
        </div>
    </div>

    <<div class="side-bar">
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
                <div class="url-path active-path">Produits</div>
                <div class="url-path slash">/</div>
                <div class="url-path">Modifier le produit</div>
            </div>

            <?php

                $edit_product_id = $_GET["prd_id"];

                if (isset($_POST["sub_form"])) {

                    $product_title = $_POST["product_title"];
                    $original_price = $_POST["original_price"];
                    $old_price = $_POST["old_price"];
                    $shipping_price = $_POST["shipping_price"];
                    $description = htmlspecialchars($_POST["editor1"]);
                    $shipping_info = $_POST["shipping_info"];
                    $delelte_product_images = $_POST["del_imgs"];
                    $category_type = $_POST["cat_type"];

                    if (empty($product_title) ||
                        empty($original_price) ||
                        empty($old_price) ||
                        empty($description) ||
                        empty($shipping_info) ||
                        empty($category_type)) {
                        echo "<div style='margin: 20px; font-size: 18px; padding: 10px 15px; background-color: #ffe6e6;'>Remplissez les cases vides</div>";
                    }
                    else {

                        $split_del_prd_imgs = explode(",", "$delelte_product_images");

                        foreach($split_del_prd_imgs as $img_name) {
                            unlink("products_img/" . $_GET["prd_id"] . "/" . $img_name);
                        }

                        $file_count = count($_FILES["product_images"]["name"]);

                        for($i2=0;$i2<$file_count;$i2++) {
                            $product_images = $_FILES["product_images"]["tmp_name"][$i2];
                            $file_name = $_FILES["product_images"]["name"][$i2];
                            move_uploaded_file($product_images, 'products_img/' . $_GET["prd_id"] . '/' . $file_name);
                        }


                        $sql = "UPDATE products SET title='$product_title', disc='$description', price='$original_price', old_price='$old_price', shipping='$shipping_price', shipping_info='$shipping_info', cat_type='$category_type' WHERE id='$edit_product_id'";
                        
                        if ($conn->query($sql) === TRUE) {
                            echo "<div style='margin: 20px; font-size: 18px; padding: 10px 15px; background-color: #e6fff5;'>Produit mis à jour avec succès</div>";
                        }
                        else {
                            echo "<div style='margin: 20px; font-size: 18px; padding: 10px 15px; background-color: #ffe6e6;'>Une erreu s'est produite " . $conn->error . "</div>";
                        }
                    }

                }

                $sql4 = "SELECT * FROM products WHERE id='$edit_product_id'";
                $result4 = $conn->query($sql4);

                $row4 = $result4->fetch_assoc();
            
            ?>

            <div class="container-form">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="text" name="product_title" id="" placeholder="Nom du produit" value="<?php echo $row4["title"] ?>">
                    <input type="text" name="original_price" id="" placeholder="Ancien Prixrix" value="<?php echo $row4["price"] ?>">
                    <input type="text" name="old_price" id="" placeholder="Nouveau prix" value="<?php echo $row4["old_price"] ?>">
                    <input type="text" name="shipping_price" id="" placeholder="Frais de livraison" value="<?php echo $row4["shipping"] ?>">
                    <textarea name="editor1" id="editor1"><?php echo $row4["disc"] ?></textarea>
                    <textarea style="height: 100px;" name="shipping_info" id="" placeholder="Détails de la livraison"><?php echo $row4["shipping_info"] ?></textarea>

                    <?php

                        $sql5 = "SELECT * FROM category";
                        $result5 = $conn->query($sql5);

                    ?>

                    <select name="cat_type" style="margin: 20px;" class="my-font">

                        <option value="" selected="selected">Choisissez une catégorie</option>

                    <?php

                        while ($row5 = $result5->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $row5["cat_name"]; ?>" class="my-font"><?php echo $row5["cat_name"]; ?></option>
                            <?php
                        }

                    ?>

                    </select>


                    <div class="container-img">

                    <?php

                    $dir_path = "products_img/" . $_GET["prd_id"] . "/";
                    $extensions_array = array('jpg','png','jpeg');

                    if(is_dir($dir_path))
                    {
                        $files = scandir($dir_path);
                        
                        for($i = 0; $i < count($files); $i++)
                        {
                            if($files[$i] !='.' && $files[$i] !='..')
                            {
                                
                                // get file extension
                                $file = pathinfo($files[$i]);
                                $extension = $file['extension'];

                                $rm_dot = str_replace(".", "_", $files[$i]);

                            // check file extension
                                if(in_array($extension, $extensions_array))
                                {
                                // show image
                                echo "<div id='" . $rm_dot . "' class='item-img'><div class='close-btn' onclick='del_img_" . $rm_dot . "();'></div><img src='$dir_path$files[$i]' style='width:100%;'></div>";

                                echo "<script>

                                        function del_img_" . $rm_dot . "() {
                                            
                                            document.getElementById('" . $rm_dot . "').style.display = 'none';

                                            var getinput = document.getElementById('del_imgs');
                                            var getinputvar = document.getElementById('del_imgs').value;

                                            getinput.value = getinputvar + '" . $files[$i] . ",';
                                            
                                        }
                                
                                      </script>";
                                }
                            }
                        }
                    }

                    ?>

                    <p style="width: 100%;">
                        <input id="files" type="file" name="product_images[]" multiple id="">
                        <input style="margin-right: 20px;" type="button" class="file-btn" value="Ajoutez une image" onclick="document.getElementById('files').click();">
                    </p>

                    </div>

                    <input type="hidden" name="del_imgs" id="del_imgs">

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