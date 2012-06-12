<?php

interface iPiece
{
	public function getList($where="", $min=0, $max=0);
	public function getPiece($ReferencePiece);
	public function getPieceByCommandeId($noCommande);

	public function addPiece($ReferencePiece,
				  			 $DesignationPiece);
	
//	public function addPiecesToCommande($pieces);

	public function removePiece($ReferencePiece);
	public function updatePiece($ReferencePiece,
				  			    $DesignationPiece);
	
	public function displayWidgetPiece();
	public function displayListePieces($where = "");
	public function displayAjoutPieces();

}

class Piece implements iPiece
{

	public $link;
	public $modeleLivraison;
	
	public function __construct($link) { 
		$this->link = $link; 
		$this->modeleLivraison = new Livraison($link);
	}

	/**
	 * Retourne un tableau de pièces (non-PHPdoc)
	 * @see iPiece::getList()
	 */
	function getList($where = "", $min=0, $max=0)
	{
	
		// Détermination du nombre de Pieces à retourner
		$limit = "";
		if($min != 0 && $max != 0) $limit = " LIMIT $min, $max";

	
		// Sélection des infos des Pieces.
		$sql = "SELECT p.reference_piece, p.designation_Piece
				FROM PIECE p 
			    $where
			    $limit;";
		
		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de récupération des Pieces. $sql";
			exit();
		}
		
		// Création d'une liste de Pieces
		$Pieces = array();
		while ($row = mysqli_fetch_row($resultat)){
			$Pieces[] = array('reference' 	  		=> $row[0],
					   		  'libelle' 	   		=> $row[1],
							  );
		}

