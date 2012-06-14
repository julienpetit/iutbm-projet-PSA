<?php
//header("Location: /commande/accueil.php");
session_start();
include_once('connexion/_connexion.php');
include_once('include/layout/layout.inc.php');
include_once('include/library/library.inc.php');
include_once('include/library/bd.inc.php');
include_once('include/classes/commande.class.php');

require_once("fonctionhtml.php");
require_once("connexion/verification_connexion.php");

mysql_query("SET NAMES UTF8");
check_log_user(1,NULL);

$modeleCommande = new Commande($link);

/**
 * redirection vers la page d'accueil
 */
if(isset($_GET['accueil'])) {
	header("Location: /commande/accueil.php");
	exit();
}


/**
 * Ajax --> verification si une commande existe
 */
if(isset($_GET['ajax']) && $_GET['ajax'] == "verifierPresenceCommande")
{
	$noCommande = html($_POST['noCommande']);
	echo $modeleCommande->verifiePresenceCommande($noCommande) == true ? "1" : "0";
	exit();
}


/**
 * Ajax --> autocomplétion
 */
if(isset($_GET['ajax']) && $_GET['ajax'] == "searchCommande")
{
	$chaine = html($_GET['term']);
	
	$modeleCommande->autocomplete($chaine);
	exit();
}



include("accueil.html.php");
?>