<?php

	include('../connexion/_connexion.php');
	
	mysql_query("SET NAMES UTF8");
	$query2 = "INSERT INTO SILHOUETTE values ('".$_POST['code']."','".$_POST['libelle']."');";
	
	$reponse2 = mysql_query($query2);

?>
