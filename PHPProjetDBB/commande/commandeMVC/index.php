<?php 
include "../../include/library/bd.inc.php";
include "../../include/library/library.inc.php";
include "../../include/library/constantes.inc.php";
include "../../include/classes/commande.class.php";
include "../../include/classes/entite.class.php";
include "../../include/classes/piece.class.php";
//include "../../include/classes/cadence.class.php";

include ROOT . "/include/layout/layout.inc.php";

$modeleCommande = new Commande($link);
$modelePiece = new Piece($link);
$modeleEntite = new Entite($link);

/**
 * Ajax --> Widget Pièces - Recherche de pièces
 */
if (isset($_GET['ajax']) && $_GET['ajax'] == "recherchePieces"){
	$chaine = html($_POST['chaine']);
	$where = " WHERE reference_piece LIKE '%$chaine%' OR designation_Piece LIKE '%$chaine%'";
	$modelePiece->displayListePieces($where);
	exit();
}


/**
* Ajax --> Widget Pièces - Recherche de pièces
*/
if (isset($_GET['ajax']) && $_GET['ajax'] == "affichageFormulaireAjoutPieceCommande"){

	$reference = html($_POST['reference']);
	$libelle = html($_POST['libelle']);
	
	$modeleCommande->displayChoiceBox($reference, $libelle);
	exit();
}



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
	
	print_r_html($_POST);
	exit();
}



/**
* Modification d'une commande
*/
if (isset($_GET['modifier']) && $_GET['modifier'] != ""){
	$noCommande = html($_GET['modifier']);
	
	
	$commande = $modeleCommande->getCommande($noCommande);
	
	$pieces = $modelePiece->getPieceByCommandeId($noCommande);
	
	$method = 'modif';
	include "view/formulaireModification.html.php";

	print_r_html($commande = $modeleCommande->getCommande($noCommande));
	exit();
}

/**
* Modification - Soumission du formulaire
*/
if (isset($_GET['action']) && $_GET['action'] == "modif"){

	print_r_html($_POST);
	exit();
}


?>