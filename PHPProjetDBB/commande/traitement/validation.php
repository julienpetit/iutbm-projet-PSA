<?php
session_start();
include('../../connexion/_connexion.php');
require_once("../../fonctionhtml.php");            // fichier permettant la fermeture de la commande
html_entete_fichier("accueil","../../Style.css");
mysql_query("SET NAMES UTF8");

$sql="UPDATE COMMANDE SET id_utilisateur_ferme='".$_GET['vali']."', heure_fermeture='".$_GET['hour']."', date_fermeture='".$_GET['date']."', motif_fermeture='".$_POST['MotifFermetureCM']."' WHERE no_commande = '".$_GET['num_commande']."'";
$req=mysql_query($sql) or die('Erreur SQL : <br />'.$sql.mysql_error());


                echo "commande fermée avec succès";
                header("Refresh: 2; url=../accueil.php");
                exit();

?>
