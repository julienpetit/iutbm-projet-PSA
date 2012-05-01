<?php
session_start(); 
require 'class.csv.php';
include('../connexion/_connexion.php'); 
mysql_query("SET NAMES UTF8");
$droit=$_SESSION['no_droit'];
$options[]=$_POST['options'];
$data=0; 

for($i=0;$i<(sizeof($options)-1);$i++) // tant que $i est inferieur au nombre d'éléments du tableau...
    { 
	$nombase=$options[$i];
	try {
        	$PDO = new PDO('mysql:host=serveurmysql;dbname=s3b1prod','bdds3b1','bdds3b1');
        	$PDO->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
        	$PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
	    }
	catch(PDOException $e){
        	echo 'connexion impossible';
            }
        
 	$req = $PDO->prepare("SELECT * FROM $nombase;");
 	$req->execute();
 	$data = $req->fetchAll();
 	CSV::export($data,"export_$nombase");
    }

header("Refresh: 5;URL=../commande/accueil.php");
echo("<style type=\"text/css\">
  body {
    color: blue;
    background-color: #EBFF87 }
  </style><body><h>Les donn&eacute;es s&eacute;l&eacute;ctionn&eacute; sont export&eacute; dans le fichier Data_Export/export_NomTable</h></body>");

?>
