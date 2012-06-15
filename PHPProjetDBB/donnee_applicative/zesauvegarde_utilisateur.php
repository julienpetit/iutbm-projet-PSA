<?php include('../connexion/_connexion.php');
mysql_query("SET NAMES UTF8");
$no=$_GET['id'];
$nom=$_GET['nom'];
$prenom=$_GET['prenom'];
$service=$_GET['service'];
$tel=$_GET['tel'];
$email=$_GET['email'];
$mdp=$_GET['mdp'];
   
      
if(!empty($no) && !empty($nom) && !empty($prenom) && !empty($service) && !empty($tel) && !empty($email) && !empty($mdp))
{
	//création de la requête SQL:
	$sql_save="UPDATE UTILISATEUR SET nom_utilisateur = '$nom', prenom_utilisateur = '$prenom', 
	service_utilisateur = '$service', no_telephone = '$tel', 
	email_utilisateur = '$email', mdp_utilisateur = '$mdp' WHERE id_utilisateur = '$no';";
	//exécution de notre requête SQL:
	$result_save = mysql_query($sql_save) or die( mysql_error());

	exit();
}
else
{ 
  echo("Des champs sont vides");
  header("Refresh: 3;URL= maj.php/modif_utilisateur.php");
}
mysql_close();
?>