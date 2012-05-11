<?php 

interface iEntite
{
	public function getList($where="", $min=0, $max=0);
	public function getEntite($CodeImputation);

	public function addEntite($CodeImputation,
				  $LibelleEntite,
				  $Exterieur);

	public function removeEntite($CodeImputation);
	public function updateEntite($CodeImputation,
				     $LibelleEntite,
				     $Exterieur);

}

class Entite implements iEntite
{

	public $link;



	

	public function __construct($link)
	{	
		$this->link = $link;
		
		
	}


	function getList($where = "", $min=0, $max=0)
	{
	
		// Détermination du nombre d'Entites à retourner
		$limit = "";
		if($min != 0 && $max != 0) $limit = " LIMIT $min, $max";

	
		// Sélection des infos des Entites.
		$sql = "SELECT code_imputation, libelle_entite, exterieur
				FROM ENTITE
			    $where
			    $limit;";
		
		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de récupération des Entites.";
			exit();
		}
		
		// Création d'une liste d'Entites
		$Entites = array();
		while ($row = mysqli_fetch_row($resultat)){
			$Entites[] = array('no' 	  		=> $row[0],
					   		'libelle' 	   		=> $row[1],
					   		'exterieur'			=> $row[2]);
		}

		return $Entites;
	}

	public function getEntite($noEntite){
		$tabEntite = $this->getList(" AND code_imputation = '$CodeImputation'", 0, 1);

		return $tabEntite[0];
	}

	public function addEntite($CodeImputation,
				  $LibelleEntite,
				  $Exterieur)
		{

		

		// Insertion de l'Entite 
		$sql = "INSERT INTO ENTITE SET code_imputation = '$CodeImputation',
					       libelle_entite='$LibelleEntite',
					       exterieur = '$Exterieur'";

		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de d'insertion de la Entite $CodeImputation.";
			exit();
		}

		return true;
	}

	public function removeEntite($CodeImputation){

		$sql = "DELETE FROM ENTITE WHERE code_imputation = $CodeImputation;";

		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de suppression de l'Entite $CodeImputation.";
			exit();
		}

		return true;
	}

	public function updateEntite($CodeImputation,
				     $LibelleEntite,
				     $Exterieur)
	{
		$sql = "UPDATE Entite SET code_imputation = '$CodeImputation',
					  libelle_entite='$LibelleEntite',
					  exterieur = '$Exterieur'
				      WHERE  code_imputation = $CodeImputation;";

		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de de mise à jour de l'Entite $CodeImputation.";
			exit();
		}		
		return true;
	}

	
	public function displaySelect($attributId, $defautValue = "0")
	{
		echo "<select id='$attributId' name='$attributId' >\n";
			echo "<option value='0'>choisir une entité</option>\n";
		foreach ($this->getList() as $entite) {
			$no 	 = $entite['no'];
			$libelle = $entite['libelle'];
			
			echo "<option ";
			if($no == $defautValue) 
				echo " selected='selected' ";
			echo " value='$no'>$libelle</option>\n";
		}
		echo "</select>\n";
	}

	

}
?>
