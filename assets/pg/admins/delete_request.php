<?php

require_once("inc/conn.inc.php");

session_start();

if (!$_SESSION["admin_user"]) {
    header("Location: admin");
}


$delete_request = $_GET["del_id"];


if($_GET["del_stm"] === "true") {

    $sql = "DELETE FROM orders WHERE id='$delete_request'";
    $result = $conn->query($sql);

    header("Location: requests");

}
else {

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WoneyMaroc | Tableau de bord</title>
    <link rel="stylesheet" href="style">
</head>
<body>

    <h1 style="text-align: center; margin-top: 100px;">?Voulez vous supprimer cette demande dinitiviement<?php echo $delete_request; ?>)</h1>
    <h2 style="text-align: center; margin-top: 50px;">
        <a style="margin: 0 10px; color: white; background-color: #E74C3C; padding: 10px 15px; text-decoration: none;" href="del_request?del_id=<?php echo $delete_request?>&del_stm=true">Oui</a>
        <a style="margin: 0 10px; color: white; background-color: #18BC9C; padding: 10px 15px; text-decoration: none;" href="requests">Non</a>
    </h2>
    
</body>
</html>


<?php
}

?>