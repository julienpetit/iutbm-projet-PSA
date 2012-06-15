<?php 
session_start();
include('../connexion/_connexion.php');

require_once("../fonctionhtml.php");
require_once("../include/layout/layout.inc.php");

require_once("../include/library/bd.inc.php");
require_once("../include/library/library.inc.php");
require_once("../include/layout/layout.inc.php");

mysql_query("SET NAMES UTF8");
echo("<body>");
?>

<?php
$list_value = $_POST['list_value'];
if ($list_value=="piece"){
	echo("
			<script src='../controle/controle.js' ></script>
			<br/>
			<a class='small blue nice button radius' id='add_piece' value='Ajouter pièce' onclick='Form_ajout_piece()'>Ajouter Pièce</a>
			<div id='tab'>\n
			<table  id=\"tableau\" >\n
			<thead>\n
			<tr>\n
			<th>Référence Pièce</th>\n
			<th>Désignation Pièce</th> \n
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
			<br/>
			<a class='small blue nice button radius' id='add_fournisseur' value='Ajouter fournisseur' onclick='Form_ajout_fournisseur()'>Ajouter Fournisseur</a>
			<div id='tab'>\n
			<table id=\"tableau\">\n
			<thead>
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

	$query ="SELECT f.id_fournisseur, f.nom_fournisseur, cofor, f.nom_dest_commande, f.code_mode_ref_vehicule, m.libelle_mode_ref_vehicule, a.libelle_type_piece_2, count(c.no_commande)
	FROM FOURNISSEUR f
	INNER JOIN MODE_REF_VEHICULE m ON f.code_mode_ref_vehicule = m.code_mode_ref_vehicule
	LEFT JOIN APPROVISIONNE a ON f.id_fournisseur=a.id_fournisseur
	LEFT JOIN COMMANDE c ON c.id_fournisseur = f.id_fournisseur
	GROUP BY f.id_fournisseur
	ORDER BY f.id_fournisseur;";

	$reponse =  mysql_query($query);

	while ( $line =  mysql_fetch_array($reponse) )
	{
		echo("
				<tr >\n
				<td onclick='Modifier_fournisseur(\"".$line[0]."\")' >".$line[0]."</td>
				<td onclick='Modifier_fournisseur(\"".$line[0]."\")' >".$line[1]."</td>
				<td onclick='Modifier_fournisseur(\"".$line[0]."\")' >".$line[2]."</td>
				<td onclick='Modifier_fournisseur(\"".$line[0]."\")'>".$line[3]."</td>\n
				<td onclick='Modifier_fournisseur(\"".$line[0]."\")'>".$line[5]."</td> \n
				<td onclick='Modifier_fournisseur(\"".$line[0]."\")'>".$line[6]."</td>
				<td>
				");
		if($line[7] == 0){
			echo("
					<a href='#' onClick='suppression_fournisseur(\"".$line[0]."\")'>
					<img src='delete.png'>
					</a>
					");
		}
		echo("
				</td>\n
				</tr>\n
				");
	}

	print("</table><br />\n");
	print("</div>");
}
else if ($list_value=="silouhette"){
	echo("
			<br/>
			<a class='small blue nice button radius' id='add_silouhette' value='Ajouter silouhette' onclick='Form_ajout_silouhette()'>Ajouter Silhouette</a>
			<div id='tab'>\n
			<table id=\"tableau\">\n
			<thead>
			<tr>\n
			<th>Code Silhouette</th>\n
			<th>Libellé Silhouette</th>\n
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
	echo("
			<br/>
			<a class='small blue nice button radius' id='add_utilisateur' value='Ajouter utilisateur' onclick='Form_ajout_utilisateur()'>Ajouter Utilisateur</a>
			<div id='tab'>\n
			<table id=\"tableau\">\n
			<thead>
			<tr>\n
			<th>Id Utilisateur</th>\n
			<th>Nom</th>
			<th>Prénom</th>
			<th>Service</th>
			<th>Téléphone</th>
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
