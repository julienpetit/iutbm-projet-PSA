<?php

interface iPiece
{
	public function getList($where="", $min=0, $max=0);
	public function getPiece($ReferencePiece);

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



	

	public function __construct($link)
	{	
		$this->link = $link;
		
		
	}


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

	public function getPiece($ReferencePiece){
		$tabPiece = $this->getList(" AND reference_piece = '$ReferencePiece'", 0, 1);

		return $tabPiece[0];
	}

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

	public function removePiece($referencePiece){

		$sql = "DELETE FROM PIECE WHERE reference_piece = '$ReferencePiece';";

		if(!$resultat = mysqli_query($this->link, $sql)) {
			echo "Erreur de suppression de la Piece $ReferencePiece.";
			exit();
		}

		return true;
	}

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
	
	public function displayListePieces($where = ""){
		
		foreach($this->getList($where) as $piece){
			echo "<tr class='piece' >\n";
			echo "<td>".$piece['reference']."</td>\n";
			echo "<td>".$piece['libelle']."</td>\n";
			echo "</tr>\n";
		}
		
	}
}
?>
