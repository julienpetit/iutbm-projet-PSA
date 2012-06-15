<?php 
session_start();
include('../connexion/_connexion.php');
mysql_query("SET NAMES UTF8");
$id=$_POST['id'];
$nom=$_POST['nom'];
$prenom=$_POST['prenom'];
$service=$_POST['service'];
$tel=$_POST['tel'];
$email=$_POST['email'];
$mdp=$_POST['mdp'];
   

if(!empty($id) && !empty($nom) && !empty($prenom) && !empty($service) && !empty($tel) && !empty($email) && empty($mdp))
{
	//création de la requête SQL:
	$sql_save="UPDATE UTILISATEUR SET nom_utilisateur = '$nom', prenom_utilisateur = '$prenom', 
	service_utilisateur = '$service', no_telephone = '$tel', 
	email_utilisateur = '$email' WHERE id_utilisateur = '$id';";
	//exécution de notre requête SQL:
	$result_save = mysql_query($sql_save) or die( mysql_error());

}
elseif(!empty($id) && !empty($nom) && !empty($prenom) && !empty($service) && !empty($tel) && !empty($email) && !empty($mdp))
{
	//création de la requête SQL:
	$sql_save="UPDATE UTILISATEUR SET nom_utilisateur = '$nom', prenom_utilisateur = '$prenom', 
	service_utilisateur = '$service', no_telephone = '$tel', 
	email_utilisateur = '$email', mdp_utilisateur = md5('$mdp') WHERE id_utilisateur = '$id';";
	//exécution de notre requête SQL:
	$result_save = mysql_query($sql_save) or die( mysql_error());

}
else
{ 
  echo("Des champs sont vides");
  header("Refresh: 3;URL= maj.php/modif_utilisateur.php");
}


$sql_droit="DELETE FROM POSSEDE WHERE id_utilisateur = '$id';";
$result_droit = mysql_query($sql_droit);

for($i=0;$i<$_POST['nb_droits'];$i++){
		$query ="INSERT INTO POSSEDE values('".$_POST['droit_'.$i]."','$id')";
		$result = mysql_query($query);
        $droit[$i]=$_POST['droit_'.$i];
}
if($_SESSION['pseudo']==$id)
{
$_SESSION['no_droit']=$droit;
}
exit();
mysql_close();
?>

