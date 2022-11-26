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
            <div style="color: #522a34;"class="menu-item" onclick="window.open('setting', '_self');">Paramètres</div>
            <div style="color: #522a34;" class="menu-item" onclick="window.open('logout', '_self');">Déconnexion</div>
        </div>
    </div>

    <?php  include("./sidebar.php"); ?>
        <div class="content-bar">
            <?php

            date_default_timezone_set('Africa/Casablanca');
            
            echo "<div style='position: relative; margin-top: 15px;'> <h2 style='margin-right: 20px; font-size: 32px; font-weight: lighter;'>Menu Principal</h2> <div style='background-color: #ebddc5; color: #522a34; position: absolute; top: 0; right: 20px; padding: 5px 15px; border-radius: 12px;'>" . date("d/m/Y") . "</div> </div>" ;
            
            ?>

            <div class="path-bar">
                <div class="url-path active-path">Acceuil</div>
                <div class="url-path slash">/</div>
                <div class="url-path">Page principale</div>
            </div>

            <div class="panel-bar">
                <div style="color: #522a34;"onclick="window.open('products', '_self');">Nombre de produits
                
                <div>
                    
                    <?php

                    $sql0 = "SELECT * FROM products";
                    $result0 = $conn->query($sql0);

                    echo $result0->num_rows;
                
                    ?>
                </div>
                </div>
                <div style="color: #522a34;"onclick="window.open('req1', '_self');">
                    Commandes Non confirmées
                    <div>
                        <?php

                        $sql2 = "SELECT * FROM orders WHERE status='1'";
                        $result2 = $conn->query($sql2);

                        echo $result2->num_rows;
                    
                    
                        ?>
                    </div>
                </div>
                <div style="color: #522a34;"onclick="window.open('req5', '_self');">Commandes livrées
                    <div>
                        <?php

                        $sql3 = "SELECT * FROM orders WHERE status='5'";
                        $result3 = $conn->query($sql3);

                        echo $result3->num_rows;
                    
                    
                        ?>
                    </div>
                </div>
                <div style="color: #522a34;">Avis<div>0</div></div>
            </div>

            <div class="title-bar-2">Commandes</div>

            <table class="table table-bordered" role="table">
                <thead>
                    <tr>
                        <th width="2%">#</th>
                        <th class="text-right" width="15%">Nom du produit</th>
                        <th class="text-right" width="15%">Nom du client</th>
                        <th class="text-right" width="10%">Téléphone</th>
                        <th class="text-right" width="10%">Région</th>
                        <th class="text-right" width="10%">Date</th>
                        <th class="text-right" width="10%">Prix</th>
                        <th class="text-right" width="15%">Etat</th>
                        <th class="text-right" width="30%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $sql = "SELECT * FROM orders";
                    $result = $conn->query($sql);

                    while($row = $result->fetch_assoc()) {

                        $prd_id = $row["product_id"];

                        $sql2 = "SELECT * FROM products WHERE id='$prd_id'";
                        $result2 = $conn->query($sql2);

                        $row2 = $result2->fetch_assoc();

                        echo '<tr>';
                            echo '<td>' . $row["id"] . '</td>';
                            echo '<td>' . $row2["title"] . '</td>';
                            echo '<td>' . $row["name"] . '</td>';
                            echo '<td>' . $row["phone"] . '</td>';
                            echo '<td>' . $row["city"] . '</td>';
                            echo '<td>' . $row["prd_date"] . '</td>';
                            echo '<td>' . $row["price"] . 'DT</td>';
                            echo '<td>';

                                if ($row["status"] === '1') {
                                    echo 'En attente de confirmation';
                                }
                                if ($row["status"] === '2') {
                                    echo 'En attente de livraison';
                                }
                                if ($row["status"] === '3') {
                                    echo 'Livrée';
                                }
                                if ($row["status"] === '4') {
                                    echo 'Annulée';
                                }
                                if ($row["status"] === '5') {
                                    echo 'Réceptionnée';
                                }


                            echo '</td>';
                            echo '<td class="text-center">';
                            echo '<a href="assets/pg/admins/info_product.php?req_id=' . $row["id"] . '" class="edit-btn">Détails</a>
                                  <a style="display: inline-block; margin-top: 10px;" href="del_request?del_id=' . $row["id"] . '" class="del-btn">Supprimer</a>';
                            echo '</td>';
                        echo '</tr>';

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