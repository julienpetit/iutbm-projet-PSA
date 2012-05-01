<?php 
include "../../include/library/bd.inc.php";
include "../../include/library/library.inc.php";
include "../../include/classes/commande.class.php";
include "../../include/classes/entite.class.php";
include "../../include/classes/piece.class.php";
//include "../../include/classes/cadence.class.php";

$modeleCommande = new Commande($link);




/**
 * Ajout d'une nouvelle commande
 */
if (isset($_GET['ajout'])){
	
	
	$method = 'ajout';
	include "view/formulaireAjout.html.php";
	exit();
}

/**
* Ajout - Soumission du formulaire
*/
if (isset($_GET['action']) && $_GET['action'] == "ajout"){
	
	print_r($_POST);
	exit();
}



/**
* Modification d'une commande
*/
if (isset($_GET['ajout'])){


	$method = 'add';
	include "view/formulaireAjout.html.php";
	echo "bonjour";
	exit();
}


?>