<?php include('../connexion/_connexion.php');
function noCommande(){

	$date1 = date("ymd");
	$cocentre = "01";
	$numCommande = $cocentre.$date1;

	//création de la requête SQL:
	$sql="select MAX(no_commande) from COMMANDE where no_commande LIKE ('".$numCommande."%');";

	//exécution de notre requête SQL:
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	if(is_null($row['MAX(no_commande)'])){
		$noCommande=$numCommande."00";
		return $noCommande;
	}
	else{
		$numCommande=$row['MAX(no_commande)'];
		$numCommande+=1;
		$numCommande="0".$numCommande;
		return $numCommande;
	}

}
?>
