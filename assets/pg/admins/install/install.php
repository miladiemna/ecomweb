<?php include("../inc/conn.inc.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WoneyMaroc | لوحة التحكم</title>
    <link rel="stylesheet" href="main_style">
    <style type="text/css">
    	body {
    		background-color: #F5F5F5;
    	}

    	.container2 {
    		margin: 50px auto;
    		width: 500px;
    		height: auto;
    		text-align: center;
    		border: 1px solid #d9d9d9;
    		border-radius: 6px;
    		background-color: #FFFFFF;
    		padding: 20px;
    	}

    	.container2 .secs_class {
    		margin: 5px 0;
    		width: 100%;
    		color: #638761;
    		font-weight: bold;
    		text-align: right;
    		border: 1px solid #d9d9d9;
    		border-radius: 6px;
    		background-color: #DFF0D8;
    		padding: 12px 20px;
    	}

    	.container2 .err_class {
    		margin: 5px 0;
    		width: 100%;
    		color: #c46868;
    		font-weight: bold;
    		text-align: right;
    		border: 1px solid #d9d9d9;
    		border-radius: 6px;
    		background-color: #F2DEDE;
    		padding: 12px 20px;
    	}

    	.container2 .btn_style2 {
    		margin: 10px 0;
    		color: white !important;
    		font-family: 'Tajawal', sans-serif !important;
    		font-size: 15px !important;
    		font-weight: bold !important;
    		border: 1px solid #4cae4c !important;
    		border-radius: 6px !important;
    		background-color: #5cb85c !important;
    		padding: 8px 15px !important;
    		cursor: pointer !important;
    	}
    </style>
</head>
<body>

	<div class="container2 container-form">
		<?php

		if (isset($_POST["server_sub"])) {

			$server = htmlspecialchars($_POST["server_host"]);
			$user_serv = htmlspecialchars($_POST["server_user"]);
			$pass_serv = htmlspecialchars($_POST["server_pass"]);
			$dbname = htmlspecialchars($_POST["server_db"]);

			if (empty($server) ||
				empty($user_serv) ||
				empty($dbname)) {
				echo "<div style='margin: 20px 0; font-size: 18px; padding: 10px 15px; background-color: #ffe6e6;'>Remplir les cases vides/div>";
			}
			else {
				$server_data = $server . "," . $user_serv . "," . $pass_serv . "," . $dbname;


				if (file_exists("../inc/server.inc.ecomweb")) {
					$server_post_data = file_put_contents("../inc/server.inc.ecomweb", $server_data);
					header("Location: tables_create");
				}
				else {
					echo "Chemin inéxistant: server.inc.ecomweb <br>assets/pg/admins/inc/";
				}
			}
		}

		if (isset($_POST["account_sub"])) {

			$account_user = htmlspecialchars($_POST["account_user"]);
			$account_email = htmlspecialchars($_POST["account_email"]);
			$account_pass = htmlspecialchars($_POST["account_pass"]);

			if (empty($account_user) ||
				empty($account_email) ||
				empty($account_pass)) {
				echo "<div style='margin: 20px 0; font-size: 18px; padding: 10px 15px; background-color: #ffe6e6;'>إملأ الفراغات</div>";
			}
			else {

				$sql2 = "INSERT admin_login SET admin_user='$account_user', admin_email='$account_email', admin_pass='$account_pass'";


				if ($conn->query($sql2)) {
					header("Location: install?check=4");
				}
				else {
					echo "Une erreur s'est produite " . $conn->error;
				}
			}
		}

		if (isset($_POST["web_sub"])) {

			$web_name = htmlspecialchars($_POST["web_name"]);

			if (empty($web_name)) {
				echo "<div style='margin: 20px 0; font-size: 18px; padding: 10px 15px; background-color: #ffe6e6;'>Remplir les cases vides/div>";
			}
			else {

				$sql2 = "INSERT web_settings SET web_name='$web_name', whatsapp_num='', header_text='', web_disc='', fb_pixel='', gl_analytics='' ";


				if ($conn->query($sql2)) {
					header("Location: install?check=5");
				}
				else {
					echo "Erreur: " . $conn->error;
				}
			}
		}


		if ($_GET["check"] === "2") {
			?>

			<h2>Base de données</h2>

			<form action="" method="post">
				<input type="text" name="server_host" placeholder="Host>
				<input type="text" name="server_user" placeholder="Nom d'utilisateur">
				<input type="text" name="server_pass" placeholder="Mot de passe">
				<input type="text" name="server_db" placeholder="Nom de base de données">
				<input type="submit" class="btn_style2" value="Création des tables" name="server_sub">
			</form>

			<div style="color: #1a1a1a; text-align: center; margin: 15px; font-weight: bold;">Cette étape prend du temps, veuillez patienter</div>

			<?php
			
		}
		else if ($_GET["check"] === "3") {
			?>

			<h2>إدخال بيانات المدير</h2>

			<form action="" method="post">
				<input type="text" name="account_user" placeholder="Nom d'utilisateur">
				<input type="text" name="account_email" placeholder="Adresse e-mail">
				<input type="password" name="account_pass" placeholder="Mot de passe>
				<input type="submit" class="btn_style2" value="Création des tables" name="account_sub">
			</form>

			<?php
			
		}
		else if ($_GET["check"] === "4") {
			?>

			<h2>Paramètres</h2>

			<form action="" method="post">
				<input type="text" name="web_name" placeholder="Nom du site web">
				<input type="submit" class="btn_style2" value="Paramètres d'entrées" name="web_sub">
			</form>

			<?php
			
		}
		else if ($_GET["check"] === "5") {
			?>
			<div style="color: #1a1a1a; text-align: center; margin: 15px 15px 25px 15px; font-weight: bold;">La mise à jour a été faite avec succès</div>
			<?php
			
		}
		else {
			?>

			<?php

			$conn_inc = "../inc/conn.inc.php";
			$serv_inc = "../inc/server.inc.ecomweb";
			$tabl_inc = "../inc/tables.inc.php";

			if (is_writable($conn_inc)) {
				echo "<p>
						<div class='secs_class'>الملف conn.inc.php قابل للكتابة .</div>
					  </p>";
			}
			else {
				echo "<p>
						<div class='err_class'>الملف conn.inc.php غير قابل للكتابة .</div>
					  </p>";
			}

			if (is_writable($serv_inc)) {
				echo "<p>
						<div class='secs_class'>الملف server.inc.ecomweb قابل للكتابة .</div>
					  </p>";
			}
			else {
				echo "<p>
						<div class='err_class'>الملف server.inc.ecomweb غير قابل للكتابة .</div>
					  </p>";
			}

			if (is_writable($tabl_inc)) {
				echo "<p>
						<div class='secs_class'>الملف tables.inc.php قابل للكتابة .</div>
					  </p>";
			}
			else {
				echo "<p>
						<div class='err_class'>الملف tables.inc.php غير قابل للكتابة .</div>
					  </p>";
			}


			?>

			<button class="btn_style2" onclick="window.open('?check=2', '_self');">بدأ التنصيب</button>

			<?php
		}


		?>

		<div style="color: #1a1a1a; text-align: center; margin: 15px; font-weight: bold;">by <span style="color: #0088ff;">hassiniAyoub</span></div>

	</div>

</body>
</html>