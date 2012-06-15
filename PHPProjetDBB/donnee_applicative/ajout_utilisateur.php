<?php include('../connexion/_connexion.php');

mysql_query("SET NAMES UTF8");
	$query = "INSERT INTO UTILISATEUR values ('".$_POST['code']."','".$_POST['nom']."','".$_POST['prenom']."','".$_POST['service']."','".$_POST['tel']."','".$_POST['email']."', md5('".$_POST['mdp']."'));";
	$reponse = mysql_query($query);
	
	for($i=0;$i<$_POST['nb_droits'];$i++){
		$query ="INSERT INTO POSSEDE values('".$_POST['droit_'.$i]."','".$_POST['code']."' )";
		$reponse = mysql_query($query);
	}

?>
