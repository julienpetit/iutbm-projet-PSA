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
include "../../include/classes/fpdf.php";
include "../../include/classes/pdf.class.php";
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


// $pdf = new PDF($link);

$date = date("Y-m-d");
$heure = date("H:i");
 

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
	
	if($modeleCommande->isCanceled($noCommande))
	{
		echo "Vous ne pouvez pas modifier les livraisons car la commande à été annulée.";
		exit();
	}
	if($modeleCommande->isClosed($noCommande))
	{
		echo "Vous ne pouvez pas modifier les livraisons car la commande à été fermée.";
		exit();	
	}
	
	$modeleLivraison->removeLivraisonsByCommande($noCommande);
	
	if(isset($_POST['livraisons']))
	{
		foreach($_POST['livraisons'] as $livraison)
		{
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

	if(!$modeleCommande->isCommandeDeMasse($noCommande))
	{
		$_SESSION['message'] = "La commande n'est pas une commande de masse.";
		header("Location: ../../"); 
		exit();
	}
	if($modeleCommande->isCanceled($noCommande))
	{
		$_SESSION['message'] = "La commande $noCommande est annulée, vous ne pouvez plus la modifier.";
		header("Location: ./?visualiser=$noCommande"); 
		exit();
	}
	if($modeleCommande->isClosed($noCommande))
	{
		$_SESSION['message'] = "La commande $noCommande est fermée, vous ne pouvez plus la modifier.";
		header("Location: ./?visualiser=$noCommande");
		exit();
	}

	$commande = $modeleCommande->getCommande($noCommande);

	// Récupération de l'utilisateur qui à passé la commande
	$userCommande = $modeleUtilisateur->getUtilisateur($commande['id_utilisateur_passe']);
	
	$pieces = $modelePiece->getPieceByCommandeId($noCommande);

	$method = 'modif';
	include "view/formulaireModification.html.php";

	
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
	$piecesPrincipales = $modelePiece->piecesParser(isset($_POST['piecesPrinc']) ? $_POST['piecesPrinc'] : array());
	$piecesEnvironnement = $modelePiece->piecesParser(isset($_POST['piecesEnv']) ? $_POST['piecesEnv'] : array());

	$modeleCommande->updateCommande($noCommande, $infosCommande);
	$modelePiece->addPiecesToCommande($noCommande, $piecesPrincipales, $piecesEnvironnement);

	$modeleCadence->addPieceToCadence($noCommande, $piecesPrincipales);
	
	header("Location: ./?visualiser=$noCommande");
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
	
	if(!$modeleCommande->isCommandeDeMasse($noCommande))
	{
		$_SESSION['message'] = "La commande n'est pas une commande de masse.";
		header("Location: ../../");
		exit();
	}
	
	
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

	if(!$modeleCommande->isCommandeDeMasse($noCommande))
	{
		$_SESSION['message'] = "La commande n'est pas une commande de masse.";
		header("Location: ../../");
		exit();
	}
	
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
	
	$modeleCommande->annulerCommande($noCommande, $user['id_utilisateur']);
	header("Location: ./?visualiser=".$noCommande);
	exit();
}
/**
 * ################################ Fin annulation d'une commande ################################
 */





/**
 * ################################ Fermeture d'une commande ################################
 */
if(isset($_GET['fermer']) && $_GET['fermer'] != ""){
	$noCommande = html($_GET['fermer']);
	
	if(isset($_GET['motif'])) $motif = html($_GET['motif']);
	else $motif = "";
	
	$modeleCommande->fermerCommande($noCommande, $user['id_utilisateur'], $motif);
	header("Location: ./?visualiser=".$noCommande);
	exit();
}
/**
 * ################################ Fin Fermeture d'une commande ################################
 */

/**
 * Generation du pdf
 */
if(isset($_GET['genererPdf']) && $_GET['genererPdf'] != ""){
	$noCommande = html($_GET['genererPdf']);
	
	$pdf = new PDF();
	
	$commande = $modeleCommande->getCommande($noCommande);
	$entite = $modeleEntite->getEntite($commande['code_imputation']);
	$user = $modeleUtilisateur->getUtilisateur($commande['id_utilisateur_passe']);
	
	$pieces = $modelePiece->getPieceByCommandeId($noCommande);
	
	// Instanciation de la classe dérivée
	$pdf->AliasNbPages();
	$pdf->AddPage('L');
	// Titre
	//Corps de la page
	
	// Décalage à droite
	//$pdf->Cell(20);
	
	//num commande
	$pdf->SetFont('Times','B',30);
	$pdf->Ln(30);
	$pdf->Cell(175,15,utf8_decode('Commande de masse N°'.$noCommande),0,0,'L');
	$pdf->SetFont('Times','',12);
	$pdf->Cell(60,10,$commande['libelle_type_chantier']." ".$commande['no_chantier'],0,0,'C');
	$pdf->MultiCell(30,5,utf8_decode($entite['libelle'])."\n\nSur CA:  ".$entite['no'],0,'L',0);
	$pdf->Rect(245,44,35,8);
	$pdf->Rect(245,52,35,8);
	
	
	
	//Début feuille de commande masse
	
	//Demandeur
	$pdf->Ln(20);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(40,8,'Demandeur ',0,0,'L');
	
	$pdf->MultiCell(120,8,$user['nom_utilisateur']." ".$user['prenom_utilisateur']."\n".$user['service_utilisateur'],0,'L',0);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(120,-8,utf8_decode("Tél. ".$user['no_telephone']),0,0,'R');
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln(20);
	
	//tableau commande
	//faire le découpage de chaque cellule avec multicelle pour aligner le tout et border que haut et bas
	
	$pdf->Cell(40,10,"Type piece",1,0,'C');
	$pdf->Cell(40,10,"Reference",1,0,'C');
	$pdf->Cell(120,10,"Designation",1,0,'C');
	$pdf->Cell(30,10,"Quantite",1,0,'C');
	$pdf->Cell(40,10,"Potentiel/j",1,1,'C');
	$pdf->SetFont('Arial','',10);
	
	foreach($pieces['principales'] as $piece)
	{
		$pdf->Cell(40,10,"Principale",1,0,'L');
		$pdf->Cell(40,10,$piece['reference'],1,0,'L');
		$pdf->Cell(120,10,utf8_decode($piece['libelle']),1,0,'L');
		$pdf->Cell(30,10,$piece['quantite'],1,0,'L');
		$pdf->Cell(40,10,$piece['potentiel'],1,1,'L');
	}

	
	foreach($pieces['principales'] as $piece)
	{
		$pdf->Cell(40,10,"Secondaire",1,0,'L');
		$pdf->Cell(40,10,utf8_decode($piece['reference']),1,0,'L');
		$pdf->Cell(120,10,$piece['quantite'],1,0,'L');
		$pdf->Cell(30,10,$piece['potentiel'],1,1,'L');
	}
	
	$pdf->SetFont('Arial','',8);
	

	
	$file_name = "../Historique_commande/commande_masse/commande_".$noCommande."_".microtime().".pdf";
	if (file_exists($file_name))
	{
		$file_type = filetype($file_name);
		$file_size = filesize($file_name);
	
		$handle = fopen($file_name, 'r') or die('File '.$file_name.'can t be open');
		$content = fread($handle, $file_size);
		$content = chunk_split(base64_encode($content));
		$f = fclose($handle);
	
	}
	
	$pdf->Output($file_name, "F");
	
	
	header("Location: $file_name");
	exit();
}



?>