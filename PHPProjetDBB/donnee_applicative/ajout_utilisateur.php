<?php

	include('../connexion/_connexion.php');
	
	mysql_query("SET NAMES UTF8");
	$query = "INSERT INTO UTILISATEUR values ('".$_POST['code']."','".mysql_real_escape_string($_POST['nom'])."','".mysql_real_escape_string($_POST['prenom'])."','".mysql_real_escape_string($_POST['service'])."','".mysql_real_escape_string($_POST['tel'])."','".mysql_real_escape_string($_POST['email'])."', md5('".$_POST['mdp']."'));";
	$reponse = mysql_query($query);
	
	for($i=0;$i<$_POST['nb_droits'];$i++){
		$query ="INSERT INTO POSSEDE values('".mysql_real_escape_string($_POST['droit_'.$i])."','".mysql_real_escape_string($_POST['code'])."' )";
		$reponse = mysql_query($query);
	}

?>
