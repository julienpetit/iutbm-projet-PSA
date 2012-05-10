<?php

interface iPiece
{
	public function getList($where="", $min=0, $max=0);
	public function getPiece($ReferencePiece);
	public function getPieceByCommandeId($noCommande);

	public function addPiece($ReferencePiece,
				  			 $DesignationPiece);

	public function removePiece($ReferencePiece);
	public function updatePiece($ReferencePiece,
				  			    $DesignationPiece);
	
	public function displayWidgetPiece();
	public function displayListePieces($where = "");

}

class Piece implements iPiece
{

	public $link;
	
	
	public function __construct($link) { $this->link = $link; }

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
		$sql = "SELECT reference_piece,designation_Piece FROM PIECE
			    $where
			    $limit;";
		
		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de récupération des Pieces.";
			exit();
		}
		
		// Création d'une liste de Pieces
		$Pieces = array();
		while ($row = mysqli_fetch_row($resultat)){
			$Pieces[] = array('reference' 	  		=> $row[0],
					   		  'libelle' 	   		=> $row[1]);
		}

		return $Pieces;
	}

	/**
	 * retourne une pièce sous forme de tableau(non-PHPdoc)
	 * @see iPiece::getPiece()
	 */
	public function getPiece($ReferencePiece){
		$tabPiece = $this->getList(" AND reference_piece = '$ReferencePiece'", 0, 1);

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
				WHERE c.no_commande = $noCommande;";
	
		if(!$resultat = mysqli_query($this->link, $sql)) 
		{
			echo "Erreur : piece.class->getPieceByCommandeId($noCommande).";
		}
		
		$princ = array();
		$env = array();
		while ($row = mysqli_fetch_row($resultat))
		{
			if($row[0] == "pieces environnement") 
			{
				$princ[] = array('reference' => $row[1],
								 'libelle'   => $row[2],
								 'quantite'  => $row[3]
								);	
			}
			if($row[0] == "pieces principales")
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
	 * Affiche seulement les lignes d'un tableau html de pièces (non-PHPdoc)
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
	
	
	public function displayRowPrincipale($piece){
		echo "<tr>\n";
		echo "<td>".$piece['reference']."</td>\n";
		echo "<td>".$piece['libelle']."</td>\n";
		echo "<td><input type='text' class='tablePieceEnvironementQuantite' name='tablePiecePrincipaleQuantite' value='".$piece['quantite']."'></td\n>";
		echo "<td><input type='text' class='tableEnvironnementPotentiel' name='tablePieceEnvironnementPotentiel' value='1'></td>\n";
		echo "<td class='clickable removable principale'></td>\n";
		echo "</tr>\n";
	}
	
}
?>
