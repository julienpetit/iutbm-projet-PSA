<?php 
include "../../include/library/bd.inc.php";
include "../../include/library/library.inc.php";
include "../../include/library/constantes.inc.php";
include "../../include/classes/commande.class.php";
include "../../include/classes/entite.class.php";
include "../../include/classes/piece.class.php";
include "../../include/classes/utilisateur.class.php";
include "../../include/classes/cadence.class.php";
include "../../include/classes/livraison.class.php";
include "../../include/layout/layout.inc.php";

// Vérification de l'identité de l'utilisateur
session_start();
include('../../connexion/_connexion.php');
mysql_query("SET NAMES UTF8");
require_once("../../fonctionhtml.php");
require_once("../../connexion/verification_connexion.php");

check_log_user(2,NULL); //vérifie si l'utilisateur a bien le droit d'accèder a cette page.

$modeleUtilisateur = new Utilisateur($link);
$user = $modeleUtilisateur->getUtilisateur(html($_SESSION['id']));

$modeleCommande = new Commande($link);
$modelePiece = new Piece($link);
$modeleEntite = new Entite($link);
$modeleCadence = new Cadence($link);
$modeleLivraison = new Livraison($link);

$date = date("Y-m-d");
$heure = date("H:i");
 

//print_r_html($user);
/**
 * ################################ Requetes Ajax #######################################
 */
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
 * Ajax --> Ajout de Piece
 */
if (isset($_GET['ajax']) && $_GET['ajax'] == "affichageFormulaireAjoutPiece"){
	$modelePiece->displayAjoutPieces();
	
	
	exit();
}

/**
 * Ajax --> Enregistrement ajout piece
 */
if (isset($_GET['ajax']) && $_GET['ajax'] == "EnregistreAjoutPiece"){
	
	$reference=html($_POST["reference"]);
	$libelle=html($_POST["libelle"]);
	
	$modelePiece->addPiece($reference ,$libelle);
	
	exit();
}

/**
 * Ajax --> Enregistrement d'es livraisons
 */
if (isset($_GET['ajax']) && $_GET['ajax'] == "ajoutLivraisons"){

	$noCommande = html($_POST['noCommande']);
	
	$modeleLivraison->removeLivraisonsByCommande($noCommande);
	
	if(isset($_POST['livraisons']))
	{
		foreach($_POST['livraisons'] as $livraison)
		{
			print_r_html($livraison);
			$modeleLivraison->addLivraisonToCommande($noCommande, html($livraison['numPiece']), convertDate_jmA_Amj(html($livraison['date'])), html($livraison['quantite']));
		}
	}
	exit();
}



/**
 * ################################ Fin Requetes Ajax #######################################
 */









/**
 * ################################ Ajout d'une nouvelle commande ################################
 */
if (isset($_GET['ajout'])){
	$noCommande = noCommandeMysqli($link);
	$method = 'ajout';
	include "view/formulaireAjout.html.php";
	exit();
}

/**
* Ajout - Soumission du formulaire
*/
if (isset($_GET['action']) && $_GET['action'] == "ajout"){
	$noCommande = html($_POST['no_commande']);
	// récupération des infos de la commande
	$infosCommande = array('no_commande' 			=> $noCommande,
						   'date_commande'			=> html($_POST['date_commande']),
						   'heure_commande'			=> html($_POST['heure_commande']),
						   'libelle_type_chantier'  => html($_POST['ReferenceDossierCommandeMasse']),
						   'code_imputation' 		=> html($_POST['EntiteCM']),
						   'no_chantier'			=> html($_POST['noDossier']),
						   'code_type_commande' 	=> 'M',
						   'id_utilisateur_passe' 	=> html($_POST['id_user']) 
			);
	
	// récupération des pièces de la commande
	$piecesPrincipales = $modelePiece->piecesParser(isset($_POST['piecesPrinc']) ? $_POST['piecesPrinc'] : array());
	$piecesEnvironnement = $modelePiece->piecesParser(isset($_POST['piecesEnv']) ? $_POST['piecesEnv'] : array());
	
	$modeleCommande->addCommande($infosCommande);
	$modelePiece->addPiecesToCommande($noCommande, $piecesPrincipales, $piecesEnvironnement);
	$modeleCadence->addPieceToCadence($noCommande, $piecesPrincipales);
	//print_r_html($_POST);
	
	header("Location: /commande/commandeMVC/?visualiser=".$noCommande);
	exit();
}

