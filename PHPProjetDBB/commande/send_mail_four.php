<?php
session_start();
include('../connexion/_connexion.php');
require_once("./nocommande.php");     
require('fpdf.php');

array_map('utf8_decode',$_POST);
mysql_query("SET NAMES UTF8");
$ref_com=$_POST['numCommandeMasse'];
$jour_com=$_POST['jourCommandeMasse'];
$heure_com=$_POST['heureCommandeMasse'];
$emetteur=$_POST['EmetteurCM'];
$id_dossier=$_POST['ReferenceDossierCM'];
$text_dossier=$_POST['textReferenceDossierCM'];
$refCMPp1=$_POST['ReferenceCM_pp1'];
$desCMPp1=$_POST['DesignationCM_pp1'];
$quantCMPp1=$_POST['QuantiteCM_pp1'];
$potCMPp1=$_POST['PotentielCM_pp1'];
//piece principale 2
$refCMPp2=$_POST['ReferenceCM_pp2'];
$desCMPp2=$_POST['DesignationCM_pp2'];
$quantCMPp2=$_POST['QuantiteCM_pp2'];
$potCMPp2=$_POST['PotentielCM_pp2'];
//piece environement 1
$refCMPe1=$_POST['ReferenceCM_pe1'];
$desCMPe1=$_POST['DesignationCM_pe1'];
$quantCMPe1=$_POST['QuantiteCM_pe1'];
//piece environement 2
$refCMPe2=$_POST['ReferenceCM_pe2'];
$desCMPe2=$_POST['DesignationCM_pe2'];
$quantCMPe2=$_POST['QuantiteCM_pe2'];

//piece environement 3
$refCMPe3=$_POST['ReferenceCM_pe3'];
$desCMPe3=$_POST['DesignationCM_pe3'];
$quantCMPe3=$_POST['QuantiteCM_pe3'];


$idCA=$_POST['numCA'];
//$nomCA=$_POST['EntiteCM'];
$refdossCM=$_POST['ReferenceDossierCM'];
$numdossCM=$_POST['textReferenceDossierCM'];

$idut=$_POST['EmetteurCM'];


$date = date("d/m/Y");
$datesql = date("Y-m-d");
$heure = date("h:i:s");

$numCommande = noCommande();


$sql3="SELECT libelle_entite FROM ENTITE WHERE code_imputation='".$idCA."';";
$req3 = mysql_query($sql3) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
$data3 = mysql_fetch_assoc($req3);
$nomCA=$data3['libelle_entite'];

//SQL pour l'émetteur et tout le reste.
$sql2="SELECT nom_utilisateur, prenom_utilisateur, service_utilisateur,no_telephone FROM UTILISATEUR WHERE id_utilisateur='".$idut."';";
$req = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
$data = mysql_fetch_assoc($req);

$nomuti=$data['nom_utilisateur']." ".$data['prenom_utilisateur'];
$seruti=$data['service_utilisateur'];
$teluti=$data['no_telephone'];

class PDF extends FPDF
{
	function Header()
	{
		$date = date("d/m/Y");
		$heure = date("h:i:s");
		$this->Image("psa-peugeot-citroen-logo.jpg",205,10,85,10);
		$this->SetFont('Arial','B',10);
		$this->Ln(5);
		$this->Cell(0,18," Ville, Le : $date a $heure",0,0,'R');
	}
	function Footer()
	{
   		// Positionnement à 1,5 cm du bas
   		$this->SetY(-30);
   		// Police Arial italique 8
   		$this->SetFont('Arial','I',8);
		$this->Cell(0,5,utf8_decode('Route de Chalampé CD 39 Le Napoléon 68100 Mulhouse France Téléphone 33 3 89 09 09 09 - fax 33 3 89 09 29 39'),0,1,'C');
		$this->Cell(0,5,utf8_decode('________________________________________________________________________'),0,1,'C');
		$this->SetFont('Arial','I',6);
		$this->Cell(0,5,utf8_decode('Peugeot Citroën Automobiles SA, Siège Social : Route de Gizy, 78943 Vélizy Villacoublay Cedex France Téléphone 33 1 57 59 30 00 - Fax 33 1 57 59 48 55'),0,1,'C');
		$this->Cell(0,5,utf8_decode('Société Anonyme au capital de 294 816 500 €, 542 065 479 RCS Versailles, Siret 542 065 479 000 991, APE 341 Z'),0,1,'C');

   
	}	
}

// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('L');
// Titre
//Corps de la page

// Décalage à droite
//$pdf->Cell(20);

//num commande
$pdf->SetFont('Times','B',30);
$pdf->Ln(30);
$pdf->Cell(175,15,utf8_decode('Commande de masse N°'.$numCommande),0,0,'L');
$pdf->SetFont('Times','',12);
$pdf->Cell(60,10,"$refdossCM   $numdossCM",0,0,'C');
$pdf->MultiCell(30,5,"$nomCA\n\nSur CA:  $idCA",0,'L',0);
$pdf->Rect(245,44,35,8);
$pdf->Rect(245,52,35,8);


//Début feuille de commande masse

//Demandeur
$pdf->Ln(20);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,8,'Demandeur ',0,0,'L');

$pdf->MultiCell(120,8,"$nomuti\n$seruti",0,'L',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(120,-8,utf8_decode("Tél. $teluti"),0,0,'R');
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

$pdf->Cell(40,10,"Principale",1,0,'L');
$pdf->Cell(40,10,"$refCMPp1",1,0,'L');
$pdf->Cell(120,10,stripslashes(utf8_decode($desCMPp1)),1,0,'L');
$pdf->Cell(30,10,"$quantCMPp1",1,0,'L');
$pdf->Cell(40,10,"$potCMPp1",1,1,'L');
if(!empty($datesql) && !empty($heure) && !empty($numdossCM) && !empty($id_dossier) && !empty($idCA) && !empty($idut))
{
$sql2="INSERT INTO COMMANDE VALUES('".$numCommande."','".$datesql."','".$heure."','".$numdossCM."','".$id_dossier."',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'".$idCA."',NULL,NULL,NULL,'".$idut."',null,null,'2');";
$req = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
}
else
{
echo "erreur lors du remplissage des champs";
header("Refresh: 2;URL=accueil.php");
exit();
}
$sql2='SELECT designation_piece from PIECE where reference_piece="'.$refCMPp1.'";';
$req = mysql_query($sql2);
$data = mysql_fetch_assoc($req);
if(!isset($data['designation_piece'])){
$sql2='INSERT INTO PIECE VALUES("'.$refCMPp1.'","'.$desCMPp1.'");';
$req = mysql_query($sql2) or die('Erreur SQL  ! <br>'.$sql2.'<br>'.mysql_error());
}
$sql2="INSERT INTO COMPREND VALUES('pieces principales','".$refCMPp1."','".$numCommande."',$quantCMPp1);";
$req = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
$sql2="INSERT INTO CADENCEE VALUES('".$numCommande."','".$refCMPp1."','".$potCMPp1."');";
$req = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());

