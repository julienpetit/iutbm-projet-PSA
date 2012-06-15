<?php include('../connexion/_connexion.php');


mysql_query("SET NAMES UTF8");
$no=$_POST['noSilouhette'];
$libelle=$_POST['libelleSilouhette'];

   
if(!empty($no) && !empty($libelle))
{
	//création de la requête SQL:
	$sql_save="UPDATE SILHOUETTE SET libelle_silhouette = '$libelle' WHERE code_silhouette = '$no'";
	//exécution de notre requête SQL:
	$result_save = mysql_query($sql_save) or die( mysql_error());

	exit();
}
mysql_close();
?>
