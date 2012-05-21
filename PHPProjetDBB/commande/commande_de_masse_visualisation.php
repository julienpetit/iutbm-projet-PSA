<?php  

session_start(); 
include('../connexion/_connexion.php');
mysql_query("SET NAMES UTF8");
require_once("../fonctionhtml.php");  

html_entete_fichier("accueil","../Style.css","fonction.js"); 

$num_commande=$_GET['num_commande'];
$choix=$_GET['choix'];

echo("<body onload=\"etat();\" >");
	

     echo("<div id=\"titreprincipal\">Commande de masse</div><br/>" );
    echo( "<form method=\"post\" action=\"masses_details_visualisation.php?num_commande=$num_commande\">
        <div id=\"contenu\">
        <table border=\"0\" cellspacing=\"\" cellpadding=\"\" >");
           

    $sql = "SELECT * FROM COMMANDE WHERE no_commande='".$num_commande."';";
    $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while($data = mysql_fetch_assoc($req)){
              /*************************************Entête*********************************/  
	echo(   "<label id=\"titre\">Commande N&deg;</label><input readonly type=\"text\" name=\"numCommandeMasse\" id=\"numcom\"  value=".$num_commande.">
			<label>Date</label><input readonly type=\"text\" name=\"jourCommandeMasse\" id=\"jourCommandeMasse\" value=".$data['date_commande'].">
			<label>&agrave;</label><input readonly type=\"text\" name=\"heureCommandeMasse\" id=\"heureCommandeMasse\" value=".$data['heure_commande']."><br /><br />
                
			<label id=\"titre\">Emetteur</label><input readonly type=\"text\" name=\"EmetteurCM\" id=\"emetteurCM\" value=".$data['id_utilisateur_passe'].">");
    $id_utilisateur=$data['id_utilisateur_passe'];
    
     $sql1 = "SELECT * FROM UTILISATEUR WHERE id_utilisateur='".$id_utilisateur."';";
    $req1 = mysql_query($sql1) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while($data1 = mysql_fetch_assoc($req1)){
    
    
	echo(  "<input readonly type=\"text\" name=\"Utilisateur\" id=\"utilisateur\" value=\"".$data1['nom_utilisateur']."\">
			<input readonly type=\"text\" name=\"Sigle\" id=\"sigle\"  value=\"".$data1['service_utilisateur']."\"><br />
			<label id=\"titre\">Et</label><input readonly type=\"text\" name=\"Tel\" id=\"tel\"  value=\"".$data1['no_telephone']."\">");
       
                }
                }
		/*********************************************************************************/	
?>
               
         <br /> <br /> 
                <label id="titre">R&eacute;f&eacute;rence dossier</label>
                        <?php 
			$sql_rd = "SELECT * FROM COMMANDE WHERE no_commande='".$num_commande."';";
			$req_rd = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
			while($data_rd = mysql_fetch_assoc($req_rd)){
				
				echo("<input readonly type=\"text\" name=\"typeChantierCM\" id=\"typeChantierCM\" value=".$data_rd['libelle_type_chantier']." />				 
				<input readonly type=\"text\" name=\"textReferenceDossierCM\" id=\"textReferenceDossierCM\" value=".$data_rd['no_chantier']." /><br /><br /><br />");
			}
			?> 
                

                <table>
                    <caption id="titre1"> Commande </caption>
	                    <tr>
                            <th><p id="sous-titre">R&eacute;f&eacute;rence</p> </th>
                            <th><p id="sous-titre">D&eacute;signation</p> </th>
                            <th><p id="sous-titre">Quantit&eacute;</p></th>
                            <th><p id="sous-titre">Potentiel/jour</p> </th>
                            <th><p id="sous-titre">Reste &agrave; livrer</p> </th>
	                    </tr>
	
	                    <tr>
                            <td>  </td>
                            <td id="type_piece">Pi&egrave;ce principales</td>
                            <td>  </td>
                            <td>  </td>
                            <td>  </td>
	                    </tr>
	<?php
$sql = "SELECT p.reference_piece, p.designation_piece, c.quantite_piece, ca.potentiel_jour FROM PIECE p, COMPREND c, COMMANDE co, CADENCEE ca 
        WHERE co.no_commande=c.no_commande AND p.reference_piece=c.reference_piece AND co.no_commande=ca.no_commande
        AND c.reference_piece=ca.reference_piece AND c.no_commande=ca.no_commande AND co.no_commande=".$num_commande." AND c.libelle_type_piece='pieces principales';";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

