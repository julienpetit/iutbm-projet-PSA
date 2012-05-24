<?php 

class CommandeHistorique
{

	public $link;


	public function __construct($link)
	{	
		$this->link = $link;
	}





	function getList($where = "", $min=0, $max=0)
	{
	
		// Sélection des infos des Commandes et de leurs iut.
		$sql = "SELECT * FROM COMMANDE_HISTORIQUE";

		if($where != "") $sql .= " WHERE $where";

		// Détermination du nombre de Commandes à retourner
		if($min != 0 && $max != 0) $sql .= " LIMIT $min, $max";



		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de récupération des Commandes.";
			echo $sql;
			exit();
		}
		
		// Création de une liste de Commandes
		$Commandes = array();
		while ($row = mysqli_fetch_row($resultat)){

			$Commandes[] = array(
						'no_historique'						=> $row[0],
					    'no_commande'						=> $row[1],
						'date_commande'  					=> $row[2],
						'heure_commande'  					=> $row[3],
						'no_chantier'  						=> $row[4],
						'libelle_type_chantier'  			=> $row[5],
						'ref_vehicule' 		 				=> $row[6],
						'desc_defaut'						=> $row[7],
						'date_fermeture'  					=> $row[8],
						'heure_fermeture' 					=> $row[9],
						'motif_fermeture'  					=> $row[10],
						'date_annulation'  					=> $row[11],
						'heure_annulation' 					=> $row[12],
						'date_reception'  					=> $row[13],
						'heure_reception'  					=> $row[14],
						'code_imputation'  					=> $row[15],
						'code_silhouette'					=> $row[16],
						'id_fournisseur'  					=> $row[17],
						'id_utilisateur_receptionne'  		=> $row[18],
						'id_utilisateur_passe'  			=> $row[19],
						'id_utilisateur_annule'  			=> $row[20],
						'id_utilisateur_ferme'  			=> $row[21],
						'code_type_commande' 				=> $row[22]
							 );
		}
		return $Commandes;
	}



	public function getCommande($noCommande, $noHistorique){
		$tabCommande = $this->getList(" no_commande = '$noCommande' AND no_historique = '$noHistorique'");

		return isset($tabCommande[0]) ? $tabCommande[0] : null;
	}






	public function addCommande($infosCommande){
		
		// Mise à jour des informations de la commande
		$sql = "INSERT INTO COMMANDE_HISTORIQUE SET ";
		$i = 0;
		$max = count($infosCommande) - 1;
		foreach($infosCommande as $champs => $value){
			if($value != ""){
				$sql .= "$champs = '$value'";
				if($i < $max)
					$sql .= ", ";
			}
			$i++;
		}
		
		echo $sql;
		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de de mise à jour de la commande . $sql";
			exit();
		}		

		return mysqli_insert_id($this->link);
	}






	public function removeCommande($noCommande){

		// Suppression de la commande
		$sql = "DELETE FROM COMMANDE_HISTORIQUE WHERE no_commande = '$noCommande';";

		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de suppression du Commande n°$noCommande.";
			exit();
		}

		return true;
	}


	/**
	 * return le nombre de modifications d'une commande;
	 * @param unknown_type $noCommande
	 */
	public function countHistory($noCommande)
	{
		// Suppression de la commande
		$sql = "SELECT COUNT(*) FROM COMMANDE_HISTORIQUE WHERE no_commande = '$noCommande';";
		
		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de comptage. $sql";
			exit();
		}
		
		$row = mysqli_fetch_row($resultat);
		return $row[0];
	}

	
	public function displayBoxHistory($noCommande)
	{
		$nbModif = $this->countHistory($noCommande);
		if($nbModif == 0)
		{
			echo "Cette commande n'a jamais été modifiée.";
		} 	
		else 
		{
			echo "Cette commande à été modifiée $nbModif fois.";
			echo "<span><a href='./?historique=$noCommande' class='small green nice button radius' >Voir les révisions</a></span>";
		}
	}

	public function updateCommande($noCommande, $infosCommande){
		// @ Exemple, passez en parametre ce tableau
		// 		array(
		// 				'date_commande' => $date,
		// 				'heure_commande' => $heure,
		// 				'no_chantier' => $noChantier,
		// 				'libele_type_chantier' => $libeleTypeChantier,
		// 				'ref_vehicule' => $refVehicule,
		// 				'desc_defaut' => $descDefaut,
		// 				'date_fermeture' => $dateFermeture,
		// 				'heure_fermeture' => $heureFermeture,
		// 				'motif_fermeture' => $motifFermeture,
		// 				'date_annulation' => $dateAnnulation,
		// 				'heure_annulation' => $heureAnnulation,
		// 				'date_reception' => $dateReception,
		// 				'heure_reception' => $heureReception,
		// 				'code_imputation' => $codeImputation,
		// 				'code_silhouette' => $codeSilhouette,
		// 				'id_fournisseur' => $idFournisseur,
		// 				'id_utilisateur_receptionne' => $idUtilisateurReceptionne,
		// 				'id_utilisateur_passe' => $idUtilisateurPasse,
		// 				'id_utilisateur_annule' => $idUtilisateurAnnule,
		// 				'id_utilisateur_ferme' => $idUtilisateurFerme,
		// 				'code_type_commande' => $codeTypeCommande);
		
		
		// Mise à jour des informations de la commande
		$sql = "UPDATE COMMANDE_HISTORIQUE SET ";
		$i = 0;
		$max = count($infosCommande) - 1;
		foreach($infosCommande as $champs => $value){
			$sql .= "$champs = '$value'";
			if($i < $max)
				$sql .= ", ";
			$i++;
		}
		$sql .= " WHERE no_commande = $noCommande";
		echo $sql;
		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de de mise à jour de la commande n°$noCommande.";
			exit();
		}		

		return true;
	}
	

	public function transfertCommande($noCommande)
	{
		$modeleCommande = new Commande($this->link);
		$modelePiece = new Piece($this->link);
		$modeleEntite = new Entite($this->link);
		$modeleCadence = new Cadence($this->link);
		
		// récupération de l'ancienne commande
		$commande = $modeleCommande->getCommande($noCommande);
		
		print_r_html($commande);

		$commande['date_commande']  = date("Y-m-d");  
		$commande['heure_commande'] = date("H:i:s");
		
		print_r_html($commande);
		
		
		$noHistorique = $this->addCommande($commande);
		
		print_r_html($pieces = $modelePiece->getPieceByCommandeId($noCommande));
		
  		$modelePiece->addPiecesToCommande($noHistorique, $pieces['principales'], $pieces['environnement']);
		
 		$modeleCadence->addPieceToCadence($noHistorique, $pieces['principales']);
	}

}
?>