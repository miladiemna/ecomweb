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

    <div class="content">
    <?php  include("./sidebar.php"); ?>
        <div class="content-bar">

            <div class="path-bar">
                <div class="url-path active-path">Acceuil</div>
                <div class="url-path slash">/</div>
                <div class="url-path">Demande</div>
            </div>

            <?php

                $request_id = $_GET["req_id"];

                $sql = "SELECT * FROM orders WHERE id='$request_id'";
                $result = $conn->query($sql);

                $row = $result->fetch_assoc();


                if (isset($_POST["status"])) {
                    $req_status = $_POST["status"];

                    if (empty($req_status)) {
                        echo "<h2 style='margin: 20px; color: red;'>Choisissez une option</h2>";
                    }
                    else {
                        $sql2 = "UPDATE orders SET status='$req_status' WHERE id='$request_id'";
                        if ($conn->query($sql2) === TRUE) {
                            header("Location: ../../../requests");
                        }
                        else {
                            echo $conn->error;
                        }
                    }
                }

            ?>


            <div style="margin: 20px;">
                <p></p>
                <span style="color: #CC0000; font-size: 22px; font-weight: bold;">Nom complet: </span>
                <span style="color: #333; font-size: 22px; font-weight: bold;"><?php echo $row["name"]; ?></span>

                <p></p>
                <span style="color: #CC0000; font-size: 22px; font-weight: bold;">Numéro de téléphone:  </span>
                <span style="color: #333; font-size: 22px; font-weight: bold;"><?php echo $row["phone"]; ?></span>

                <p></p>
                <span style="color: #CC0000; font-size: 22px; font-weight: bold;">Adresse: </span>
                <span style="color: #333; font-size: 22px; font-weight: bold;"><?php echo $row["address"]; ?></span>

                <p></p>
                <span style="color: #CC0000; font-size: 22px; font-weight: bold;">Région:  </span>
                <span style="color: #333; font-size: 22px; font-weight: bold;"><?php echo $row["city"]; ?></span>

                <p></p>
                <span style="color: #CC0000; font-size: 22px; font-weight: bold;">Code promotion:  </span>
                <span style="color: #333; font-size: 22px; font-weight: bold;"><?php echo $row["coupon"]; ?></span>

                <p></p>
                <span style="color: #CC0000; font-size: 22px; font-weight: bold;">Prix total: </span>
                <span style="color: #333; font-size: 22px; font-weight: bold;"><?php echo $row["price"] + $row["shipping"]; ?>DT</span>

                <p></p>
                <span style="color: #CC0000; font-size: 22px; font-weight: bold;">Etat de commande </span>
                <span style="color: #333; font-size: 22px; font-weight: bold;"><?php

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

                ?></span>


                <h2>Mettre à jour</h2>
            </div>


            <form action="" method="post" accept-charset="utf-8">

                <div class="container-form">
                    <select name="status">
                        <option value="">Choisissez l'état</option>
                        <option value="1">En attende de confirmation</option>
                        <option value="2">En attente de livraison</option>
                        <option value="3">Livrée</option>
                        <option value="4">Annulée</option>
                        <option value="5">Réceptionnée</option>
                    </select>

                    <br><br>

                    <button type="submit" class="btn-style" name="req_sub">Mettre à jour</button>
                </div>

            </form>

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