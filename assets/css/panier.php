<?php
session_start();
include_once("fonctions-panier.php");
require_once("../pg/admins/inc/conn.inc.php");


$erreur = false;
$action = (isset($_POST['action'])? $_POST['action']:  (isset($_GET['action'])? $_GET['action']:null )) ;
if($action !== null)
{
   if(!in_array($action,array('ajout', 'suppression', 'refresh')))
   $erreur=true;

   //récupération des variables en POST ou GET
   $l = (isset($_POST['l'])? $_POST['l']:  (isset($_GET['l'])? $_GET['l']:null )) ;
   $p = (isset($_POST['p'])? $_POST['p']:  (isset($_GET['p'])? $_GET['p']:null )) ;
   $q = (isset($_POST['q'])? $_POST['q']:  (isset($_GET['q'])? $_GET['q']:null )) ;
   $prd_id=$_GET['id'];
   //Suppression des espaces verticaux
   $l = preg_replace('#\v#', '',$l);
   //On vérifie que $p est un float
   $p = floatval($p);

   //On traite $q qui peut être un entier simple ou un tableau d'entiers
    
   if (is_array($q)){
      $QteArticle = array();
      $i=0;
      foreach ($q as $contenu){
         $QteArticle[$i++] = intval($contenu);
      }
   }
   else
   $q = intval($q);
    
}

if (!$erreur){
   switch($action){
      Case "ajout":
         ajouterArticle($l,$q,$p);
         break;

      Case "suppression":
         supprimerArticle($l);
         break;

      Case "refresh" :
         for ($i = 0 ; $i < count($QteArticle) ; $i++)
         {
            modifierQTeArticle($_SESSION['panier']['libelleProduit'][$i],round($QteArticle[$i]));
         }
         break;

      Default:
         break;
   }
}

echo '<?xml version="1.0" encoding="utf-8"?>';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">

<head>
<meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title><?php echo $row10["web_name"]; ?> | Tous types de produits</title>
<link rel="stylesheet" href="main_style">
<title>Votre panier</title>
</head>
<body>

<div class="whts-num-box">
        <button class="whts-btn"></button>
        <span class="whts-text"><?php echo $row10["whatsapp_num"]; ?></span>
</div>

	<div class="header-bar">
        <?php echo $row10["header_text"]; ?>
   </div>

   <header>
        <div class="center-bar">
            <div class="logo-wbs" onclick="window.open('main_page', '_self');"></div>

            <div class="menu-bar">

            <button onclick="window.open('coupons', '_self');">Les soldes</button>
            
        </div>
    </header>
    <div class="title-content">Votre Panier</div>
<div class="content">

   <form method="post" action="panier.php">
<table class="shopping-cart">
<form>
            <thead>
	         <tr>
               <th scope="col"> Image du produit</th>
					<th scope="col">Nom Produit</th>
					<th scope="col">Quantité</th>
					<th scope="col" colspan="2">Prix</th>
				</tr>
			  </thead>
           <tbody>
           <?php
    //Table produit
    if (creationPanier())
    {
       $nbArticles=count($_SESSION['panier']['libelleProduit']);
       if ($nbArticles <= 0)
       echo "<tr><td>Votre panier est vide </ td></tr>";
       else
       {
          for ($i=0 ;$i < $nbArticles ; $i++)
          {
             echo "<tr>";
             $dir_path = "../pg/admins/products_img/" . $prd_id;
                $extensions_array = array('jpg','png','jpeg');

                if(is_dir($dir_path))
                {
                    $files = scandir($dir_path);

                    $count_files = count($files);
            
    		        echo "<td><img style='border: 1px solid #ccc; width: 175px;'    src='" . $absolute_link . "admins/products_img/" . $prd_id . "/" . $files[2] . "'/></td>";

                }
         
             echo "<td>".htmlspecialchars($_SESSION['panier']['libelleProduit'][$i])."</ td>";
             echo "<td><input type=\"text\" size=\"4\" name=\"q[]\" value=\"".htmlspecialchars($_SESSION['panier']['qteProduit'][$i])."\"/></td>";
             echo "<td>".htmlspecialchars($_SESSION['panier']['prixProduit'][$i])."</td>";
             echo "<td><a href=\"".htmlspecialchars("panier.php?action=suppression&l=".rawurlencode($_SESSION['panier']['libelleProduit'][$i]))."\">Supprimer Article</a></td>";
             echo "</tr>";
          }

          echo "<tr><td colspan=\"2\"> </td>";
          echo "<td colspan=\"2\">";
          echo "Total : ".MontantGlobal();
          echo "</td></tr>";

          echo "<tr><td colspan=\"4\">";
          echo "<input type=\"submit\" value=\"Rafraichir\"/>";
          echo "<input type=\"hidden\" name=\"action\" value=\"refresh\"/>";

          echo "</td></tr>";
       }
    }
    // fin Table produit
    ?>
           </tbody>
           </table>
           
			</p>
			<ul id="shopping-cart-actions">
			
				
				<li>
					<a href="main_page" div style=" color: #522a34;"class="menu-item" class="btn">Continuer votre shopping</a>
               
				</li>
				<li>
					<a href="order_now?id=<?php echo $prd_id; ?>" div style=" color: #522a34;"class="menu-item" class="btn">Passer votre commande</a>
              
				</li>
			</ul>
		</form>
	</div>
   
   
</table>
</form>
</body>
</html>