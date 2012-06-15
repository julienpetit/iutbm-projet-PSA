<?php include('../connexion/_connexion.php');
mysql_query("SET NAMES UTF8");


		$query2="INSERT INTO PIECE values('".$_POST['reference']."','".$_POST['designation']."');";

		$reponse2  = mysql_query($query2);
		
?>
