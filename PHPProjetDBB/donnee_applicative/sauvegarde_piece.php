<?php include('../connexion/_connexion.php');


mysql_query("SET NAMES UTF8");
$no=$_POST['noPiece'];
$libelle=$_POST['libellePiece'];

   
if(!empty($no) && !empty($libelle))
{
	//création de la requête SQL:
	$sql_save="UPDATE PIECE SET designation_piece = '$libelle' WHERE reference_piece = '$no'";
	//exécution de notre requête SQL:
	$result_save = mysql_query($sql_save) or die( mysql_error());

	exit();
}
mysql_close();
?>