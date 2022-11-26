<?php

require_once("inc/conn.inc.php");

session_start();

if (!$_SESSION["admin_user"]) {
    header("Location: admin");
}


$delete_category = $_GET["del_id"];


if($_GET["del_stm"] === "true") {

    $sql = "DELETE FROM category WHERE id='$delete_category'";
    $result = $conn->query($sql);

    header("Location: cat");

}
else {

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WoneyMaroc | Tableau de board</title>
    <link rel="stylesheet" href="style">
</head>
<body>

    <h1 style="text-align: center; margin-top: 100px;">Voulez vous supprimer la catégorie <?php echo $delete_category; ?> difinitivement?</h1>
    <h2 style="text-align: center; margin-top: 50px;">
        <a style="margin: 0 10px; color: #522a34; background-color: #e0cda9; padding: 10px 15px; text-decoration: none;" href="del_category?del_id=<?php echo $delete_category?>&del_stm=true">OUI</a>
        <a style="margin: 0 10px; color: #522a34; background-color: #e0cda9; padding: 10px 15px; text-decoration: none;" href="cat">Non</a>
    </h2>
    
</body>
</html>


<?php
}

?>