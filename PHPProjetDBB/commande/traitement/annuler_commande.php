<?php  
session_start();
include('../../connexion/_connexion.php');

mysql_query("SET NAMES UTF8");
require_once("../../fonctionhtml.php");  
require_once("../../connexion/verification_connexion.php");
html_entete_fichier("","../../Style.css","../fonction.js"); 
check_log_user(5,NULL);//fonction permettant de savoir si l'utilisateur peut annuler une commande ou non.

if (isset($_GET['num_commande'])){//si on a bien un numéro de commande transmis

	$req = "select motif_fermeture from COMMANDE where no_commande = '".$_GET['num_commande']."'";
	
	$query = mysql_query($req) or die('Erreur SQL !<br />'.$req.'<br />'.mysql_error());
	$donnee = mysql_fetch_assoc($query);
	if ($donnee['motif_fermeture'] != NULL)     //si la date de fermeture existe alors elle est déjà fermée
	{
		if ($donnee['motif_fermeture'] == "annulée")
			echo '<script event=onload>toMenu("La commande n\'a pas pu être annulée : elle est déjà annulée.");</script>';
		else if ($donnee['motif_fermeture'] == "recu")
			echo '<script event=onload>toMenu("La commande n\'a pas pu être annulée : elle est déjà réceptionnée.");</script>';
		else
			echo '<script event=onload>toMenu("La commande n\'a pa pu être annulée.");</script>';
	}
		
	else {                                      //sinon on l'annule
		$jour = date("Y-m-j");
		$heure = date("G:i:s");
		$req = "update COMMANDE set motif_fermeture = 'annulée', date_annulation = '".$jour."', heure_annulation = '".$heure."', date_fermeture= '".$jour."', heure_fermeture='".$heure."' where no_commande = '".$_GET['num_commande']."';";
		$modifie = mysql_query($req) or die('Erreur SQL !<br />'.$req.'<br />'.mysql_error());
		if(!$modifie)
			echo '<script event=onload>toMenu("La commande n\'a pa pu être annulée.");</script>';
		else	
			echo '<script event=onload>toMenu("La commande a bien été annulée.");</script>';
	}
}
else
	echo '<script event=onload>toMenu("Le numéro de commande n\'est pas renseigné");</script>';//si numéro de commande vide alors message d'erreur.

?>
