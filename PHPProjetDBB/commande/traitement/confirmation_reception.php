<?php  

include('../../connexion/_connexion.php'); //fichier permettant d'enregistrer la réception d'une commande synchrone

mysql_query("SET NAMES UTF8");
$query = "UPDATE COMMANDE SET date_reception = '".$_POST['date_reception']."',motif_fermeture='récéptionée',heure_reception = '".$_POST['heure_reception']."', date_fermeture = '".$_POST['date_reception']."', heure_fermeture='".$_POST['heure_reception']."' WHERE no_commande = '".$_POST['no_commande']."';";
$reponse = mysql_query($query) or die('Erreur SQL !<br>'.$query.'<br>'.mysql_error());

echo "<script event=onload>
			alert('La réception a été enregistrée');
			document.location.href='../accueil.php';
			</script>";
?>
