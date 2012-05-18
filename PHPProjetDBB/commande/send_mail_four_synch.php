<?php

session_start();
include('../connexion/_connexion.php');
require('fpdf.php');
require_once("./nocommande.php");  
array_map('utf8_decode',$_POST);
mysql_query("SET NAMES UTF8");

if(isset($_POST['four']) && isset($_POST['ref']) && isset($_POST['quant']) && isset($_POST['des']) && isset($_POST['ref_vehicule']) && isset($_POST['codesil']) && isset($_POST['des_def']) 
&& isset($_POST['nomca']) && isset($_POST['numCA']) && isset($_POST['codesil']) && isset($_SESSION['pseudo']) && isset($_POST['mode_ref']))
{

$fournisseur = $_POST['four'];
$ref_piece = $_POST['ref'];
$quant_piece = $_POST['quant'];
$des_piece = $_POST['des'];
$visof=$_POST['ref_vehicule'];
$idvehicule=$_POST['codesil'];
$des_def = $_POST['des_def'];
$CAImp=$_POST['nomca'];
$numcaimp=$_POST['numCA'];
$codesil=$_POST['codesil'];
$idut=$_SESSION['pseudo'];
$titre=$_POST['mode_ref'];

$date = date("d/m/Y");
$datesql = date("Y-m-d");
$heure = date("h:i:s");
$numCommande = noCommande();

$sql3="SELECT libelle_entite FROM ENTITE WHERE code_imputation='".$numcaimp."';";
$req3 = mysql_query($sql3) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
$data3 = mysql_fetch_assoc($req3);

//SQL pour l'émetteur et tout le reste.
$sql2="SELECT nom_utilisateur, prenom_utilisateur, service_utilisateur,no_telephone FROM UTILISATEUR WHERE id_utilisateur='".$idut."';";
$req = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
$data = mysql_fetch_assoc($req);
$nomuti=$data['nom_utilisateur']." ".$data['prenom_utilisateur'];
$seruti=$data['service_utilisateur'];
$teluti=$data['no_telephone'];
$sql2="SELECT nom_dest_commande, nom_fournisseur FROM FOURNISSEUR WHERE id_fournisseur='".$fournisseur."';";
$req = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
$data = mysql_fetch_assoc($req);
$destinataire=$data['nom_dest_commande'];
$nom_destinataire=$data['nom_fournisseur'];
$sql2="SELECT libelle_silhouette FROM SILHOUETTE WHERE code_silhouette='".$idvehicule."';";
$req = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
$data = mysql_fetch_assoc($req);
$nom_vehicule=$data['libelle_silhouette'];



class PDF extends FPDF
{
	function Header()
	{
		$date = date("d/m/Y");
		$heure = date("h:i:s");
		$this->Image("psa-peugeot-citroen-logo.jpg",120,10,85,10);
		$this->SetFont('Arial','B',10);
		$this->Ln(5);
		$this->Cell(0,18,utf8_decode(" Mulhouse, Le : $date à $heure"),0,0,'R');
	}
	function Footer()
	{
   		// Positionnement à 1,5 cm du bas
   		$this->SetY(-35);
   		// Police Arial italique 8
   		$this->SetFont('Arial','I',8);
		$this->Cell(0,6,utf8_decode('Route de Chalampé CD 39 Le Napoléon 68100 Mulhouse France Téléphone 33 3 89 09 09 09 - fax 33 3 89 09 29 39'),0,1,'C');
		$this->Cell(0,6,utf8_decode('________________________________________________________________________'),0,1,'C');
		$this->SetFont('Arial','I',6);
		$this->Cell(0,6,utf8_decode('Peugeot Citroën Automobiles SA, Siège Social : Route de Gizy, 78943 Vélizy Villacoublay Cedex France Téléphone 33 1 57 59 30 00 - Fax 33 1 57 59 48 55'),0,1,'C');
		$this->Cell(0,6,utf8_decode('Société Anonyme au capital de 294 816 500 €, 542 065 479 RCS Versailles, Siret 542 065 479 000 991, APE 341 Z'),0,1,'C');

   
	}	
}

// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
// Titre
//Corps de la page

// Décalage à droite
//$pdf->Cell(20);

//num commande
$pdf->SetFont('Times','B',30);
$pdf->Ln(30);
$pdf->Cell(0,15,utf8_decode('Commande unitaire pièce synchrone'),0,1,'C');
$pdf->Cell(0,15,utf8_decode('N° '.$numCommande),0,1,'C');

//Fin entete
//Sql pour recup info fournisseur.
//Destinataire - à l'attention de :
$pdf->Ln(10);
$pdf->SetFont('Times','',12);
$pdf->Cell(50,10,'Destinataire : ',0,0,'L');
$pdf->Cell(50,10,"$nom_destinataire",0,1,'L');//Ligne destinataire
$pdf->Cell(50,10,'A l\'attention de :',0,0,'L');
$pdf->Cell(50,10,"$destinataire ",0,1,'L');//Ligne a l'attention
//Fin destinataire
//Sql pour infos emetteur
//Début Emetteur
$pdf->Ln(10);
$pdf->SetFont('Times','',12);
$pdf->Cell(50,11,'Demandeur : ',0,0,'L');
$pdf->MultiCell(150,10,utf8_decode("$nomuti \n$seruti \nTel : $teluti"),0,'L',0);//Ligne demandeur
$pdf->SetFont('Times','B',14);
$pdf->Ln(10);
$pdf->Cell(50,15,utf8_decode('Commande urgente à livrer au plus vite '),0,0,'L');
$pdf->SetFont('Times','',12);

//CA
$pdf->SetFont('Times','',12);
$pdf->MultiCell(120,4,utf8_decode("".$data3['libelle_entite']."\n\nSur CA:  $numcaimp"),0,'R',0);//Mettre variable
$pdf->Rect(145,153,35,8);
$pdf->Rect(145,161,35,8);
$pdf->Ln(5);
// find e CA

//Début feuille de commande masse
//tableau commande
//faire le découpage de chaque cellule avec multicelle pour aligner le tout et border que haut et bas
$pdf->Cell(0,10,"Reference :   $ref_piece                                     ".stripslashes(utf8_decode($des_piece)),1,1,'L');// remplacer les variables
$pdf->Cell(0,10,"Quantite :     $quant_piece",1,1,'L');// remplacer les variables
$pdf->Cell(0,10,"Vehicule:      $idvehicule / $nom_vehicule                                                                      $titre    $visof",1,1,'L');// remplacer les variables
$pdf->Cell(0,40,stripslashes(utf8_decode($des_def)),1,1,'L');

$pdf->Output("./Historique_commande/commande_sync/commande_$numCommande.pdf", "F");



$sql2="SELECT email_utilisateur FROM UTILISATEUR WHERE id_utilisateur='".$idut."';";
$req = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
$data = mysql_fetch_assoc($req);
$mailuti=$data['email_utilisateur'];
$sql2="SELECT adresse_email FROM DEST_COMMANDE WHERE id_fournisseur='".$fournisseur."';";
$req = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
$data = mysql_fetch_assoc($req);
$destcom=$data['adresse_email'];
$sql2="SELECT adresse_email FROM COPIE_COMMANDE WHERE id_fournisseur='".$fournisseur."';";
$req = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());

