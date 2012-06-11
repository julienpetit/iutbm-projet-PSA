<?php  

session_start(); 

include_once('../connexion/_connexion.php');
require_once("../fonctionhtml.php");  
mysql_query("SET NAMES UTF8");
html_entete_fichier("accueil","../Style.css","fonction.js","./commandeMVC/web/script.js"); 
$num_commande=$_GET['num_commande'];
$choix=$_GET['choix'];

mysql_query("SET NAMES UTF8");
    echo("<body onload=\"etat();\" >");

    echo("<div id=\"titreprincipal\" >Commande unitaire de pi&egrave;ce synchrone</div><br/>
    <form method=\"post\" action=\"accueil.php\" >
    <div id=\"contenu\">");

if(isset($num_commande))
{	
    $sql = "SELECT * FROM COMMANDE WHERE no_commande='".$num_commande."';";
    $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while($data = mysql_fetch_assoc($req)){
                
	echo(   "<label id=\"titre\">Commande N&deg;</label><input readonly type=\"text\" name=\"numCommandeMasse\" id=\"numcom\"  value=".$num_commande.">
			<label>Date</label><input readonly type=\"text\" name=\"jourCommandeMasse\" id=\"jourCommandeMasse\" value=".$data['date_commande']." style=\"width:90px; \" >
			<label>&agrave;</label><input readonly type=\"text\" name=\"heureCommandeMasse\" id=\"heureCommandeMasse\" value=".$data['heure_commande']." style=\"width:90px; \"><br /><br />
                
			<label id=\"titre\">Emetteur</label><input readonly type=\"text\" name=\"EmetteurCM\" id=\"emetteurCM\" value=".$data['id_utilisateur_passe'].">");
            $id_utilisateur=$data['id_utilisateur_passe'];
    
    
    $sql1 = "SELECT * FROM UTILISATEUR WHERE id_utilisateur='".$id_utilisateur."';";
    $req1 = mysql_query($sql1) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while($data1 = mysql_fetch_assoc($req1)){
    
    
	echo(  "<input readonly type=\"text\" name=\"Utilisateur\" id=\"utilisateur\" value=".$data1['nom_utilisateur'].">
			<input readonly type=\"text\" name=\"Sigle\" id=\"sigle\"  value=".$data1['service_utilisateur']."><br />
			<label id=\"titre\">Et</label><input readonly type=\"text\" name=\"Tel\" id=\"tel\"  value=".$data1['no_telephone'].">");
       
                }
           }
?>

<br /><br />
    
    <?php
$sql = "SELECT f.id_fournisseur, f.nom_fournisseur, p.reference_piece, p.designation_piece, c.quantite_piece FROM FOURNISSEUR f, PIECE p, COMPREND c, COMMANDE co 
        WHERE co.no_commande=c.no_commande AND co.id_fournisseur=f.id_fournisseur AND p.reference_piece=c.reference_piece AND co.no_commande=".$num_commande.";";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_assoc($req)){

$id_fournisseur=$data['id_fournisseur'];
               ?>
    <table>
        <caption id="titre1"> Pi&egrave;ces commande </caption>
   	    <tr> 
	        <td><label id="titre">Fournisseurs</label> 
                <?php    echo("<input readonly value=".$data['nom_fournisseur'].">");   ?>
            </td>
          
        </tr>
        
        <tr> 
	        <td><label id="titre">R&eacute;ference</label><?php echo("<input readonly value=".$data['reference_piece'].">");?></td>
	        <td><label>Quantit&eacute;</label><?php echo("<input readonly value=".$data['quantite_piece'].">");?></td>
        </tr>
        <tr>
	        <td><label id="titre">D&eacute;signation</label><?php echo("<input readonly value=".$data['designation_piece'].">");?></td>
        </tr>

    </table>
    <?php }  ?>
<br />
<?php
$sql = "SELECT co.ref_vehicule, co.desc_defaut, s.code_silhouette, s.libelle_silhouette FROM SILHOUETTE s, COMMANDE co, FOURNISSEUR f
         WHERE co.id_fournisseur=f.id_fournisseur AND co.code_silhouette=s.code_silhouette AND co.no_commande=".$num_commande.";";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data = mysql_fetch_assoc($req);

