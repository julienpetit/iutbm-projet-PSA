<?php include('../connexion/_connexion.php');
mysql_query("SET NAMES UTF8");
//recuperation du numero de l'abonne dans l'url
$fournisseur_select=$_POST['noFournisseur'];

//création de la requête SQL:
$sql="SELECT f.id_fournisseur, f.nom_fournisseur, cofor, f.nom_dest_commande, f.code_mode_ref_vehicule, m.libelle_mode_ref_vehicule, a.libelle_type_piece_2, d.adresse_email
FROM FOURNISSEUR f, MODE_REF_VEHICULE m , APPROVISIONNE a, COPIE_COMMANDE c, DEST_COMMANDE d
WHERE f.code_mode_ref_vehicule = m.code_mode_ref_vehicule AND a.id_fournisseur=f.id_fournisseur AND d.id_fournisseur=f.id_fournisseur
AND f.id_fournisseur = '".$fournisseur_select."';";

//exécution de notre requête SQL:
$result = mysql_query($sql);

			// AFFICHAGE DU TABLEAU:

$row = mysql_fetch_assoc($result);


echo"
<form id=\"myform\">

<label id=\"label\" for=\"id_fournisseur\">id fournisseur:</label>
<input type=\"text\" readonly name=\"id_fournisseur\" id=\"id_fournisseur\" value='".$row['id_fournisseur']."' /><br/>

<label id=\"label\" for=\"nom_fournisseur\">nom fournisseur:</label>
<input type=\"text\" name=\"nom_fournisseur\" id=\"nom_fournisseur\" value='".$row['nom_fournisseur']."' /><br/>

<label id=\"label\" for=\"cofor\">COFOR:</label>
<input type=\"text\" name=\"cofor\" id=\"cofor\" value='".$row['cofor']."' /><br/>

<label id=\"label\" for=\"nom_dest_commande\">Nom destinataire commande:</label>
<input type=\"text\" name=\"nom_dest_commande\" id=\"nom_dest_commande\" value='".$row['nom_dest_commande']."'/><br/>

<label id=\"label\" for=\"mail_dest_commande\">Mail destinataire</label>
<input type=\"text\" id=\"mail_dest_commande\" value=\"".$row['adresse_email']."\"/><br />
        
<label id=\"label\" for=\"mail_copie_commande\">Mail copie</label>
<select type=\"text\" id=\"mail_copie_commande\" value=\"\">";

$query1="SELECT adresse_email FROM COPIE_COMMANDE WHERE id_fournisseur='".$row['id_fournisseur']."';";
						
	$reponse1=mysql_query($query1);
						
	while ( $line1 =  mysql_fetch_array($reponse1) ) 
	{  
		print("<option value='".$line1[0]."'>".$line1[0]."</option>");
	}  

echo"
</select><br /><br/>
<label id=\"label\" for=\"approvisionne\">approvisionne</label>
<input type=\"text\" id=\"approvisionne\" value=\"".$row['libelle_type_piece_2']."\"/><br />

<label id=\"label\">Libelle mode ref vehicule:</label>
<select name=\"libelle_mode_ref_vehicule\" id=\"code_mode_ref_vehicule\">
";

	$query="SELECT code_mode_ref_vehicule,libelle_mode_ref_vehicule FROM MODE_REF_VEHICULE;";
						
	$reponse=mysql_query($query);
						
	while ( $line =  mysql_fetch_array($reponse) ) 
	{  
		if ($line[1] == $row['libelle_mode_ref_vehicule']){
		print("<option selected value='".$line[0]."'>".$line[1]."</option>");
		}
		else
		print("<option value='".$line[0]."'>".$line[1]."</option>");
	}  

echo"
</select>

<br/>
<button type=\"button\" id=\"but_mod\" onClick=\"Sauvegarde_fournisseur()\">Sauvegarder</button>
<button type=\"button\" onClick=\"choix_table('fournisseur')\" >Annuler</button>
</form>";


mysql_close();
?>
