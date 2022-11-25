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
    <link rel="stylesheet" href="style">
</head>
<body>

    <div class="header">
        <div class="header-title">Tableau de board</div>

        <div class="side-menu">
            <div class="menu-item" onclick="window.open('setting', '_self');">Paramètres</div>
            <div style="color: #E74C3C;" class="menu-item" onclick="window.open('logout', '_self');">Déconnexion</div>
        </div>
    </div>

    <div class="content">
    <div class="content">
    <?php  include("./sidebar.php"); ?>
        <div class="content-bar">

            <div class="path-bar">
                <div class="url-path active-path">Acceuil</div>
                <div class="url-path slash">/</div>
                <div class="url-path">Code promotion</div>

                <button onclick="window.open('<?php echo $host_name; ?>assets/pg/admins/add_discount.php', '_self');">Ajouter un nouveau code promotion</button>
            </div>

            <table class="table table-bordered" role="table">
                <thead>
                    <tr>
                        <th width="2%">#</th>
                        <th class="text-right" width="15%">Code promotion</th>
                        <th class="text-right" width="15%">Date d'expiration</th>
                        <th class="text-right" width="60%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    $sql = "SELECT * FROM coupons";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>
                        <td><span class="badge">' . $row["id"] . '</span></td>
                        <td>' . $row["coupon_name"] . '</td>
                        <td>' . $row["date"] . 'dh</td>
                        <td>
                            <a href="assets/pg/admins/edit_discount.php?dis_id=' . $row["id"] . '" class="edit-btn">Modifier</a>
                            <a href="del_discount?del_id=' . $row["id"] . '" class="del-btn">Supprimer</a>
                        </td>
                    </tr>';
                    }
                    
                    ?>
                </tbody>		
            </table>

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