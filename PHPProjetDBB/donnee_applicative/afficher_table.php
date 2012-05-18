<?php 
session_start(); 
include('../connexion/_connexion.php');

require_once("../fonctionhtml.php");  

html_entete_fichier("accueil","../Style.css","script.js","../controle/controle.js");
mysql_query("SET NAMES UTF8");
echo("<body>");
?>

<?php
$list_value = $_POST['list_value'];
if ($list_value=="piece"){
	echo("
		<input type='button' id='add_piece' value='Ajouter pièce' onclick='Form_ajout_piece()'/><br/><br/>
		<div id=\"tab\">
		<table  id=\"tableau\" >\n
			<thead>\n
				<tr>\n
					<th>Reference Piece</th>\n
					<th>Designation Piece</th> \n
					<th>Supprimer</th>\n
				</tr>\n
			</thead>\n
		"); 

		$query ="SELECT * FROM PIECE;";

		$reponse =  mysql_query($query); 
	
		while ( $line =  mysql_fetch_array($reponse) ) 
		{  
		
		 	// Récupère la ligne suivante d'un jeu de résultats 
			echo("
				<tr onclick='Modifier_piece(\"".$line[0]."\")'>\n
					<td>".$line[0]."</td>
					<td>".$line[1]."</td>\n
					
					<td>
						<a href='#' onClick='suppression_piece(\"".$line[0]."\")'>
							<img src='delete.png'>
						</a>
					</td>\n
				</tr>\n
			");  
		} 
	echo("
		</table><br />\n
		</div>\n
	");
}
else if ($list_value=="fournisseur"){
		echo("
		<input type='button' id='add_fournisseur' value='Ajouter fournisseur' onclick='Form_ajout_fournisseur()'/><br/><br/>
		<div id='tab'>\n
			<table id=\"tableau\">\n
			<thead>\n
				<tr>\n
					<th>Identifiant Fournisseur</th>\n
					<th>Nom Fournisseur</th> 
					<th>Code Fournisseur</th>
					<th>Nom Destinataire Commande</th> \n
					<th>Code référence véhicule</th>\n
					<th>Approvisionne</th>\n
					<th>Supprimer</th>\n
				</tr>\
			</thead>\n
		"); 

		$query ="SELECT f.id_fournisseur, f.nom_fournisseur, cofor, f.nom_dest_commande, f.code_mode_ref_vehicule, m.libelle_mode_ref_vehicule, a.libelle_type_piece_2 
						FROM FOURNISSEUR f, MODE_REF_VEHICULE m ,APPROVISIONNE a
						WHERE f.code_mode_ref_vehicule = m.code_mode_ref_vehicule AND f.id_fournisseur=a.id_fournisseur 
						ORDER BY f.id_fournisseur;";

		$reponse =  mysql_query($query); 
	
		while ( $line =  mysql_fetch_array($reponse) ) 
		{  
		
			$query2 = " select ;";
		 	// Récupère la ligne suivante d'un jeu de résultats 
			echo("
				<tr >\n
					<td onclick='Modifier_fournisseur(\"".$line[0]."\")' >".$line[0]."</td>
					<td onclick='Modifier_fournisseur(\"".$line[0]."\")' >".$line[1]."</td>
					<td onclick='Modifier_fournisseur(\"".$line[0]."\")' >".$line[2]."</td>
					<td onclick='Modifier_fournisseur(\"".$line[0]."\")'>".$line[3]."</td>\n
					<td onclick='Modifier_fournisseur(\"".$line[0]."\")'>".$line[5]."</td> \n
					<td onclick='Modifier_fournisseur(\"".$line[0]."\")'>".$line[6]."</td>
					<td>
						<a href='#' onClick='suppression_fournisseur(\"".$line[0]."\")'>
							<img src='delete.png'>
						</a>
					</td>\n
				</tr>\n
			"); 
		} 	

		print("</table><br />\n"); 
	print("</div>");
}
else if ($list_value=="silouhette"){
	echo("
		<input type='button' id='add_silouhette' value='Ajouter Silouhette' onclick='Form_ajout_silouhette()'/><br/><br/>
		<div id=\"tab\">
			<table id=\"tableau\">\n
			<thead>
				<tr>\n
					<th>Code Silouhette</th>\n
					<th>Libelle Silouhette</th>\n
					<th>Supprimer</th>\n
				</tr>
			</thead>\n
		"); 

		$query ="SELECT * FROM SILHOUETTE;";

		$reponse =  mysql_query($query); 
	
		while ( $line =  mysql_fetch_array($reponse) ) 
		{  
		
		 	// Récupère la ligne suivante d'un jeu de résultats 
			echo("
				<tr >\n
					<td onclick='Modifier_silouhette(\"".$line[0]."\")' >".$line[0]."</td>
					<td onclick='Modifier_silouhette(\"".$line[0]."\")' >".$line[1]."</td>\n
					
					<td>
						<a href='#' onClick='suppression_silouhette(\"".$line[0]."\")'>
							<img src='delete.png'>
						</a>
					</td>\n
				</tr>\n
			"); 
		} 
		print("</table><br />\n"); 
	print("</div>");
}
else if ($list_value=="utilisateur"){
		echo("<input type='button' id='add_utilisateur' value='Ajouter utilisateur' onclick='Form_ajout_utilisateur()'/><br/><br/>
		<div id=\"tab\">
			<table id=\"tableau\">\n
			<thead>
				<tr>\n
					<th>Id Utilisateur</th>\n
					<th>Nom</th>
					<th>Prenom</th>
					<th>service</th>
					<th>Telephone</th>
					<th>Email</th>
					<th>Droit</th>
					<th>Supprimer</th>\n
				</tr>
			</thead>\n
		"); 

		$query ="SELECT * FROM UTILISATEUR;";

		$reponse =  mysql_query($query); 
	
		while ( $line =  mysql_fetch_array($reponse) ) 
		{  
		
		 	// Récupère la ligne suivante d'un jeu de résultats 
			echo("
			<tr>\n
				<td onclick='Modifier_utilisateur(\"".$line[0]."\")' >".$line[0]."</td>\n
				<td onclick='Modifier_utilisateur(\"".$line[0]."\")' >".$line[1]."</td>\n
				<td onclick='Modifier_utilisateur(\"".$line[0]."\")' >".$line[2]."</td>\n
				<td onclick='Modifier_utilisateur(\"".$line[0]."\")'>".$line[3]."</td>\n
				<td onclick='Modifier_utilisateur(\"".$line[0]."\")' >".$line[4]."</td>\n
				<td onclick='Modifier_utilisateur(\"".$line[0]."\")'>".$line[5]."</td>\n
				<td onclick='Modifier_utilisateur(\"".$line[0]."\")' id='code_mod_ref_vehicule' name='code_mod_ref_vehciule' >");
			
			$query2="SELECT d.no_droit, d.description_droit FROM DROIT d, POSSEDE p WHERE p.id_utilisateur = '".$line[0]."' AND d.no_droit = p.no_droit;";
						
			$reponse2=mysql_query($query2);
		
			while ( $row =  mysql_fetch_array($reponse2) ) 
			{  
				// Récupère la ligne suivante d'un jeu de résultats 
				echo("<div id='".$row[0]."' class='option'>".$row[1]."</label>");
			}
	echo ("
			</td>		
			<td>
				<a href='#' onClick='suppression_utilisateur(\"".$line[0]."\")'>
					<img src='delete.png'>
				</a>
			</td>\n
		</tr>\n
	"); 
		} 
	echo("
		</table><br />\n 
		</div>
	");
}
else if ($_POST['list_value']==""){
	echo "Vous n'avez pas sélectionné de table. ";
}
?>	