if(!empty($refCMPp2)){
$pdf->Cell(40,10,"Principale",1,0,'L');
$pdf->Cell(40,10,"$refCMPp2",1,0,'L');
$pdf->Cell(120,10,stripslashes(utf8_decode($desCMPp2)),1,0,'L');
$pdf->Cell(30,10,"$quantCMPp2",1,0,'L');
$pdf->Cell(40,10,"$potCMPp2",1,1,'L');
$sql2='SELECT designation_piece from PIECE where reference_piece="'.$refCMPp2.'";';
$req = mysql_query($sql2);
$data = mysql_fetch_assoc($req);
if(!isset($data['designation_piece'])){
$sql2='INSERT INTO PIECE VALUES("'.$refCMPp2.'","'.$desCMPp2.'");';
$req = mysql_query($sql2) or die('Erreur SQL  ! <br>'.$sql2.'<br>'.mysql_error());
}
$sql2="INSERT INTO COMPREND VALUES('pieces principales','".$refCMPp2."','".$numCommande."',$quantCMPp2);";
$req = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
$sql2="INSERT INTO CADENCEE VALUES('".$numCommande."','".$refCMPp2."','".$potCMPp1."');";
$req = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
}
if(!empty($refCMPe1)){
$pdf->Cell(40,10,"Secondaire",1,0,'L');
$pdf->Cell(40,10,"$refCMPe1",1,0,'L');
$pdf->Cell(120,10,stripslashes(utf8_decode($desCMPe1)),1,0,'L');
$pdf->Cell(30,10,"$quantCMPe1",1,1,'L');
$sql2='SELECT designation_piece from PIECE where reference_piece="'.$refCMPe1.'";';
$req = mysql_query($sql2);
$data = mysql_fetch_assoc($req);
if(!isset($data['designation_piece'])){
$sql2='INSERT INTO PIECE VALUES("'.$refCMPe1.'","'.$desCMPe1.'");';
$req = mysql_query($sql2) or die('Erreur SQL  ! <br>'.$sql2.'<br>'.mysql_error());
}
$sql2="INSERT INTO COMPREND VALUES('pieces environnement','".$refCMPe1."','".$numCommande."',$quantCMPe1);";
$req = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
}
if(!empty($refCMPe2)){
$pdf->Cell(40,10,"Secondaire",1,0,'L');
$pdf->Cell(40,10,"$refCMPe2",1,0,'L');
$pdf->Cell(120,10,stripslashes(utf8_decode($desCMPe2)),1,0,'L');
$pdf->Cell(30,10,"$quantCMPe2",1,1,'L');
$sql2='SELECT designation_piece from PIECE where reference_piece="'.$refCMPe2.'";';
$req = mysql_query($sql2);
$data = mysql_fetch_assoc($req);
if(!isset($data['designation_piece'])){
$sql2='INSERT INTO PIECE VALUES("'.$refCMPe2.'","'.$desCMPe2.'");';
$req = mysql_query($sql2) or die('Erreur SQL  ! <br>'.$sql2.'<br>'.mysql_error());
}
$sql2="INSERT INTO COMPREND VALUES('pieces environnement','".$refCMPe2."','".$numCommande."',$quantCMPe2);";
$req = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
}
if(!empty($refCMPe3)){
$pdf->Cell(40,10,"Secondaire",1,0,'L');
$pdf->Cell(40,10,"$refCMPe3",1,0,'L');
$pdf->Cell(120,10,stripslashes(utf8_decode($desCMPe3)),1,0,'L');
$pdf->Cell(30,10,"$quantCMPe3",1,1,'L');
$sql2='SELECT designation_piece from PIECE where reference_piece="'.$refCMPe3.'";';
$req = mysql_query($sql2);
$data = mysql_fetch_assoc($req);
if(!isset($data['designation_piece'])){
$sql2='INSERT INTO PIECE VALUES("'.$refCMPe3.'","'.$desCMPe3.'");';
$req = mysql_query($sql2) or die('Erreur SQL  ! <br>'.$sql2.'<br>'.mysql_error());
}
$sql2="INSERT INTO COMPREND VALUES('pieces environnement','".$refCMPe3."','".$numCommande."',$quantCMPe3);";
$req = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());

}
$pdf->SetFont('Arial','',8);

$pdf->Output("./Historique_commande/commande_masse/commande_$numCommande.pdf", "F");

//$pdf->Output();
   
header("Refresh: 5;URL=accueil.php");
echo("<p>La commande n&deg;$numCommande est enregistr&eacute; et envoy&eacute;</p><br/><p>Une Copie de la commande est enregistr&eacute; dans le dossier Historique_commande/commande_sync");

?>
