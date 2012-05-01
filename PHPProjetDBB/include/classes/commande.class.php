<?php 

interface iCommande
{
	public function getList($where="", $min=0, $max=0);
	public function getCommande($noCommande);

	public function addCommande($noCommande,
								$date,
								$heure,
								$noChantier,
								$libeleTypeChantier,
								$refVehicule,
								$descDefaut,
								$dateFermeture,
								$heureFermeture,
								$motifFermeture,
								$dateAnnulation,
								$heureAnnulation,
								$dateReception,
								$heureReception,
								$codeImputation,
								$codeSilhouette,
								$idFournisseur,
								$idUtilisateurReceptionne,
								$idUtilisateurPasse,
								$idUtilisateurAnnule,
								$idUtilisateurFerme,
								$codeTypeCommande);
	
	
	public function removeCommande($noCommande);
	
	public function updateCommande($noCommande,
									$date,
									$heure,
									$noChantier,
									$libeleTypeChantier,
									$refVehicule,
									$descDefaut,
									$dateFermeture,
									$heureFermeture,
									$motifFermeture,
									$dateAnnulation,
									$heureAnnulation,
									$dateReception,
									$heureReception,
									$codeImputation,
									$codeSilhouette,
									$idFournisseur,
									$idUtilisateurReceptionne,
									$idUtilisateurPasse,
									$idUtilisateurAnnule,
									$idUtilisateurFerme,
									$codeTypeCommande);

}

class Commande implements iCommande
{

	public $link;


	public function __construct($link)
	{	
		$this->link = $link;
	}





	function getList($where = "", $min=0, $max=0)
	{
	
		// Sélection des infos des Commandes et de leurs iut.
		$sql = "SELECT no_commande 
						date_commande,
						heure_commande,
						no_chantier,
						libelle_type_chantier,
						ref_vehicule,
						desc_defaut,
						date_fermeture,
						heure_fermeture,
						motif_fermeture,
						date_annulation,
						heure_annulation,
						date_reception,
						heure_reception,
						code_imputation,
						code_silhouette,
						id_fournisseur,
						id_utilisateur_receptionne,
						id_utilisateur_passe,
						id_utilisateur_annule,
						id_utilisateur_ferme,
						code_type_commande 
				FROM COMMANDE";

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

			$Commandes[] = array(no_commande 				=> $row[0],
						date_commande  						=> $row[1],
						heure_commande  					=> $row[2],
						no_chantier  						=> $row[3],
						libelle_type_chantier  				=> $row[4],
						ref_vehicule 		 				=> $row[4],
						desc_defaut  						=> $row[5],
						date_fermeture  					=> $row[6],
						heure_fermeture  					=> $row[7],
						motif_fermeture  					=> $row[8],
						date_annulation  					=> $row[9],
						heure_annulation  					=> $row[10],
						date_reception  					=> $row[11],
						heure_reception  					=> $row[12],
						code_imputation  					=> $row[13],
						code_silhouette  					=> $row[14],
						id_fournisseur  					=> $row[15],
						id_utilisateur_receptionne  		=> $row[16],
						id_utilisateur_passe  				=> $row[17],
						id_utilisateur_annule  				=> $row[18],
						id_utilisateur_ferme  				=> $row[19],
						code_type_commande 					=> $row[20]
							 );
		}
		return $Commandes;
	}



	public function getCommande($noCommande){
		$tabCommande = $this->getList(" no_commande = $no_commande ");

		return $tabCommande[0];
	}






	public function addCommande($noCommande,
								$date,
								$heure,
								$noChantier,
								$libeleTypeChantier,
								$refVehicule,
								$descDefaut,
								$dateFermeture,
								$heureFermeture,
								$motifFermeture,
								$dateAnnulation,
								$heureAnnulation,
								$dateReception,
								$heureReception,
								$codeImputation,
								$codeSilhouette,
								$idFournisseur,
								$idUtilisateurReceptionne,
								$idUtilisateurPasse,
								$idUtilisateurAnnule,
								$idUtilisateurFerme,
								$codeTypeCommande)
		{

		// Insertion de la commande 
		$sql = "INSERT INTO COMMANDE SET
								no_commande = $noCommande,
								date_commande = $date,
								heure_commande = $heure,
								no_chantier = $noChantier,
								libelle_type_chantier = $libeleTypeChantier,
								ref_vehicule = $refVehicule,
								desc_defaut = $descDefaut,
								date_fermeture = $dateFermeture,
								heure_fermeture = $heureFermeture,
								motif_fermeture = $motifFermeture,
								date_annulation = $dateAnnulation,
								heure_annulation = $heureAnnulation,
								date_reception = $dateReception,
								heure_reception = $heureReception,
								code_imputation = $codeImputation,
								code_silhouette = $codeSilhouette,
								id_fournisseur = $idFournisseur,
								id_utilisateur_receptionne = $idUtilisateurReceptionne,
								id_utilisateur_passe = $idUtilisateurPasse,
								id_utilisateur_annule = $idUtilisateurAnnule,
								id_utilisateur_ferme = $idUtilisateurFerme,
								code_type_commande = $codeTypeCommande;";

		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de de insertion de la commande $noCommande.";
			exit();
		}

		return true;
	}






	public function removeCommande($noCommande){

		// Suppression de la commande
		$sql = "DELETE FROM COMMANDE WHERE noCommande = $noCommande;";

		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de suppression du Commande n°$noCommande.";
			exit();
		}

		return true;
	}







	public function updateCommande($noCommande,
								$date,
								$heure,
								$noChantier,
								$libeleTypeChantier,
								$refVehicule,
								$descDefaut,
								$dateFermeture,
								$heureFermeture,
								$motifFermeture,
								$dateAnnulation,
								$heureAnnulation,
								$dateReception,
								$heureReception,
								$codeImputation,
								$codeSilhouette,
								$idFournisseur,
								$idUtilisateurReceptionne,
								$idUtilisateurPasse,
								$idUtilisateurAnnule,
								$idUtilisateurFerme,
								$codeTypeCommande){
		
		// Mise à jour des informations de la commande
		$sql = "UPDATE COMMANDE SET
								no_commande = $noCommande,
								date_commande = $date,
								heure_commande = $heure,
								no_chantier = $noChantier,
								libele_type_chantier = $libeleTypeChantier,
								ref_vehicule = $refVehicule,
								desc_defaut = $descDefaut,
								date_fermeture = $dateFermeture,
								heure_fermeture = $heureFermeture,
								motif_fermeture = $motifFermeture,
								date_annulation = $dateAnnulation,
								heure_annulation = $heureAnnulation,
								date_reception = $dateReception,
								heure_reception = $heureReception,
								code_imputation = $codeImputation,
								code_silhouette = $codeSilhouette,
								id_sournisseur = $idFournisseur,
								id_utilisateur_receptionne = $idUtilisateurReceptionne,
								id_utilisateur_passe = $idUtilisateurPasse,
								id_utilisateur_annule = $idUtilisateurAnnule,
								id_utilisateur_ferme = $idUtilisateurFerme,
								code_type_commande = $codeTypeCommande;";

		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de de mise à jour de la commande n°$noCommande.";
			exit();
		}		

		return true;

	}


}
?>