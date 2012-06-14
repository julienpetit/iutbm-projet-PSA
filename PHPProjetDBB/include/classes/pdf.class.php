<?php

require ("/include/classes/fpdf.php");

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