<?php
//header("Location: /commande/accueil.php");
session_start();
include_once('connexion/_connexion.php');
include_once('include/layout/layout.inc.php');
include_once('include/library/library.inc.php');

require_once("fonctionhtml.php");
require_once("connexion/verification_connexion.php");

mysql_query("SET NAMES UTF8");

header_html("GESTION DES COMMANDES",array("include/framework/foundation.css", "accueil.css"),array(), true); 

echo("
		<div id='erreur'>
		
			<h1> Vous n'avez pas les droits pour accéder à cette page </h1>
		
			<a href='/' />
		</div>
		");
footer_html();
?>