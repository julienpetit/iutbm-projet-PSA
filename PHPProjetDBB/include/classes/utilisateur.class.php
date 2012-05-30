<?php

interface iUtilisateur
{
	public function getList($where="", $min=0, $max=0);
	public function getUtilisateur($IdUtilisateur);

	public function addUtilisateur($IdUtilisateur,
				  				   $NomUtilisateur,
				  				   $PrenomUtilisateur,
				  				   $ServiceUtilisateur,
				  				   $NumeroTelephone,
				  				   $EmailUtilisateur,
				  				   $MdpUtilisateur);

	public function removeUtilisateur($IdUtilisateur);
	
	public function updateUtilisateur($IdUtilisateur,
				  				   	  $NomUtilisateur,
				  				      $PrenomUtilisateur,
				  				      $ServiceUtilisateur,
				  				      $NumeroTelephone,
				  				      $EmailUtilisateur,
				  				      $MdpUtilisateur);
	

}

class Utilisateur implements iUtilisateur
{

	public $link;

	public function __construct($link)
	{	
		$this->link = $link;
	}


	function getList($where = "", $min=0, $max=0)
	{
	
		// D�termination du nombre de Utilisateurs � retourner
		$limit = "";
		if($min != 0 && $max != 0) $limit = " LIMIT $min, $max";

	
		// S�lection des infos des Utilisateurs.
		$sql = "SELECT id_utilisateur,
					   nom_utilisateur,
					   prenom_utilisateur,
					   service_utilisateur,
					   no_telephone,
					   email_utilisateur,
					   mdp_utilisateur
				FROM UTILISATEUR
			    $where
			    $limit;";

		
		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de récupération des Utilisateurs.<br>";
			echo $sql;
			echo mysqli_error($this->link);
			exit();
		}
		
		// Création d'une liste de Utilisateurs
		$Utilisateurs = array();
		while ($row = mysqli_fetch_row($resultat)){
			$Utilisateurs[] =array('id_utilisateur' 				=> $row[0],
						'nom_utilisateur'  						=> $row[1],
						'prenom_utilisateur' 						=> $row[2],
						'service_utilisateur' 					=> $row[3],
						'no_telephone'  							=> $row[4],
						'email_utilisateur'		 				=> $row[4],
						'mdp_utilisateur' 						=> $row[5]);
		}

		return $Utilisateurs;
	}

	public function getUtilisateur($IdUtilisateur){
		$tabUtilisateur = $this->getList(" WHERE id_utilisateur = '$IdUtilisateur'", 0, 1);

		return $tabUtilisateur[0];
	}

	public function addUtilisateur($IdUtilisateur, $NomUtilisateur, $PrenomUtilisateur, $ServiceUtilisateur, $NumeroTelephone, $EmailUtilisateur, $MdpUtilisateur)
	{

		// Insertion de l'Utilisateur 
		$sql = "INSERT INTO UTILISATEUR SET id_utilisateur = $IdUtilisateur,
					       			  		nom_utilisateur=$NomUtilisateur
					       			  		prenom_utilisateur=$PrenomUtilisateur,
					  						service_utilisateur=$ServiceUtilisateur,
					  						no_telephone= $NumeroTelephone,
					   						email_utilisateur=$EmailUtilisateur,
					   						mdp_utilisateur=$MdpUtilisateur;";

		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur d'insertion de l'Utilisateur $IdUtilisateur.";
			exit();
		}

		return true;
	}
	

	public function removeUtilisateur($IdUtilisateur){

		$sql = "DELETE FROM UTILISATEUR WHERE id_utilisateur = $IdUtilisateur;";

		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de suppression de l'Utilisateur $IdUtilisateur.";
			exit();
		}

		return true;
	}

	public function updateUtilisateur($IdUtilisateur,
				  				   $NomUtilisateur,
				  				   $PrenomUtilisateur,
				  				   $ServiceUtilisateur,
				  				   $NumeroTelephone,
				  				   $EmailUtilisateur,
				  				   $MdpUtilisateur)
	{
		$sql = "UPDATE UTILISATEUR SET id_utilisateur = $IdUtilisateur,
					       			  		nom_utilisateur=$NomUtilisateur
					       			  		prenom_utilisateur=$PrenomUtilisateur,
					  						service_utilisateur=$ServiceUtilisateur,
					  						no_telephone= $NumeroTelephone,
					   						email_utilisateur=$EmailUtilisateur,
					   						mdp_utilisateur=$MdpUtilisateur
				      			 			WHERE  id_utilisateur = '$IdUtilisateur';";

		if(!$resultat = mysqli_query($this->link, $sql)) 
		{
			echo "Erreur de de mise à jour de l'Utilisateur $IdUtilisateur.";
			exit();
		}		
		return true;
	}

}
?>