/**
 * ################################ Fin Ajout d'une nouvelle commande ################################
 */












/**
 * ################################ Modification d'une commande ################################
 */
if (isset($_GET['modifier']) && $_GET['modifier'] != ""){
	$noCommande = html($_GET['modifier']);


	$commande = $modeleCommande->getCommande($noCommande);

	// Récupération de l'utilisateur qui à passé la commande
	$userCommande = $modeleUtilisateur->getUtilisateur($commande['id_utilisateur_passe']);
	
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
	// récupération du no de la commande
	$noCommande = html($_POST['noCommande']);
	
	// récupération des infos de la commande
	$infosCommande = array('libelle_type_chantier'  => html($_POST['ReferenceDossierCommandeMasse']),
						   'code_imputation' 		=> html($_POST['EntiteCM']),
						   'no_chantier'			=> html($_POST['noDossier']),
						   'code_type_commande' 	=> 'M');

	// récupération des pièces de la commande
	echo $noCommande;
	print_r_html($piecesPrincipales = $modelePiece->piecesParser(isset($_POST['piecesPrinc']) ? $_POST['piecesPrinc'] : array()));
	print_r_html($piecesEnvironnement = $modelePiece->piecesParser(isset($_POST['piecesEnv']) ? $_POST['piecesEnv'] : array()));

	$modeleCommande->updateCommande($noCommande, $infosCommande);
	$modelePiece->addPiecesToCommande($noCommande, $piecesPrincipales, $piecesEnvironnement);

	$modeleCadence->addPieceToCadence($noCommande, $piecesPrincipales);
	print_r_html($_POST);
	exit();
}
/**
 * ################################ Fin modification d'une commande ################################
 */









/**
 * ################################ Visualisation d'une commande ################################ 
 */
if (isset($_GET['visualiser']) && $_GET['visualiser'] != ""){
	// Récupération du numéro de commande
	$noCommande = html($_GET['visualiser']);
	
	// Récupération de la commande
	$commande = $modeleCommande->getCommande($noCommande);
	
	// Récupération de l'utilisateur qui à passé la commande 
	$userCommande = $modeleUtilisateur->getUtilisateur($commande['id_utilisateur_passe']);

	// Récupération des pièces de la commande
	$pieces = $modelePiece->getPieceByCommandeId($noCommande);

	$method = 'modif';
	include "view/visualisation.html.php";
	exit();
}
/**
 * ################################ Fin Visualisation d'une commande ################################
 */











/**
 * ################################  Détails - Livraisons d'une commande ################################ 
 */
if (isset($_GET['details']) && $_GET['details'] != ""){
	$noCommande = html($_GET['details']);


	$commande = $modeleCommande->getCommande($noCommande);
	
	// Récupération de l'utilisateur qui à passé la commande
	$userCommande = $modeleUtilisateur->getUtilisateur($commande['id_utilisateur_passe']);

	$pieces = $modelePiece->getPieceByCommandeId($noCommande);
	
	$method = 'modif';
	include "view/details.html.php";
	exit();
}
/**
 * ################################  Fin détails - Livraisons d'une commande ################################
 */

/**
 * ################################ Annulation d'une commande ################################
 */
if(isset($_GET['annuler']) && $_GET['annuler'] != ""){
	$noCommande = html($_GET['annuler']);
	$modeleCommande->annulerCommande($noCommande);
	header("Location: ./?visualiser=".$noCommande);
	exit();
}
/**
 * ################################ Fin annulation d'une commande ################################
 */



?>