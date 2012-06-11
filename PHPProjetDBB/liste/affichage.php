<?php

include('../connexion/_connexion.php');
mysql_query("SET NAMES UTF8");
//création:
$sql=$_POST['req'];

//éxécution:
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
