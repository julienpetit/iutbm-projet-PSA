<?php
// connexion a la BD
// Paramètres persos
$host 	= "localhost"; 	// voir hébergeur
$user 	= "root"; 	// identifiant de votre BD (vide ou "root" en local)
$pass 	= "root"; 	// mot de passe de votre BD (vide en local)
$bdd 	= "projetBdd"; 	// nom de la BD
// --------------------------------
// connexion
@mysql_connect($host,$user,$pass) or die("Impossible de se connecter: ".mysql_error());
@mysql_select_db("$bdd") or die("Impossible de se connecter: ".mysql_error());
// --------------------------------
?>