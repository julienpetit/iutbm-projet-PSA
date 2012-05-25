<?php 
$link = mysqli_connect('localhost', 'root', '', 'projetbdd');
if (!$link)
{
	$erreur = 'Impossible de se connecter au serveur MySQL?';
	echo $erreur;
	exit();
}

mysqli_query($link, "SET NAMES UTF8");
?>