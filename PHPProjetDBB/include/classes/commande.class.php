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
	
	public function updateCommande($noCommande, $infosCommande);
	
	public function displayChoiceBox($reference, $libelle);

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
		$sql = "SELECT no_commande, 
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

			$Commandes[] = array('no_commande'				=> $row[0],
						'date_commande'  					=> $row[1],
						'heure_commande'  					=> $row[2],
						'no_chantier'  						=> $row[3],
						'libelle_type_chantier'  			=> $row[4],
						'ref_vehicule' 		 				=> $row[5],
						'desc_defaut'						=> $row[6],
						'date_fermeture'  					=> $row[7],
						'heure_fermeture' 					=> $row[8],
						'motif_fermeture'  					=> $row[9],
						'date_annulation'  					=> $row[10],
						'heure_annulation' 					=> $row[11],
						'date_reception'  					=> $row[12],
						'heure_reception'  					=> $row[13],
						'code_imputation'  					=> $row[14],
						'code_silhouette'					=> $row[15],
						'id_fournisseur'  					=> $row[16],
						'id_utilisateur_receptionne'  		=> $row[17],
						'id_utilisateur_passe'  			=> $row[18],
						'id_utilisateur_annule'  			=> $row[19],
						'id_utilisateur_ferme'  			=> $row[20],
						'code_type_commande' 				=> $row[21]
							 );
		}
		return $Commandes;
	}



	public function getCommande($noCommande){
		$tabCommande = $this->getList(" no_commande = $noCommande ");

		return isset($tabCommande[0]) ? $tabCommande[0] : null;
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
		// 				'id_sournisseur' => $idFournisseur,
		// 				'id_utilisateur_receptionne' => $idUtilisateurReceptionne,
		// 				'id_utilisateur_passe' => $idUtilisateurPasse,
		// 				'id_utilisateur_annule' => $idUtilisateurAnnule,
		// 				'id_utilisateur_ferme' => $idUtilisateurFerme,
		// 				'code_type_commande' => $codeTypeCommande);
		
		
		// Mise à jour des informations de la commande
		$sql = "UPDATE COMMANDE SET ";
		$i = 0;
		$max = count($infosCommande) - 1;
		foreach($infosCommande as $champs => $value){
			$sql .= "$champs = '$value'";
			if($i < $max)
				$sql .= ", ";
			$i++;
		
		}
		$sql .= " WHERE no_commande = $noCommande";
		
		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de de mise à jour de la commande n°$noCommande.";
			exit();
		}		

		return true;
	}
	
	public function displayChoiceBox($reference, $libelle){
		echo "<div id='confirmOverlay'>\n";
		echo "<div id='confirmBox'>\n";

		echo "<h2>Ajout d'une pièce à la commande</h2>\n";
	
		echo "<table>\n";
		echo "<tr>\n";
		echo "<td>Référence : </td>\n";
		echo "<td id='ajoutPieceCommandeReference' >$reference</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td>Libellé : </td>\n";
		echo "<td id='ajoutPieceCommandeLibelle' >$libelle</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td>Quantité : </td>\n";
		echo "<td><input type='text' id='ajoutPieceCommandeQuantite' name='ajoutPieceCommandeQuantite' value='1' /></td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td>Potentiel/jours (falcultatif) : </td>\n";
		echo "<td><input type='text' id='ajoutPieceCommandePj' name='ajoutPieceCommandePj' value='1'/></td>\n";
		echo "</tr>\n";
		echo "</table>\n";
		
		
		echo "<div id='confirmButtons'>\n";
		echo "<a id='ajoutPiecePrincipale' class='small blue nice button radius' href='#'><span>pièce principale</span></a>\n";
		echo "<a id='ajoutPieceEnvironnement' class='small blue nice button radius' href='#'><span>pièce d'environnement</span></a>\n";
		echo "<a id='annulerAjoutPieceCommande' class='small red nice button radius' href='#'><span>annuler</span></a>\n";
		echo "</div>\n";
		echo "</div>\n";
		echo "</div>\n";
	}

}
?>