$i=0;// cette variable permet d'avoir des nom et id unique pour chaques champs.
while($data = mysql_fetch_assoc($req)){
$i++;

$sql_quantite="SELECT SUM(quantite_livree) AS quantite FROM LIVRAISON WHERE reference_piece='".$data['reference_piece']."' 
                            AND no_commande='".$num_commande."';"; 
$resultat_quantite= mysql_query($sql_quantite) or die('Erreur SQL !<br>'.$sql_quantite.'<br>'.mysql_error());
$data1=mysql_fetch_assoc($resultat_quantite);

$reste=$data['quantite_piece']-$data1['quantite'];

	    echo "<tr><td><input readonly type=\"text\" name=\"ReferenceCM_pp\" id=\"ReferenceCM_pp$i\" value=\"".$data['reference_piece']."\"></td>
                            <td><input readonly type=\"text\" name=\"DesignationCM_pp\" id=\"DesignationCM_pp$i\"  value=\"".$data['designation_piece']."\"></td>
                            <td><input readonly type=\"text\" name=\"QuantiteCM_pp\" id=\"QuantiteCM_pp$i\"   value=\"".$data['quantite_piece']."\"></td>
                            <td><input readonly type=\"text\" name=\"PotentielCM_pp\" id=\"PotentielCM_pp$i\"  value=\"".$data['potentiel_jour']."\"></td>
                            <td><input readonly type=\"text\" name=\"ResteLivreCM_pp\" id=\"ResteLivreCM_pp$i\" value=\"".$reste."\"/> </td>
	          </tr>";
	 }  ?>
                  
	                    <tr>
                            <td>  </td>
                            <td id="type_piece">Pi&egrave;ces d'environnement</td>
                            <td >  </td>
                            <td >  </td>
                            <td>  </td>
	                    </tr>
	  <?php
$sql = "SELECT p.reference_piece, p.designation_piece, c.quantite_piece FROM PIECE p, COMPREND c, COMMANDE co 
        WHERE co.no_commande=c.no_commande AND p.reference_piece=c.reference_piece AND co.no_commande=".$num_commande." AND c.libelle_type_piece='pieces environnement';";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

$i1=0;

while($data = mysql_fetch_assoc($req)){

$i1++;

$sql_quantite1="SELECT SUM(quantite_livree) AS quantite FROM LIVRAISON WHERE reference_piece='".$data['reference_piece']."' 
                            AND no_commande='".$num_commande."';"; 
$resultat_quantite1= mysql_query($sql_quantite1) or die('Erreur SQL !<br>'.$sql_quantite1.'<br>'.mysql_error());
$data2=mysql_fetch_assoc($resultat_quantite1);

$reste1=$data['quantite_piece']-$data2['quantite'];
               
	           echo "<tr>
                            <td><input readonly type=\"text\" name=\"ReferenceCM_pe\" id=\"ReferenceCM_pe$i1\" value=".$data['reference_piece']."></td>
                            <td><input readonly type=\"text\" name=\"DesignationCM_pe\" id=\"DesignationCM_pe$i1\" value=".$data['designation_piece']."></td>
                            <td><input readonly type=\"text\" name=\"QuantiteCM_pe\" id=\"QuantiteCM_pe$i1\"   value=".$data['quantite_piece']."></td>
                            <td>  </td>
                            <td><input readonly type=\"text\" name=\"ResteLivreCM_pe\" id=\"ResteLivreCM_pe$i1\"  value=\"".$reste1."\"/> </td>
	                    </tr>";
	  } ?>
	
            </table><br /><br /><br /> 

            
 <?php
$sql = "SELECT e.libelle_entite, e.code_imputation , co.motif_fermeture FROM ENTITE e, COMMANDE co WHERE e.code_imputation = co.code_imputation AND co.no_commande=".$num_commande.";";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_assoc($req)){


?>           
            <table id="derniere">

	                    <tr>
                            <th id="titre1"><p>Responsable par d&eacute;faut</p> </th>
                            <th> </th>
                            <?php
                            if(!empty($data['motif_fermeture']))
                            {
                            echo "<th readonly id=\"titre1\"><p>Motif de fermeture </p></th>";
                            }
	                    ?>
                        </tr>
                        
	
	
	                    <tr>
                            <th> <p>Entit&eacute;</p> </th>
                            <td>
                                <?php echo("<input readonly value=".$data['libelle_entite'].">"); ?>
                            </td>
                            <?php
                            if(!empty($data['motif_fermeture']))
                            {
                            echo "<td readonly rowspan=\"2\"> <textarea rows=\"3\" cols=\"30\" name=\"MotifFermetureCM\" id=\"MotifFermetureCM\" style=\"margin-left: 250px;\">".$data['motif_fermeture']."</textarea> </td>";
                            }
                            ?>
	                    </tr>
	
	                    <tr>
                            <th> <p>CA imput&eacute;</p> </th>
                            <td id="resultat">
                                <?php echo("<input readonly value=".$data['code_imputation'].">"); ?>
                            </td>
	                    </tr>	 

	
            </table>
            
            
        
        <?php   }
	  if ($choix==2)
	  { ?>  
		<input type="submit" id="val" action="" value="Détail commande">
        <input type="reset" id="anu" value="Remettre a zero">
        <input type="reset" id="anu" value="Accueil" onclick="document.location.href='accueil.php' "/> 
        </div>
	  <?php   }
      else if ($choix==4)
	  {	
        echo"<a href=\"./masses_details_visualisation.php?num_commande=".$num_commande." \">Détail commande</a>
        <a href=\"./traitement/annuler_commande.php?num_commande=".$num_commande." \">Annuler</a>";
       ?>
        <input type="reset" id="anu" value="Accueil" onclick="document.location.href='accueil.php'"/> 
        </div>
		
	 <?php } ?>	
        
    </form>
    <div id="etat">
    
    
    </div>
  </body>
    
</html>

