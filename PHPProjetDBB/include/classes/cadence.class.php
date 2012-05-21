<?php

class cadence
{

	public $link;
	

	public function __construct($link)
	{	
		$this->link = $link;
	}


	public function addPieceToCadence($noCommande, $pieces)
	{
		$this->removeCadenceByCommande($noCommande);
		
		foreach($pieces as $piece)
		{
			$this->addCadence($noCommande, $piece['reference'], $piece['potentiel']);
		}
	}
	
	
	public function addCadence($NoCommande, $ReferencePiece, $PotentielJour){
		
		// Insertion de l'étudiant 
		$sql = "INSERT INTO CADENCEE SET
							no_commande  	 = '$NoCommande',
							reference_piece  = '$ReferencePiece',
							potentiel_jour   = '$PotentielJour';";

		echo $sql . "<br>";
		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de d'insertion de la cadence";
			echo $sql;
			exit();
		}

		return true;
	}




	public function removeCadenceByBoth($noAthlete, $noDiscipline){

		$sql = "DELETE FROM cadencee WHERE noAthlete = $noAthlete AND noDiscipline = $noDiscipline;";

		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de suppression de l'association de l'athlete n°$noAthlete et de la discipline n°$noDiscipline.";
			exit();
		}

		return true;
	}

	public function removeCadenceByCommande($noCommande){
	
		//suppression d'éventuele cadences pour cette commande
		$sql = "DELETE FROM CADENCEE WHERE no_commande = $noCommande";
		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de suppression des cadence";
			echo $sql;
			return false;
		}
	
		return true;
	}

}
?>