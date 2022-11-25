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
    <style type="text/css">
        ul {
            margin: 0;
            padding: 0;
            -moz-appearance: none;
            -webkit-appearance: none;
        }
    </style>
    <script type="text/javascript" src="jquery.min.js"></script>
    <script type="text/javascript" src="jquery-ui.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            function slideout(){
                setTimeout(function(){
                $("#response").slideUp("slow", function () {});
                }, 2000);
            }
 
            $("#response").hide();

            $(function() {
                $("ul").sortable({ opacity: 0.8, cursor: 'move', update: function() {
                    var order = $(this).sortable("serialize") + '&update=update';

                    $.post("updateList.php", order, function(theResponse){
                        $("#response").html(theResponse);
                        $("#response").slideDown('slow');
                        slideout();
                    });                
                }         
                });
            });

        }); 
    </script>
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
                <div class="url-path">Catégories</div>

                <button onclick="window.open('<?php echo $host_name; ?>assets/pg/admins/add_cat.php', '_self');">Ajouter une catégorie</button>
            </div>


            <?php

            $sql = "SELECT id, cat_name FROM category ORDER BY listorder ASC";
            $result = $conn->query($sql);

            ?>

            <div id="response"> </div>

            <ul>

            <?php

            while ($row = $result->fetch_assoc()) {
                echo "<li id='arrayorder_" . $row["id"] . "' style='list-style: none; width: 96%; padding: 12px 20px; margin: 10px 20px 10px 0; border: 1px solid #eee; background-color: #efefef; border-radius: 3px; font-size: 20px; position: relative;'>";
                echo $row["cat_name"];
                echo '<div style="position: absolute; left: 10px; top: 12px;" class="clear">
                          <a href="assets/pg/admins/edit_category.php?cat_id=' . $row["id"] . '" class="edit-btn">تعديل</a>
                            <a href="del_category?del_id=' . $row["id"] . '" class="del-btn">حذف</a>
                      </div>';
                echo "</li>";
            }

            ?>
            </ul>

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