$data = mysql_fetch_assoc($req);

$copcom=$data['adresse_email'];


$boundary = md5(uniqid(microtime(), TRUE));

// Headers
$headers = 'From: '.$nomuti.' <'.$mailuti.'>'."\r\n";
$headers .= 'Mime-Version: 1.0'."\r\n";
$headers .= 'Content-Type: multipart/mixed;boundary='.$boundary."\r\n";
$headers .= "\r\n";
//entete message
$title="Commande Unitaire num$numCommande";

// Message
$msg = 'This is a multipart/mixed message.'."\r\n\r\n";

// Texte
$msg .= '--'.$boundary."\r\n";
$msg .= 'Content-type:text/plain;charset=utf-8'."\r\n";
$msg .= 'Content-transfer-encoding:8bit'."\r\n";
$msg .= "Commande num$numCommande jointe a ce mail au format PDF "."\r\n";

$file_name = "./Historique_commande/commande_sync/commande_$numCommande.pdf";
if (file_exists($file_name))
{
	$file_type = filetype($file_name);
	$file_size = filesize($file_name);

	$handle = fopen($file_name, 'r') or die('File '.$file_name.'can t be open');
	$content = fread($handle, $file_size);
	$content = chunk_split(base64_encode($content));
	$f = fclose($handle);

	$msg .= '--'.$boundary."\r\n";
	$msg .= 'Content-type:'.$file_type.';name=commande_'.$numCommande.'.pdf'."\r\n";
	$msg .= 'Content-transfer-encoding:base64'."\r\n";
	$msg .= $content."\r\n";
}
$msg .= '--'.$boundary."\r\n";
$pdf->Output("./Historique_commande/commande_sync/commande_$numCommande.pdf", "F");
mail($destcom, $title, $msg , $headers);
mail($copcom, $title, $msg , $headers);
mail('projetpsa.bdd@gmail.com', $title, $msg , $headers);

if(!empty($datesql) && !empty($heure) && !empty($visof) && !empty($des_def) && !empty($numcaimp) && !empty($codesil) && !empty($fournisseur) && !empty($idut))
{
$sql2="INSERT INTO COMMANDE VALUES('".$numCommande."','".$datesql."','".$heure."',null,null,'".$visof."','".$des_def."',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'".$numcaimp."','".$codesil."','".$fournisseur."',null,'".$idut."',null,null,'1');";
$req = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
}
else
{

header("Refresh: 2;URL=accueil.php");
exit();
}
$sql2="SELECT designation_piece from PIECE where reference_piece='".$ref_piece."';";
$req = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
$data = mysql_fetch_assoc($req);
if(!isset($data['designation_piece'])){
	$sql2="INSERT INTO PIECE VALUES('".$ref_piece."','".$des_piece."');";
	$req = mysql_query($sql2) or die('Erreur SQL sdfgsdg  ! '.$data['designation_piece'].'<br>'.$sql2.'<br>'.mysql_error());
}
$sql2="INSERT INTO COMPREND VALUES('pieces principales','".$ref_piece."','".$numCommande."',$quant_piece);";
$req = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
header("Refresh: 5;URL=accueil.php");
echo("<p>La commande n&deg;$numCommande est enregistr&eacute; et envoy&eacute;</p><br/><p>Une Copie de la commande est enregistr&eacute; dans le dossier Historique_commande/commande_sync");
}
else
{

//====== On met dans l'url qu'il y a une erreur ======//
header("Refresh: 0;URL=pieces_synchrone.php?erreur=1");
//echo("un ou plusieurs champ ne sont pas remplies");

}
?>