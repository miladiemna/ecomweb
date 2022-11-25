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
        <div class="side-bar">
            <div class="item-bar" onclick="window.open('../../../home', '_self');">Page Principale</div>
            <div class="item-bar" onclick="window.open('../../../products', '_self');">Produits</div>
            <div id="req1" class="item-bar" onclick="sub_menu_open();">Commandes</div>
            <div id="req2" class="item-bar" onclick="sub_menu_close();">Commandes</div>

            <div id="sub-menu" class="sub-menu">
                <div onclick="window.open('requests', '_self')">Toutes les commandes</div>
                <div onclick="window.open('req1', '_self')">En attente de confirmation</div>
                <div onclick="window.open('req2', '_self')">En attente de livraison</div>
                <div onclick="window.open('req3', '_self')">Livrées</div>
                <div onclick="window.open('req4', '_self')">Annulées</div>
                <div onclick="window.open('req5', '_self')">Réceptionnées</div>
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
                <div class="url-path">Produits</div>

                <button onclick="window.open('<?php echo $host_name; ?>assets/pg/admins/add_product.php', '_self');">Ajouter un nouveau produit</button>
            </div>

            
            <table class="table table-bordered" role="table">
                <thead>
                    <tr>
                        <th width="2%">#</th>
                        <th class="text-right" width="15%">Nom du produit</th>
                        <th class="text-right" width="15%">Prix d'origine</th>
                        <th class="text-right" width="15%">Prix après réduction</th>
                        <th class="text-right" width="15%">Nombre de ventes</th>
                        <th class="text-right" width="6%">Avis</th>
                        <th class="text-right" width="10%">Catégorie</th>
                        <th class="text-right" width="60%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    $sql = "SELECT * FROM products";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>
                        <td><span class="badge">' . $row["id"] . '</span></td>
                        <td>' . $row["title"] . '</td>
                        <td>' . $row["old_price"] . 'DT</td>
                        <td>' . $row["price"] . 'DT</td>
                        <td> 1</td>
                        <td> <a href="<?php echo $host_name; ?>/home/show/4" target="_blanck">0</a></td>
                        <td>' . $row["cat_type"] . '</td>
                        <td data-title="التحكم" class="text-center">
                            <a href="assets/pg/admins/edit_product.php?prd_id=' . $row["id"] . '" class="edit-btn">Mettre à jour</a>
                            <a href="del_product?del_id=' . $row["id"] . '" class="del-btn">Supprimer</a>
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