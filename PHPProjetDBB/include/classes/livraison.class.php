<?php 

class Livraison
{

	public $link;

	public function __construct($link)
	{	
		$this->link = $link;
		
		
	}


	function getLivraisonByPieceCommande($refPiece, $noCommande)
	{
	
		$sql = "SELECT * FROM LIVRAISON
				 WHERE reference_piece = '$refPiece' AND no_commande = '$noCommande'";
		echo $sql;
		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de récupération des livraisons.";
			exit();
		}
		
		$livraisons = array();
		while ($row = mysqli_fetch_row($resultat)){
			$livraisons[] = array('reference_piece' 	  	=> $row[0],
					   			  'no_commande' 	   		=> $row[1],
					   			  'date_livraison'			=> $row[2],
								  'quantite_livree' 		=> $row[3]);
		}

		return $livraisons;
	}

}
?>
