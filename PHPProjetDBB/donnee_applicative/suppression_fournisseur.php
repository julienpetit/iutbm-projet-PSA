<?php include('../connexion/_connexion.php');
mysql_query("SET NAMES UTF8");
	$query2 = "DELETE FROM FOURNISSEUR WHERE id_fournisseur='".$_POST['id']."';";

	$reponse2  = mysql_query($query2);
	
?>
