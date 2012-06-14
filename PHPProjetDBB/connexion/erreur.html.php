<?php
//header("Location: /commande/accueil.php");
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/connexion/_connexion.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/include/layout/layout.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/include/library/library.inc.php');

require_once($_SERVER['DOCUMENT_ROOT']."/fonctionhtml.php");
require_once($_SERVER['DOCUMENT_ROOT']."/connexion/verification_connexion.php");

mysql_query("SET NAMES UTF8");

header_html("GESTION DES COMMANDES",array("include/framework/foundation.css", "accueil.css"),array(), true); 
?>
	<style>
		#erreur{
			text-align: center;
			color: #FF0000;
			letter-spacing: 3px;
		}
	</style>
	
		<div id='erreur'>
	
			<br/><br/>
			<br/><br/>
	
			<h1> Vous n'avez pas les droits pour acc&eacuteder &agrave cette page </h1>
	
			<br/><br/>
			<br/><br/>
	
			<a href='/'><h2><b>Retournez à l'accueil</b></h2></a>
		</div>
	
	
<?php 
footer_html();
?>