		return $Pieces;
	}

	/**
	 * retourne une pièce sous forme de tableau(non-PHPdoc)
	 * @see iPiece::getPiece()
	 */
	public function getPiece($ReferencePiece){
		$tabPiece = $this->getList("WHERE AND p.reference_piece = '$ReferencePiece'", 0, 1);

		return $tabPiece[0];
	}

	/** 
	 * Ajoute un pièce dans la bdd (non-PHPdoc)
	 * @see iPiece::addPiece()
	 */
	public function addPiece($ReferencePiece, $DesignationPiece)
		{

		// Insertion de l'Piece 
		$sql = "INSERT INTO PIECE SET reference_piece = '$ReferencePiece',
					       			  designation_piece='$DesignationPiece'";

		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de d'insertion de la Piece $ReferencePiece.";
			exit();
		}

		return true;
	}
	
	public function addPiecesToCommande($noCommande, $piecesPrinc, $piecesEnv)
	{
		// Supression d'éventuelles pièce dans la table COMPREND
		$sql = "DELETE FROM COMPREND WHERE no_commande = '$noCommande'";
		
		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur suppression des pièces de la commande $noCommande";
			exit();
		}
		
		// Ajout des pièces principales de la commande dans la table COMPREND
		if(!empty($piecesPrinc)) foreach($piecesPrinc as $piece)
		{
			$sql = "INSERT INTO COMPREND 
					SET libelle_type_piece = 'pieces principales',
						reference_piece    = '".$piece['reference']."',
						no_commande 	   = '$noCommande',
						quantite_piece 	   = ".$piece['quantite'].";";
						
			
			if(!$resultat = mysqli_query($this->link, $sql)) {
				echo "Impossible d'ajouter la pièce princ $piece à la commande n° $noCommande";
				echo sql($sql);
				exit();
			}
		}

		if(!empty($piecesEnv))foreach($piecesEnv as $piece)
		{
			$sql = "INSERT INTO COMPREND 
					SET libelle_type_piece = 'pieces environnement',
						reference_piece    = '".$piece['reference']."',
						no_commande 	   = '$noCommande',
						quantite_piece 	   = '".$piece['quantite']."';";
				
			if(!$resultat = mysqli_query($this->link, $sql)) {
				echo "Impossible d'ajouter la pièce env $piece à la commande n° $noCommande";
				exit();
			}
		}
	}
	

	/**
	 * Retourne un tableau de pièce de la commande dont le no est passé en paramètre. (non-PHPdoc)
	 * @see iPiece::getPieceByCommandeId()
	 */
	public function getPieceByCommandeId($noCommande)
	{
	 	
		$sql = "SELECT c.libelle_type_piece,
					   p.reference_piece,
					   p.designation_piece,
				   	   c.quantite_piece
				FROM PIECE p
				INNER JOIN COMPREND c ON c.reference_piece = p.reference_piece
				WHERE c.no_commande = $noCommande";
	
		if(!$resultat = mysqli_query($this->link, $sql)) 
		{
			echo "Erreur : piece.class->getPieceByCommandeId($noCommande).";
		}
		
		$princ = array();
		$env = array();
		while ($row = mysqli_fetch_row($resultat))
		{
			if($row[0] == "pieces principales") 
			{
				$sql2 = "SELECT potentiel_jour FROM CADENCEE WHERE no_commande = '$noCommande' AND reference_piece = '$row[1]'";
				if(!$resultat2 = mysqli_query($this->link, $sql2))
				{
					echo "Erreur cadence Piece";
					echo "$sql2";
				}
				$row2 = mysqli_fetch_row($resultat2);
				
				$princ[] = array('reference' => $row[1],
								 'libelle'   => $row[2],
								 'quantite'  => $row[3],
								 'potentiel' => $row2[0]
								);	
			}
			if($row[0] == "pieces environnement")
			{
				$env[] = array('reference' => $row[1],
												 'libelle'   => $row[2],
												 'quantite'  => $row[3]
				);
			}
		}

		return array('principales' => $princ, 'environnement' => $env);
	}

	
	/**
	 * Supprime la pièce de la bdd dont son no est passé en paramètre (non-PHPdoc)
	 * @see iPiece::removePiece()
	 */
	public function removePiece($referencePiece)
	{

		$sql = "DELETE FROM PIECE WHERE reference_piece = '$ReferencePiece';";

		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de suppression de la Piece $ReferencePiece.";
			exit();
		}

		return true;
	}

	/**
	 * Met à jour la base de données de la pièce concernée (non-PHPdoc)
	 * @see iPiece::updatePiece()
	 */
	public function updatePiece($ReferencePiece, $DesignationPiece)
	{
		$sql = "INSERT INTO PIECE SET reference_piece = '$ReferencePiece',
					       			  designation_piece='$DesignationPiece'
				      			  WHERE  creference_piece = '$ReferencePiece';";

		if(!$resultat = mysqli_query($this->link, $sql)) 
		{
			echo "Erreur de de mise à jour de l'Piece $ReferencePiece.";
			exit();
		}		
		return true;
	}

	

	
	
	
	/**
	 * #################### Widget Pieces ######################
	 * Affiche un widget qui permet de choisir une pièce dans un tableau en html(non-PHPdoc)
	 * @see iPiece::displayWidgetPiece()
	 */
	public function displayWidgetPiece(){
		echo "<h3>Pièces disponibles<span><a href='' title='ajouter une nouvelle pièce'>+</a></span></h3>\n";
		echo "<input type='text' id='recherchePiece' maxlength=15 name='recherchePiece' placeholder='rechercher une pièce' />";
		echo "<table>\n";
		
		// en-tête du tableau
		echo "<thead>\n";
		echo "<tr>\n";
		echo "<th>référence</th>\n";
		echo "<th>libellé</th>\n";
		echo "<tr>\n";
		echo "</thead>\n";
		
		// Corps du tableau
		echo "<tbody>\n";
		$this->displayListePieces();
		echo "</tbody>\n";
		echo "</table>\n";
		
		
	}
	
	/**
	 * Affiche les lignes d'un tableau html de pièces (non-PHPdoc)
	 * @see iPiece::displayListePieces()
	 */
	public function displayListePieces($where = ""){
		foreach($this->getList($where) as $piece){
			echo "<tr class='piece' >\n";
			echo "<td>".$piece['reference']."</td>\n";
			echo "<td>".$piece['libelle']."</td>\n";
			echo "</tr>\n";
		}
	}
	
	/*
	 * ###################### Fin widget Pieces ######################
	 */
	

	
	/** 
	 * ###################### Ligne des tableaux de pieces ######################
	 * Affiche une ligne d'un tableau de piece principale éditables
	 * Ajout d'une commande de masse
	 * Modification d'une commande de masse
	 */
	public function displayRowPrincipale($piece){
		echo "<tr>\n";
		echo "<td>".$piece['reference']."</td>\n";
		echo "<td>".$piece['libelle']."</td>\n";
		echo "<td><input type='text' class='tablePiecePrincipaleQuantite' name='tablePiecePrincipaleQuantite' value='".$piece['quantite']."'></td\n>";
		echo "<td><input type='text' class='tablePrincipalePotentiel' name='tablePiecePrincipalePotentiel' value='".$piece['potentiel']."'></td>\n";
		echo "<td class='clickable removable principale'></td>\n";
		echo "</tr>\n";
	}
		
	/**
	 * Affiche une ligne d'un tableau de pieces d'environnement éditable
	 * Ajout d'une commande de masse
	 * Modification d'une commande de masse
	 */
	public function displayRowEnvironnement($piece){
		echo "<tr>\n";
		echo "<td>".$piece['reference']."</td>\n";
		echo "<td>".$piece['libelle']."</td>\n";
		echo "<td><input type='text' class='tablePieceEnvironementQuantite' name='tablePieceEnvironementQuantite' value='".$piece['quantite']."'></td\n>";
		echo "<td class='clickable removable principale'></td>\n";
		echo "</tr>\n";
	}
	
	/**
	 * Affiche une ligne d'un tableau de piece principale non éditable
	 * Visualisation d'une commande de masse
	 */
	public function displayRowPrincipaleDisabled($piece){
		echo "<tr>\n";
		echo "<td>".$piece['reference']."</td>\n";
		echo "<td>".$piece['libelle']."</td>\n";
		echo "<td>".$piece['quantite']."</td\n>";
		echo "<td>".$piece['potentiel']."</td>\n";
		echo "</tr>\n";
	}
	
	/**
	 * Affiche une ligne d'un tableau de piece d'environnement non éditable
	 * Visualisation d'une commande de masse
	 */
	public function displayRowEnvironnementDisabled($piece){
		echo "<tr>\n";
		echo "<td>".$piece['reference']."</td>\n";
		echo "<td>".$piece['libelle']."</td>\n";
		echo "<td>".$piece['quantite']."</td\n>";
		echo "</tr>\n";
	}
	
	/**
	 * Affiche une ligne d'un tableau de piece principale non éditable
	 * Détails et livraisons d'une commande de masse
	 */
	public function displayRowPrincipaleDisabledLivraisons($piece, $noCommande){
		
		print_r_html($livraisons = $this->modeleLivraison->getLivraisonByPieceCommande($piece['reference'], $noCommande));
		
		echo "<tr>\n";
		echo "<td>".$piece['reference']."</td>\n";
		echo "<td>".$piece['libelle']."</td>\n";
		echo "<td>".$piece['quantite']."</td\n>";
		echo "<td>".$piece['potentiel']."</td>\n";
		echo "<td></td>";
		echo "</tr>\n";
		echo "<tr>";
		echo "<td colspan='5'>";
		echo "<span class='headeTableDetails'>Livraisons <br>Date / Quantité</span>";
		for ($i = 0; $i < 10; $i++) 
		{	
			echo $i%2 ==0 ? "<span class='content_date_quantite'>" : "";
			
			echo "<input type='text' class='date' value='"; echo isset($livraisons[$i]) ? html($livraisons[$i]['date_livraison']) : ""; echo "'>";
			echo "<input type='text' class='quantite' value='"; echo isset($livraisons[$i]) ? html($livraisons[$i]['quantite_livree']) : ""; echo "'>";
			
			echo $i%2 == 0 ? "<br />" : "";
			echo $i%2 == 1 ? "</span>" : "";
		}

		echo "</td>";
		echo "</tr>";
	}
	
	/**
	 * Affiche une ligne d'un tableau de piece d'environnement non éditable
	 * Détails et livraisons d'une commande de masse
	 */
	public function displayRowEnvironnementDisabledLivraisons($piece, $noCommande){
		
		print_r_html($livraisons = $this->modeleLivraison->getLivraisonByPieceCommande($piece['reference'], $noCommande));
		echo "<tr>\n";
		echo "<td>".$piece['reference']."</td>\n";
		echo "<td>".$piece['libelle']."</td>\n";
		echo "<td>".$piece['quantite']."</td\n>";
		echo "<td></td>";
		echo "</tr>\n";
		echo "<tr>";
		echo "<td colspan='5'>";
		echo "<span class='headeTableDetails'>Livraisons <br>Date / Quantité</span>";
		for ($i = 0; $i < 10; $i++) 
		{	
			echo $i%2 ==0 ? "<span class='content_date_quantite'>" : "";
			
			echo "<input type='text' class='date' value='"; echo isset($livraisons[$i]) ? html($livraisons[$i]['date_livraison']) : ""; echo "'>";
			echo "<input type='text' class='quantite' value='"; echo isset($livraisons[$i]) ? html($livraisons[$i]['quantite_livree']) : ""; echo "'>";
			
			echo $i%2 == 0 ? "<br />" : "";
			echo $i%2 == 1 ? "</span>" : "";
		}

		echo "</td>";
		echo "</tr>";
	}
	/**
	 * ###################### Fin ligne de tableau de pieces ######################
	 */
	
	
	
	/*
	 * Retourne un tableau de pièce au format no--quantite--potentiel/jour  => array associatif
	 */
 	public function piecesParser($pieces){
 		$newPieces = array();
 		if(!empty($pieces))foreach ($pieces as $piece)
 		{
 			$temp = explode("--", $piece);
 			
 			isset($temp[2]) ? $potentiel = $temp[2] : $potentiel = null;
 			$newPieces[] = array('reference' => $temp[0],
 								 'quantite'  => $temp[1],
 								 'potentiel' => $potentiel);
 		}
 		return $newPieces;
 	}
 	
 	
 	/**
 	 * Affiche un formulaire pour pouvoir ajputer une nouvelle piece (non-PHPdoc)
 	 * @see iPiece::displayAjoutPieces()
 	 */
 	public function displayAjoutPieces()
 	{
 		echo "<div id='confirmOverlay'>\n";
 		echo "<div id='confirmBox'>\n";
 		echo "<table>\n";
 		echo "<h2>Nouvelle Piece </h2>\n";
 		echo "<form id=formPiece name=formulairePiece />\n";
 		echo "<tr>\n";
 		echo "<td>Reference : </td>\n";
 		echo "<td><input type='text' id='newReference' name='reference' /></td>";
 		echo "</tr>\n";
 		echo "</br>";
 		echo "<tr>\n";
 		echo "<td>Libelle : </td>\n";
 		echo "<td><input type='text' id='newLibelle' name='libelle' /></td>";
 		echo "</tr>\n";
 		echo "</form>\n";
 		echo "</table>\n";
 			
 		
 		echo "<div id='confirmButtons'>\n";
 		
 		echo "<a id='ajoutNouvellePiece' class='small blue nice button radius' href='#'><span>ajouter piece</span></a>\n";
 		echo "<a id='annulerAjoutPiece' class='small red nice button radius' href='#'><span>annuler piece</span></a>\n";
 			
 		echo "</div>\n";
 		echo "</div>\n";
 		echo "</div>\n";
 			
 	}
}
?>
