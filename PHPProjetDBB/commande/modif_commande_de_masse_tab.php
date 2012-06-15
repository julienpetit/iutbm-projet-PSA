<?php  
session_start(); 
include('../connexion/_connexion.php');
require_once("../connexion/verification_connexion.php");
require_once("../fonctionhtml.php");  
check_log_user(4,NULL);
html_entete_fichier("accueil","../Style.css","fonction.js"); 
mysql_query("SET NAMES UTF8");
echo("<body>");
	$num_commande=$_GET['num_commande'];

     echo("   <div id=\"titreprincipal\">Commande de masse</div><br/>" );
    echo( "<form method=\"post\" action=\"traitement/modif_generale.php?choix=2&num_commande=$num_commande\">
        <div id=\"contenu\">
        <table>");
           
?>

<script type="text/javascript">
var i;

function get_xml()
{

    http = null;

    if(window.XMLHttpRequest)
    {

        http = new XMLHttpRequest();

    }

    else if(window.ActiveXObject)
    {

        try { http = new ActiveXObject("Msxml2.XMLHTTP"); } catch (e) { http = new ActiveXObject("Microsoft.XMLHTTP");}

    }

    else
    {

        alert('Votre Navigateur ne supporte pas Ajax !');

    }

    return http;

}

function supprimer(i)
{
    var reference = document.getElementById("ReferenceCM_pp"+i);
    var designation = document.getElementById("DesignationCM_pp"+i);
    var quantite = document.getElementById("QuantiteCM_pp"+i);
    var potentiel = document.getElementById("PotentielCM_pp"+i);
    var resteLivre = document.getElementById("ResteLivreCM_pp"+i);
    var num_commande=document.getElementById("numCommandeMasse");
    var http = get_xml();
     
    http.open("POST", "supprimerLigne.php", true);

    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send("num_commande="+num_commande.value+"&choix=1&reference="+reference.value+"&designation="+designation.value+"&quantite="+quantite.value+"&potentiel="+potentiel.value+"&resteLivre="+resteLivre.value);
    
    reference.value = "";
    reference.removeAttribute('readonly');
    
    designation.value = "";
    quantite.value = "";
    potentiel.value = "";
    resteLivre.value = "";
    
}

function supprimer1(i)
{
    var reference = document.getElementById("ReferenceCM_pe"+i);
    var designation = document.getElementById("DesignationCM_pe"+i);
    var quantite = document.getElementById("QuantiteCM_pe"+i);
    var resteLivre = document.getElementById("ResteLivreCM_pe"+i);
    var num_commande=document.getElementById("numCommandeMasse");
    var http = get_xml();

    http.open("POST", "supprimerLigne.php", true);

    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send("num_commande="+num_commande.value+"&choix=2&reference="+reference.value+"&designation="+designation.value+"&quantite="+quantite.value+"&resteLivre="+resteLivre.value);
    
    reference.value = "";
    reference.removeAttribute('readonly');
    
    designation.value = "";
    quantite.value = "";
    resteLivre.value = "";
    
}
</script>

<?php

    $sql = "SELECT * FROM COMMANDE WHERE no_commande='".$num_commande."';";
    $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while($data = mysql_fetch_assoc($req)){
                
	echo(   "<label id=\"titre\">Commande N&deg;</label><input readonly type=\"text\" name=\"numCommandeMasse\" id=\"numCommandeMasse\"  value=".$num_commande.">
			<label>Date</label><input readonly type=\"text\" name=\"jourCommandeMasse\" id=\"jourCommandeMasse\" value=".$data['date_commande'].">
			<label>&agrave;</label><input readonly type=\"text\" name=\"heureCommandeMasse\" id=\"heureCommandeMasse\" value=".$data['heure_commande']."><br /><br />
                
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
                            <th><p id="sous-titre">Ajouter</p></th>
                            <th><p id="sous-titre">R&eacute;f&eacute;rence</p> </th>
                            <th><p id="sous-titre">D&eacute;signation</p> </th>
                            <th><p id="sous-titre">Quantit&eacute;</p></th>
                            <th><p id="sous-titre">Potentiel/jour</p> </th>
                            <th><p id="sous-titre">Reste &agrave; livrer</p> </th>
	                    </tr>
	
	                    <tr>
                            <td>  </td>                         
                            <td>  </td>
                            <td id="type_piece">Pi&egrave;ces principales</td>
                            <td>  </td>
                            <td>  </td>
                            <td>  </td>
	                    </tr>
	<?php
$sql = "SELECT p.reference_piece, p.designation_piece, c.quantite_piece, ca.potentiel_jour FROM PIECE p, COMPREND c, COMMANDE co, CADENCEE ca 
        WHERE co.no_commande=c.no_commande AND p.reference_piece=c.reference_piece AND co.no_commande=ca.no_commande
        AND c.reference_piece=ca.reference_piece AND c.no_commande=ca.no_commande AND co.no_commande=".$num_commande." AND c.libelle_type_piece='pieces principales';";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$i=0;
while($data = mysql_fetch_assoc($req)){
//Dans un premier temps on va afficher les résultats si il s'existe. 
        
        $i++;
        
        $sql_quantite="SELECT SUM(quantite_livree) AS quantite FROM LIVRAISON WHERE reference_piece='".$data['reference_piece']."' 
                            AND no_commande='".$num_commande."';"; 
        $resultat_quantite= mysql_query($sql_quantite) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $data1=mysql_fetch_assoc($resultat_quantite);

        $reste=$data['quantite_piece']-$data1['quantite'];
        
	    echo "<tr>          <td><img src=\"traitement/supprimer.png\" alt=\"supprimer\" onClick=\"supprimer($i);\"
	    /></td>
                            <td><input readonly type=\"text\" name=\"ReferenceCM_pp$i\" id=\"ReferenceCM_pp$i\" value=\"".$data['reference_piece']."\"  onchange=\"verifierRef('ReferenceCM_pp$i')\"></td>
                            <td><input type=\"text\" name=\"DesignationCM_pp$i\" id=\"DesignationCM_pp$i\"  value=\"".$data['designation_piece']."\"></td>
                            <td><input  type=\"text\" name=\"QuantiteCM_pp$i\" id=\"QuantiteCM_pp$i\"   value=\"".$data['quantite_piece']."\" onkeyup=\"verifierQuant('QuantiteCM_pp$i')\" onchange=\"alertQuant('QuantiteCM_pp$i')\"></td>
                            <td><input type=\"text\" name=\"PotentielCM_pp$i\" id=\"PotentielCM_pp$i\"  value=\"".$data['potentiel_jour']."\"></td>
                            <td><input type=\"text\" name=\"ResteLivreCM_pp$i\" id=\"ResteLivreCM_pp$i\" value=\"".$reste."\"/> </td>
	          </tr>";
              
                    
              
       
	 }  
  //Puis a ce niveau on affiche une deuxième ligne cachée si l'utilisateur désire ajouter une pièce principale il appuie sur le bouton + et les champs seront visibles.   
     if($i==1)
     {
        
        echo "<tr>         <td> <input type = \"button\" name = \"+\" value=\"+\" id=\"+\" onclick=\"afficher();\" style=\"display:block;width:50px;\"  > </td>
                            <td><input type=\"text\" name=\"ReferenceCM_pp2\" style=\"display:none;\" id=\"ReferenceCM_pp2\" value=\"\" onchange=\"verifierRef('ReferenceCM_pp2')\" ></td>
                            <td><input type=\"text\" name=\"DesignationCM_pp2\" style=\"display:none;\" id=\"DesignationCM_pp2\"  value=\"\"></td>
                            <td><input type=\"text\" name=\"QuantiteCM_pp2\" style=\"display:none;\" id=\"QuantiteCM_pp2\"   value=\"\" onkeyup=\"verifierQuant('QuantiteCM_pp2')\" onchange=\"alertQuant('QuantiteCM_pp2')\" ></td>
                            <td><input type=\"text\" name=\"PotentielCM_pp2\" style=\"display:none;\" id=\"PotentielCM_pp2\"  value=\"\"></td>
                            <td><input type=\"text\" name=\"ResteLivreCM_pp2\" style=\"display:none;\" id=\"ResteLivreCM_pp2\" value=\"\"/> </td>
	          </tr>";
     
     }
 // Si il n'y a pas de pièces principales alors on affiche une ligne pour en ajouter une si l'utilisateur le désir avec un bouton + s'il désir ajouter 2 pièces principales d'un coup
 //sinon il laisse vide.
     if($i==0)
     {
        echo "<tr>         <td> </td>
				
                            <td><input type=\"text\" name=\"ReferenceCM_pp1\"  id=\"ReferenceCM_pp1\" value=\"\"onchange=\"verifierRef('ReferenceCM_pp1')\"></td>
                            <td><input type=\"text\" name=\"DesignationCM_pp1\" id=\"DesignationCM_pp1\"  value=\"\"></td>
                            <td><input type=\"text\" name=\"QuantiteCM_pp1\" id=\"QuantiteCM_pp1\"   value=\"\" onkeyup=\"verifierQuant('QuantiteCM_pp1')\" onchange=\"alertQuant('QuantiteCM_pp1')\"></td>
                            <td><input type=\"text\" name=\"PotentielCM_pp1\" id=\"PotentielCM_pp1\"  value=\"\"></td>
                            <td><input type=\"text\" name=\"ResteLivreCM_pp1\" id=\"ResteLivreCM_pp1\" value=\"\"/> </td>
	          </tr>";
     
        echo "<tr>         <td> <input type = \"button\" name = \"+\" value=\"+\" id=\"+\" onclick=\"afficher();\" style=\"display:block;width:50px;\"  > </td>
                            <td><input type=\"text\" name=\"ReferenceCM_pp2\" style=\"display:none;\" id=\"ReferenceCM_pp2\" value=\"\" onchange=\"verifierRef('ReferenceCM_pp2')\"></td>
                            <td><input type=\"text\" name=\"DesignationCM_pp2\" style=\"display:none;\" id=\"DesignationCM_pp2\"  value=\"\"></td>

                            <td><input type=\"text\" name=\"QuantiteCM_pp2\" style=\"display:none;\" id=\"QuantiteCM_pp2\"   value=\"\" onkeyup=\"verifierQuant('QuantiteCM_pp2')\" onchange=\"alertQuant('QuantiteCM_pp2')\"></td>
                            <td><input type=\"text\" name=\"PotentielCM_pp2\" style=\"display:none;\" id=\"PotentielCM_pp2\"  value=\"\"></td>
                            <td><input type=\"text\" name=\"ResteLivreCM_pp2\" style=\"display:none;\" id=\"ResteLivreCM_pp2\" value=\"\"/> </td>
	          </tr>";    
     
     }
    
     ?>
                  
	                    <tr>
                            <td>  </td>
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
	           echo "<tr> <td> <img src=\"traitement/supprimer.png\" alt=\"supprimer\" onClick=\"supprimer1($i1);\" /></td>
                            
                            <td><input readonly type=\"text\" name=\"ReferenceCM_pe$i1\" id=\"ReferenceCM_pe$i1\" value=\"".$data['reference_piece']."\" onchange=\"verifierRef('ReferenceCM_pe$i')\"></td>
                            <td><input type=\"text\" name=\"DesignationCM_pe$i1\" id=\"DesignationCM_pe$i1\"  value=\"".$data['designation_piece']."\"></td>
                            <td><input  type=\"text\" name=\"QuantiteCM_pe$i1\" id=\"QuantiteCM_pe$i1\"   value=\"".$data['quantite_piece']."\" onkeyup=\"verifierQuant('QuantiteCM_pe$i')\" onchange=\"alertQuant('QuantiteCM_pe$i')\"></td>
                            <td>  </td>
                            <td><input type=\"text\" name=\"ResteLivreCM_pe$i1\" id=\"ResteLivreCM_pe$i1\" value=\"".$reste1."\"/> </td>
	                    </tr>";
	  } 
 if($i1==2)
 {
               echo "<tr>  <td> <input type = \"button\" name = \"+\" value=\"+\" id=\"plus2\" onclick=\"afficher3();\" style=\"display:block;width:50px;\"  > </td>
                            
                            <td><input type=\"text\" name=\"ReferenceCM_pe3\" style=\"display:none;\" id=\"ReferenceCM_pe3\" value=\"\" onchange=\"verifierRef('ReferenceCM_pe3')\" ></td>
                            <td><input type=\"text\" name=\"DesignationCM_pe3\" style=\"display:none;\" id=\"DesignationCM_pe3\"  value=\"\"></td>
                            <td><input  type=\"text\" name=\"QuantiteCM_pe3\" style=\"display:none;\" id=\"QuantiteCM_pe3\"   value=\"\" onkeyup=\"verifierQuant('QuantiteCM_pe3')\" onchange=\"alertQuant('QuantiteCM_pe3')\"></td>
                            <td>  </td>
                            <td><input type=\"text\" name=\"ResteLivreCM_pe3\" style=\"display:none;\" id=\"ResteLivreCM_pe3\" value=\"\"/> </td>
	                    </tr>";
    
 }
 if($i1==1)
 {
               echo "<tr>  <td> <input type = \"button\" name = \"+\" value=\"+\" id=\"plus\" onclick=\"afficher2();\" style=\"display:block;width:50px;\"  > </td>
                            
                            <td><input  type=\"text\" name=\"ReferenceCM_pe2\" style=\"display:none;\" id=\"ReferenceCM_pe2\" value=\"\"onchange=\"verifierRef('ReferenceCM_pe2')\"></td>
                            <td><input type=\"text\" name=\"DesignationCM_pe2\" style=\"display:none;\" id=\"DesignationCM_pe2\"  value=\"\"></td>
                            <td><input  type=\"text\" name=\"QuantiteCM_pe2\" style=\"display:none;\" id=\"QuantiteCM_pe2\"   value=\"\" onkeyup=\"verifierQuant('QuantiteCM_pe2')\" onchange=\"alertQuant('QuantiteCM_pe2')\"></td>
                            <td>  </td>
                            <td><input type=\"text\" name=\"ResteLivreCM_pe2\" style=\"display:none;\" id=\"ResteLivreCM_pe2\" value=\"\"/> </td>
	                    </tr>";
              echo "<tr>  <td> <input type = \"button\" name = \"+\" value=\"+\" id=\"plus2\" onclick=\"afficher3();\" style=\"display:block;width:50px;\"  > </td>
                            
                            <td><input type=\"text\" name=\"ReferenceCM_pe3\" style=\"display:none;\" id=\"ReferenceCM_pe3\" value=\"\" onchange=\"verifierRef('ReferenceCM_pe3')\"></td>
                            <td><input type=\"text\" name=\"DesignationCM_pe3\" style=\"display:none;\" id=\"DesignationCM_pe3\"  value=\"\"></td>
                            <td><input  type=\"text\" name=\"QuantiteCM_pe3\" style=\"display:none;\" id=\"QuantiteCM_pe3\"   value=\"\"onkeyup=\"verifierQuant('QuantiteCM_pe3')\" onchange=\"alertQuant('QuantiteCM_pe3')\"></td>
                            <td>  </td>
                            <td><input type=\"text\" name=\"ResteLivreCM_pe3\" style=\"display:none;\" id=\"ResteLivreCM_pe3\" value=\"\"/> </td>
	                    </tr>";
                        
    
 }
 if($i1==0)
 { 
              echo "<tr> <td> </td>
                            
                            <td><input  type=\"text\" name=\"ReferenceCM_pe1\" id=\"ReferenceCM_pe1\" value=\"\"  onchange=\"verifierRef('ReferenceCM_pe1')\"></td>
                            <td><input type=\"text\" name=\"DesignationCM_pe$1\" id=\"DesignationCM_pe1\"  value=\"\"></td>
                            <td><input  type=\"text\" name=\"QuantiteCM_pe$1\" id=\"QuantiteCM_pe1\"   value=\"\" onkeyup=\"verifierQuant('QuantiteCM_pe1')\" onchange=\"alertQuant('QuantiteCM_pe1')\"></td>
                            <td>  </td>
                            <td><input type=\"text\" style=\"display:none;\" name=\"ResteLivreCM_pe$1\" id=\"ResteLivreCM_pe1\" value=\"\"/> </td>
	                    </tr>";
               echo "<tr>  <td> <input type = \"button\" name = \"+\" value=\"+\" id=\"plus\" onclick=\"afficher2();\" style=\"display:block;width:50px;\"  > </td>
                            
                            <td><input type=\"text\" name=\"ReferenceCM_pe2\" style=\"display:none;\" id=\"ReferenceCM_pe2\" value=\"\"  onchange=\"verifierRef('ReferenceCM_pe2')\" ></td>
                            <td><input type=\"text\" name=\"DesignationCM_pe2\" style=\"display:none;\" id=\"DesignationCM_pe2\"  value=\"\"></td>
                            <td><input  type=\"text\" name=\"QuantiteCM_pe2\" style=\"display:none;\" id=\"QuantiteCM_pe2\"   value=\"\" onkeyup=\"verifierQuant('QuantiteCM_pe2')\" onchange=\"alertQuant('QuantiteCM_pe2')\"></td>
                            <td>  </td>
                            <td><input type=\"text\" name=\"ResteLivreCM_pe2\" style=\"display:none;\" id=\"ResteLivreCM_pe2\" value=\"\"/> </td>
	                    </tr>";
              echo "<tr>  <td> <input type = \"button\" name = \"+\" value=\"+\" id=\"plus2\" onclick=\"afficher3();\" style=\"display:block;width:50px;\"  > </td>
                            
                            <td><input type=\"text\" name=\"ReferenceCM_pe3\" style=\"display:none;\" id=\"ReferenceCM_pe3\" value=\"\"  onchange=\"verifierRef('ReferenceCM_pe3')\"></td>
                            <td><input type=\"text\" name=\"DesignationCM_pe3\" style=\"display:none;\" id=\"DesignationCM_pe3\"  value=\"\"></td>
                            <td><input  type=\"text\" name=\"QuantiteCM_pe3\" style=\"display:none;\" id=\"QuantiteCM_pe3\"   value=\"\" onkeyup=\"verifierQuant('QuantiteCM_pe3')\" onchange=\"alertQuant('QuantiteCM_pe3')\"></td>
                            <td>  </td>
                            <td><input type=\"text\" name=\"ResteLivreCM_pe3\" style=\"display:none;\" id=\"ResteLivreCM_pe3\" value=\"\"/> </td>
	                    </tr>";
                        
    
 }
 
      
      
      ?>
	
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
                           
	                    </tr>
	
	
	                    <tr>
                            <th> <p>Entit&eacute;</p> </th>
                            <td>
                                <?php echo("<input readonly id=\"libelle_entite\" value=".$data['libelle_entite'].">"); ?>
                            </td>	
                            	
	                    </tr>
	
	                    <tr>
                            <th> <p>CA imput&eacute;</p> </th>
                            <td id="resultat">
                                <?php echo("<input readonly id=\"code_imputation\" value=".$data['code_imputation'].">"); ?>
                            </td>
	                    </tr>	 

	
            </table>
            
      <?php   }   ?>
        <input type="submit" id="val" action="" value="Modifier">
        <input type="reset" id="anu" value="Accueil" onclick="document.location.href='accueil.php';" /> 
        </div>	
        
    </form>
    <div id="resultat"></div>
  </body>
    
</html>
