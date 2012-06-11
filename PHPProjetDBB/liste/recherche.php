<?php

include('../connexion/_connexion.php');

$choix_rech=$_POST['choix_rech'];
$param=$_POST['param'];

mysql_query("SET NAMES UTF8");
if($choix_rech=="fournisseur"){
	
$sql= "SELECT * FROM COMMANDE c, FOURNISSEUR f WHERE c.id_fournisseur=f.id_fournisseur AND f.cofor=".$param."";


} 

else if($choix_rech=="piece"){

$sql= "SELECT * FROM COMMANDE c, COMPREND co, PIECE p
WHERE p.reference_piece=".$param." AND co.reference_piece=p.reference_piece AND c.no_commande=co.no_commande";

} 
else if($choix_rech=="silhouette"){

$sql= "SELECT * FROM COMMANDE WHERE code_silhouette='".$param."';";
		 	
} 
else if($choix_rech=="noCommande"){

$sql= "SELECT * FROM COMMANDE WHERE no_commande='".$param."';";
		 	
} 
else if($choix_rech=="typeCommande"){
	
$sql= "SELECT * FROM COMMANDE WHERE code_type_commande='".$param."';";

} 
else if($choix_rech=="etatCommande"){
if($param=="open")
$sql= "SELECT * FROM COMMANDE WHERE date_fermeture is NULL ;"; 
else 
$sql= "SELECT * FROM COMMANDE WHERE date_fermeture is not NULL ;";
} 
else if($choix_rech=="date_creation"){

$param2=$_POST['param2'];

if ($param == "")
		$sql= "SELECT * FROM COMMANDE WHERE date_commande <= '".$param2."';";
else if ($param2 == "")
		$sql= "SELECT * FROM COMMANDE WHERE date_commande >= '".$param."';";
		
else  $sql= "SELECT * FROM COMMANDE WHERE date_commande <= '".$param2."' AND date_commande >= '".$param."';";

		 
} 
else if($choix_rech=="date_reception"){

$param2=$_POST['param2'];

if ($param == "")
		$sql= "SELECT * FROM COMMANDE WHERE date_reception <= '".$param2."';";
else if ($param2 == "")
		$sql= "SELECT * FROM COMMANDE WHERE date_reception >= '".$param."';";
		
else  $sql= "SELECT * FROM COMMANDE WHERE date_reception <= '".$param2."' AND date_reception>= '".$param."';";

} 
$result = mysql_query($sql)or die( "ERREUR MYSQL numéro: ".mysql_errno()."<br>Type de cette erreur: ".mysql_error()."<br>\n" );


        /*************AFFICHAGE DE LA TABLE COMMANDE******************/

echo( "<div id=\"tab\"><table id=\"tableau\"  >\n" );
	
        echo( "<thead><tr> ");
        
	
        echo("<th>Numéro Commande</th>");
	
	
		echo("<th>Date Commande</th>");
	        
        
        echo ("<th>Fournisseur</th>");
        
        
        echo ("<th>Date Fermeture</th>");
        
        
        echo ("<th>Motif Fermeture</th>");
        
        
        echo ("<th>Identifiant Demandeur</th>");


        echo ("<th>Type Commande</th>");


	echo("</tr></thead>" );
 
 
 // affichage du résultat:
 echo( "<tbody>");
	while( $row = mysql_fetch_array($result) )
	{
	echo( "<tr>\n" );
	   
	
		echo( "<td >".$row['no_commande']."</td>\n" );
	
	
		echo( "<td >".$row['date_commande']."</td>\n" );

	
		echo( "<td >".$row['id_fournisseur']."</td>\n" );
        
        
        echo( "<td >".$row['date_fermeture']."</td>\n" );
        
        
        echo( "<td >".$row['motif_fermeture']."</td>\n" );
        
        
        echo( "<td >".$row['id_utilisateur_passe']."</td>\n" );
        
        
        echo( "<td >".$row['code_type_commande']."</td>\n" );
        
        
	echo( "</tr>\n" );
	} 
    echo ( "</tbody>\n" );
	echo( "</table></div>\n" );
	
	?>
