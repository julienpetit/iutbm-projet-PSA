<?php include('../connexion/_connexion.php');
mysql_query("SET NAMES UTF8");
//recuperation du numero de l'abonne dans l'url
$piece_select=$_POST['noPiece'];

//création de la requête SQL:
$sql="SELECT * FROM PIECE WHERE reference_piece = '".$piece_select."'";
//exécution de notre requête SQL:
$result = mysql_query($sql);

			// AFFICHAGE DU TABLEAU:

while($row = mysql_fetch_array($result))
{
echo "
<form id=\"myform\">



<label id=\"label\" for=\"reference_piece\">reference piece:</label>
<input readonly type=\"text\" name=\"reference_piece\" id=\"reference_piece\" value=\"".$row['reference_piece']."\" /><br/>

<label id=\"label\" for=\"designation_piece\">libelle piece</label>
<input type=\"text\" name=\"designation_piece\" id=\"designation_piece\" value=\"".$row['designation_piece']."\" /></br>

<button type=\"button\" id=\"but_mod\" onClick=\"Sauvegarde_piece()\">Sauvegarder</button>
<button type=\"button\" onClick=\"choix_table('piece')\" >Annuler</button
</form>";
}

mysql_close();
?>
