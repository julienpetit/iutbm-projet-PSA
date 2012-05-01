<?php

//PAS FINI!!!! seul les prototype de supprimer sont fait
interface iCadencee
{
	public function getListDisciplinesByAthlete($noAthlete);
	public function getDisciplinesByAthlete($noAthlete);

	public function addCadence($NoCommande, $ReferencePiece, $PotentielJour);

	public function removeCadenceeByCOMMANDE($NoCommande);
	public function removeCadenceeByPIECE($ReferencePiece);
	public function removeCadenceeByBoth($NoCommande, $ReferencePiece);



}

class cadencee implements icadencee
{

	public $link;
	public $cadencee;
	

	public function __construct($link)
	{	
		$this->link = $link;
	}

	public function getListDisciplinesByAthlete($noAthlete){

		$sql = "SELECT e.noDiscipline, d.libelleDiscipline 
				FROM estspecialiste e
				INNER JOIN discipline d
				ON d.noDiscipline = e.noDiscipline
				WHERE noAthlete = $noAthlete;";

		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de récupération des disciplines de l'athlete n°$noAthlete";
			echo $sql;
			exit();
		}

		$disciplines = array();
		while ($row = mysqli_fetch_row($resultat)){
			$disciplines[] = array('no'		=> $row[0],
								 'nom'		=> $row[1]
									);
		}
		return $disciplines;
	}

	public function getDisciplinesByAthlete($noAthlete){

		$sql = "SELECT noDiscipline FROM estspecialiste WHERE noAthlete = $noAthlete;";

		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de récupération des disciplines de l'athlete n°$noAthlete";
			exit();
		}

		$disciplines = array();
		while ($row = mysqli_fetch_row($resultat)){
			array_push($disciplines, $row[0]);
		}

		return $disciplines;
	}

	public function addcadencee($noAthlete, $noDiscipline){


		// Insertion de l'étudiant 
		$sql = "INSERT INTO estspecialiste SET
							noAthlete  = $noAthlete,
							noDiscipline  = $noDiscipline;";

		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de d'insertion de l'association de l'athlete n°$noAthlete et de la discipline n°$noDiscipline.";
			exit();
		}

		return true;
	}



	public function removecadenceeByAthlete($noAthlete){
		$sql = "DELETE FROM estspecialiste WHERE noAthlete = $noAthlete;";

		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de suppression des l'associations de l'athlete n°$noAthlete.";
			exit();
		}

		return true;
	}



	public function removecadenceeByDiscipline($noDiscipline){
		$sql = "DELETE FROM cadencee WHERE noDiscipline = $noDiscipline;";

		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de suppression des l'associations de la discipline n°$noDiscipline.";
			exit();
		}

		return true;		
	}



	public function removecadenceeByBoth($noAthlete, $noDiscipline){

		$sql = "DELETE FROM cadencee WHERE noAthlete = $noAthlete AND noDiscipline = $noDiscipline;";

		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de suppression de l'association de l'athlete n°$noAthlete et de la discipline n°$noDiscipline.";
			exit();
		}

		return true;
	}




	public function updatecadencee($nocadencee , $nom, $adresse){
		$sql = "UPDATE cadencee SET
							nomcadencee  = '$nom',
							adresse  = '$adresse'
				WHERE nocadencee = $nocadencee;";

		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de de mise à jour de l'cadencee $nom.";
			exit();
		}		
		return true;
	}



	public function rowcadenceeSelect($cadencee){
		echo "<tr class='row_object'>\n";
			echo "<td class='cell_id'>".$cadencee['no']."</td>\n";
			echo "<td class='cell_nom'>".$cadencee['nom']."</td>\n";
			echo "<td class='cell_adresse'>".$cadencee['adresse']."</td>\n";
			echo "<td class='cell_nbEtudiants'>".$cadencee['nbEtudiants']."</td>\n";
			echo "<td class='cell_update'>\n";
				echo "<a href='?update=".$cadencee['no']."'>update</a>\n";
			echo "</td>\n";
			echo "<td class='cell_remove'>\n";
				echo "<a href=\"javascript:if(confirm('Etes vous sur ?')) document.location.href='?remove=".$cadencee['no']."'\">remove</a>\n";
			echo "</td>\n";
		echo "</tr>\n";
	}

}
?>