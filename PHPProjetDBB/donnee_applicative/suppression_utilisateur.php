<?php include('../connexion/_connexion.php');
mysql_query("SET NAMES UTF8");
	$query2 = "DELETE FROM UTILISATEUR WHERE id_utilisateur='".mysql_real_escape_string($_POST['id'])."';";

	$reponse2 = mysql_query($query2);

?>