$sql1 = "SELECT code_mode_ref_vehicule FROM FOURNISSEUR WHERE id_fournisseur=".$id_fournisseur.";";
$req1 = mysql_query($sql1) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data1 = mysql_fetch_assoc($req1);

?>
    <table id="vehicule_concerne">
        <caption id="titre1" style="text-align:left;">Vehicule concern&eacute;</caption>

        <tr> 
	        <td><label id="titre"><?php echo($data1['code_mode_ref_vehicule']); ?></label><?php echo("<input readonly value=".$data['ref_vehicule'].">"); ?></td>
        </tr>
        <tr> 
	        <td><label id="titre">Silhouette</label>
                <?php echo("<input readonly value=".$data['libelle_silhouette'].">"); ?>
            </td>

	        <td>
               <?php echo("<input readonly value=".$data['code_silhouette'].">"); ?>                
            </td>
        </tr>
        <tr>
	        <td><label id="titre" class="select">Description defaut</label> <?php echo("<textarea readonly rows=\"2\" cols=\"20\" >".$data['desc_defaut']."</textarea>"); ?></td>
        </tr>

    </table>

<br />
    
<?php
$sql = "SELECT e.libelle_entite, e.code_imputation FROM ENTITE e, COMMANDE co WHERE e.code_imputation = co.code_imputation AND co.no_commande=".$num_commande.";";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_assoc($req)){


?>
    <table id="Responsable defaut">
        <caption id="titre1" >Responsable d&eacute;faut </caption>
   	
		<tr> 
             <td><label id="titre">Entit&eacute;</label> 
               <?php echo("<input readonly value=".$data['libelle_entite'].">"); ?>
             </td>
        </tr>
		<tr> 
            <td><label id="titre">CA imput&eacute;</label><?php echo("<input readonly value=".$data['code_imputation'].">"); ?></td>
        </tr>
		
    </table>
    <?php  }  ?>
    <br />
   
    <?php
    
$sql = "SELECT co.date_reception, co.heure_reception, co.id_utilisateur_receptionne, u.nom_utilisateur  FROM COMMANDE co, UTILISATEUR u 
        WHERE co.id_utilisateur_receptionne= u.id_utilisateur AND co.no_commande=".$num_commande.";";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_assoc($req)){


?>
    <table id="Reception">
        
   	
		<tr> 
             <td><label id="titre">R&eacute;c&eacute;ption prononc&eacute; le:</label> 
               <?php echo("<input readonly value=".$data['date_reception'].">"); ?>
             </td>
            
            <td><label>par </label> 
               <?php echo("<input readonly value=".$data['nom_utilisateur'].">"); ?>
             </td>
        </tr>
		<tr> 
            <td><label id="titre">� </label><?php echo("<input readonly value=".$data['heure_reception'].">"); ?></td>
        </tr>
		
    </table>
    <?php  }  ?>
     <br />
    <br />
   <?php   }
	  if ($choix==2)
	  {  	
	  	echo "<a class=\"small red nice button radius\" href=\"./accueil.php\">Accueil</a>";
	  }
      else if ($choix==4)
	  {	
        echo "
	  	<a class=\"small red nice button radius\" href=\"./traitement/annuler_commande.php?num_commande=".$num_commande."\">Annuler la commande</a>
	  	<a class=\"small red nice button radius\" href=\"./accueil.php\">Accueil</a>";
		} ?>	
  

<div id="test">
<div id="etat" class="etat_synch">
    
    
</div>
    </div>
<div id="pieces_fournie">
    
           <?php
$sql = "SELECT t.libelle_type_piece_2 FROM TYPE_PIECE2 t, APPROVISIONNE a, FOURNISSEUR f WHERE a.id_fournisseur=f.id_fournisseur AND a.libelle_type_piece_2=t.libelle_type_piece_2 AND a.id_fournisseur='$id_fournisseur';";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_assoc($req)){
echo("<p>Pi�ces fournies:<br/>".$data['libelle_type_piece_2']."</p>");
}
?>
   
</div>

</body>
</html>
