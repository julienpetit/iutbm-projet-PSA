<?php 
function html($texte) 
{
	return isset($texte) ? htmlspecialchars(stripslashes($texte), ENT_QUOTES, 'UTF-8') : "";
}

function printHtml($texte) 
{
	echo html($texte);
}

// Conversion date : AAAA-MM-JJ -> jeudi 10 novembre 2011
function convertDate_Amj_string($date) 
{
	setlocale (LC_TIME, 'fr_FR','fra'); 
	return strftime("%A %d %B %Y", strtotime($date)); 
}

// Conversion date : AAAA-MM-JJ -> JJ/MM/AAA
function convertDate_Amj_jmA($date)
{
	setlocale (LC_TIME, 'fr_FR','fra'); 
	return strftime("%d/%m/%Y", strtotime($date)); 
}

// Conversion de 1 -> 01
function nb2chiffres($nb){
	return sprintf("%02d", $nb);
}

// Sql formatter
function sql($sql){
	$cmd = array("DISTINCT", "NOT IN", "SELECT", "UPDATE", "DELETE", "GROUP BY", "HAVING", "FROM", "ON", "INNER JOIN", "WHERE", "ORDER BY", "AND");
	$newCmd = array();

	foreach($cmd as $object):
		array_push($newCmd, "<br /><em class='header_sql'>$object</em>");
	endforeach;

	return str_replace($cmd, $newCmd, $sql);
}

// Affiche un tableau dans des balises pre
function print_r_html ($arr) {
	echo "<pre>";
        print_r($arr);
    echo "</pre>";
}

function noCommandeMysqli($link){

	$date1 = date("ymd");
	$cocentre = "01";
	$numCommande = $cocentre.$date1;

	//création de la requête SQL:
	$sql="select MAX(no_commande) from COMMANDE where no_commande LIKE ('".$numCommande."%');";

	//exécution de notre requête SQL:
	$result = mysqli_query($link, $sql);
	$row = mysqli_fetch_assoc($result);
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