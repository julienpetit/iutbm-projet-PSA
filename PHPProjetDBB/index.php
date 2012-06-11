<?php
//header("Location: /commande/accueil.php");
session_start();
include_once('connexion/_connexion.php');
include_once('include/layout/layout.inc.php');
include_once('include/library/library.inc.php');

require_once("fonctionhtml.php");
require_once("connexion/verification_connexion.php");

mysql_query("SET NAMES UTF8");
check_log_user(1,NULL);

if(isset($_GET['accueil'])) {
	header("Location: /commande/accueil.php");
	exit();
}


include("accueil.html.php");
?>