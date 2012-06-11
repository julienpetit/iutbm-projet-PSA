<?php  
session_start(); 
include('../connexion/_connexion.php');
require_once("../connexion/verification_connexion.php");
require_once("../fonctionhtml.php");  
check_log_user(4,NULL);
html_entete_fichier("accueil","../Style.css","fonction.js"); 
mysql_query("SET NAMES UTF8");

echo("<body>");
	$num_commande=$_POST['num_commande'];

     echo("   <div id=\"titreprincipal\">Commande de masse</div><br/>" );
    echo( "<form method=\"post\" action=\"traitement/modif_generale.php?choix=2 & num_commande=$num_commande\">
        <div id=\"contenu\">
        <table border=\"0\" cellspacing=\"\" cellpadding=\"\" >");

if ($_POST['choix'] == 1)
{      
    $reference = $_POST['reference'];
    $designation = $_POST['designation'];
    $quantite = $_POST['quantite'];
    $potentiel = $_POST['potentiel'];
    $resteLivre = $_POST['resteLivre'];
    
   
    $sql = "DELETE FROM LIVRAISON WHERE reference_piece='".$reference."' AND no_commande=$num_commande";
    $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());       

    $sql = "DELETE FROM CADENCEE WHERE reference_piece='".$reference."' AND no_commande=$num_commande";
    $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());    

    $sql = "DELETE FROM COMPREND WHERE reference_piece='".$reference."' AND no_commande=$num_commande AND libelle_type_piece = \"pieces principales\"";
    $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());  
}

if ($_POST['choix'] == 2)
{
    $reference = $_POST['reference'];
    $designation = $_POST['designation'];
    $quantite = $_POST['quantite'];
    $resteLivre = $_POST['resteLivre'];
    
        
    $sql = "DELETE FROM LIVRAISON WHERE reference_piece='".$reference."' AND no_commande=$num_commande";
    $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());           

    $sql = "DELETE FROM COMPREND WHERE reference_piece='".$reference."' AND no_commande=$num_commande AND libelle_type_piece = \"pieces environnement\"";
    $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error()); 
}
?>
