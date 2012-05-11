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


function nb2chiffres($nb){
	return sprintf("%02d", $nb);
}


function sql($sql){
	$cmd = array("DISTINCT", "NOT IN", "SELECT", "UPDATE", "DELETE", "GROUP BY", "HAVING", "FROM", "ON", "INNER JOIN", "WHERE", "ORDER BY", "AND");
	$newCmd = array();

	foreach($cmd as $object):
		array_push($newCmd, "<br /><em class='header_sql'>$object</em>");
	endforeach;

	return str_replace($cmd, $newCmd, $sql);
}

function print_r_html ($arr) {
	echo "<pre>";
        print_r($arr);
    echo "</pre>";
}

?>