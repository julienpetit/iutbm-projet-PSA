<?php include('../connexion/_connexion.php');

mysql_query("SET NAMES UTF8");
$id_fournisseur = $_POST['id_fournisseur'];
$nom_fournisseur = $_POST['nom_fournisseur'];
$code_mode_ref_vehicule = $_POST['code_mode_ref_vehicule'];
$nom_dest_commande = $_POST['nom_dest_commande'];
$cofor = $_POST['cofor']; 

   
if(!empty($id_fournisseur) && !empty($nom_fournisseur) && !empty($code_mode_ref_vehicule) &&!empty($nom_dest_commande) && !empty($cofor))
{
	//création de la requête SQL:
	$sql_save="UPDATE FOURNISSEUR SET id_fournisseur = '$id_fournisseur', nom_fournisseur = '$nom_fournisseur', cofor = '$cofor', nom_dest_commande='$nom_dest_commande', code_mode_ref_vehicule='$code_mode_ref_vehicule' WHERE id_fournisseur = '$id_fournisseur';";
	//exécution de notre requête SQL:
	$result_save = mysql_query($sql_save) or die( mysql_error());

	exit();
}
else
{ 
  echo("Des champs sont vides");
  header("Refresh: 3000;URL= maj.php/modif_fournisseur.php");
}
mysql_close();
?>
