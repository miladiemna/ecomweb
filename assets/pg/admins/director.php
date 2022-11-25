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
                <div class="url-path">Administrateurs</div>

                <button onclick="window.open('<?php echo $host_name; ?>assets/pg/admins/add_admin.php', '_self');">Ajouter un administrateurs</button>
            </div>


            <table class="table table-bordered" role="table">
                <thead>
                    <tr>
                        <th width="2%">#</th>
                        <th class="text-right" width="20%">Nom de l'administrateur</th>
                        <th class="text-right" width="30%">Adresse e-mail</th>
                        <th class="text-right" width="30%"></th>
                    </tr>
                </thead>
                <tbody>

                    

                    <?php

                    $sql2 = "SELECT * FROM admin_login";
                    $result2 = $conn->query($sql2);

                    while ($row2 = $result2->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row2["admin_id"] . "</td>";
                        echo "<td>";

                        if ($row2["admin_user"] === $_SESSION["admin_user"]) {
                            echo "<span style='color: white; font-weight: bold; background-color: #0088ff; padding: 5px;'>" . $row2["admin_user"] . "</span>";
                        }
                        else {
                            echo $row2["admin_user"];
                        }

                        echo "</td>";
                        echo "<td>" . $row2["admin_email"] . "</td>";
                        echo '<td data-title="Gérer" class="text-center">
                            <a href="assets/pg/admins/edit_director.php?drc_id=' . $row2["admin_id"] . '" class="edit-btn">Mettre à jour</a>
                            <a href="del_check_director?del_id=' . $row2["admin_id"] . '" class="del-btn">Supprimer</a>
                        </td>';
                        echo "</tr>";

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