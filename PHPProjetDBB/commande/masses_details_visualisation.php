<?php   session_start();        include('../connexion/_connexion.php');

require_once("../fonctionhtml.php");  
mysql_query("SET NAMES UTF8");
html_entete_fichier("accueil","../Style.css","fonction.js"); 

	echo("<body>");
    
    $num_commande=$_GET['num_commande'];

    echo("<div id=\"titreprincipal\">Détails de commande de masse</div><br/>" );
    
    echo("<form method=\"post\" action=\"accueil.php\">
            <div id=\"contenu\">
            <table border=\"0\">");
           

            $sql = "SELECT * FROM COMMANDE WHERE no_commande='".$num_commande."';";
            $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            while($data = mysql_fetch_assoc($req))
                {
                
	        echo("<label id=\"titre\">Commande N&deg;</label><input readonly type=\"text\" name=\"numCommandeMasse\" id=\"numCommandeMasse\"  value=".$num_commande.">
			      <label>Date</label><input readonly type=\"text\" name=\"jourCommandeMasse\" id=\"jourCommandeMasse\" value=".$data['date_commande'].">
			      <label>&agrave;</label><input readonly type=\"text\" name=\"heureCommandeMasse\" id=\"heureCommandeMasse\" value=".$data['heure_commande'].">");
                }
                ?>
   
        <br /><br />
            <table>
                <caption id="titre2"> Pièces principales </caption>
                <tr>
                    <th><p id="sous-titre" style="margin-right:60px;">Références</p></th>
                    <th><p id="sous-titre" style="margin-right:280px;">Désignation</p></th>
                    <th><p id="sous-titre">Quantité</p></th>
                    <th><p id="sous-titre">Potentiel/J</p></th>
                    <th><p id="sous-titre">Reste à livrer</p></th>
                </tr>
            </table>    
           <?php   
           
        $i1=0;       
        $sql = "SELECT p.reference_piece, p.designation_piece,ca.potentiel_jour, co.quantite_piece FROM COMMANDE c, PIECE p, CADENCEE ca, COMPREND co 
                WHERE co.no_commande=c.no_commande AND co.reference_piece=p.reference_piece AND ca.reference_piece=co.reference_piece AND c.no_commande=ca.no_commande 
                AND c.no_commande='".$num_commande."' AND co.libelle_type_piece=\"pieces principales\";";
        $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        while($data = mysql_fetch_assoc($req))
            {
             $i1++;   
             
             $sql_quantite="SELECT SUM(quantite_livree) AS quantite FROM LIVRAISON WHERE reference_piece='".$data['reference_piece']."' 
                            AND no_commande='".$num_commande."';"; 
            $resultat_quantite= mysql_query($sql_quantite) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            while($data1 = mysql_fetch_assoc($resultat_quantite))
                {
                    $reste=$data['quantite_piece']-$data1['quantite'];
	                echo("<table><tr>
                            <td><input type=\"text\" name=\"reference_principale_$i1\" value=\"".$data['reference_piece']."\" disabled /></td>
                            <td><input type=\"text\" name=\"designation_principale_$i1\" id=\"designation_p\" disabled value=\"".$data['designation_piece']."\" </td>
                            <td><input type=\"text\" name=\"quantite_livree_principale_$i1\" id=\"quantite_p\" value=\"".$data['quantite_piece']."\" disabled </td>
                            <td><input type=\"text\" name=\"potentiel_jour_principale_$i1\" id=\"potentiel_p\" value=\"".$data['potentiel_jour']."\" disabled </td>");
                            if($data['quantite_piece']>$data1['quantite'])
				{
					echo("<td><input type=\"text\" name=\"reste_principale_$i1\" disabled id=\"reste\" style=\"background-color:Green;\" value='".$reste."'/></td>");
				}
			    else if($data['quantite_piece']<$data1['quantite'])
				{
					echo("<td><input type=\"text\" name=\"reste_principale_$i1\" disabled id=\"reste\" style=\"background-color:Red;\" value='".$reste."'/></td>");
				}
			    else
                                {
					echo("<td><input type=\"text\" name=\"reste_principale_$i1\" disabled id=\"reste\" style=\"background-color:Blue;\" value='".$reste."'/></td>");

                                }
                        
				echo("</tr></table>");
                }        
     
                
       echo("<table><tr><td>Livraison<br />Date/quantité</td>");
                    $i2=0;       
                    $sql1 = "SELECT * FROM LIVRAISON WHERE no_commande='".$num_commande."' AND reference_piece='".$data['reference_piece']."';";
                    $req1 = mysql_query($sql1) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                    while($data1 = mysql_fetch_assoc($req1))
                    {    
                             $i2++;
                            echo("<td><input readonly type=\"text\" name=\"livraison_principale_$i1-$i2\" id=\"livraison\" value=\"".$data1['date_livraison']."\">
                            <input readonly type=\"text\" name=\"quantite_principale_$i1-$i2\" id=\"quantite\" value=".$data1['quantite_livree']."></td>");
                   
                            if($i2==5)
                            {
                                echo("</tr><tr><td></td>");
                            }
                           
                    } 
            echo("</tr></table> ");
        echo("<td><input readonly type=\"hidden\" name=\"choix_case_remplir_principale_$i1\" value=".$i2.">");
        echo("<td><input readonly type=\"hidden\" name=\"choix_case_reference_principale_$i1\" value=".$i1.">");
        }
         
  ?>
<br />

        <table>
                <caption id="titre2"> Pièces d'environnement </caption>
                          
           <?php   
           
        $j1=0;       
        $sql = "SELECT p.reference_piece, p.designation_piece,co.quantite_piece FROM COMMANDE c, PIECE p, COMPREND co 
                WHERE co.no_commande=c.no_commande AND co.reference_piece=p.reference_piece AND c.no_commande='".$num_commande."' AND co.libelle_type_piece=\"pieces environnement\";";
        $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        while($data = mysql_fetch_assoc($req))
            {
                 $j1++;
                 
                 $sql_quantite="SELECT SUM(quantite_livree) AS quantite FROM LIVRAISON WHERE reference_piece='".$data['reference_piece']."' 
                                AND no_commande='".$num_commande."';"; 
                 $resultat_quantite= mysql_query($sql_quantite) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                 while($data1 = mysql_fetch_assoc($resultat_quantite))
                    {
                        $reste1=$data['quantite_piece']-$data1['quantite'];
	                    echo( "<tr>
                                  <td><input type=\"text\" name=\"reference_environnement_$j1\" value=\"".$data['reference_piece']."\" disabled /></td>
                                  <td><input type=\"text\" name=\"designation_environnement_$j1\" id=\"designation_e\" disabled value=\"".$data['designation_piece']."\" /></td>
                                  <td><input type=\"text\" name=\"quantite_livree_environnement_$j1\" id=\"quantite_e\" value=\"".$data['quantite_piece']."\" disabled /></td>
                                  <td></td>");
                                  if($data['quantite_piece']>$data1['quantite'])
				{
					echo("<td><input type=\"text\" name=\"reste_environnement_$j1\" disabled id=\"reste\" style=\"background-color:Green;\" value='".$reste1."'/></td>");
				}
			    else if($data['quantite_piece']<$data1['quantite'])
				{
					echo("<td><input type=\"text\" name=\"reste_environnement_$j1\" disabled id=\"reste\" style=\"background-color:Red;\" value='".$reste1."'/></td>");
				}
			    else
                                {
					echo("<td><input type=\"text\" name=\"reste_environnement_$j1\" disabled id=\"reste\" style=\"background-color:Blue;\" value='".$reste1."'/></td>");

                                }
                        
				echo("</tr></table>");
                    }    
    
                echo(" <table><tr><td>Livraison<br />Date/quantité</td>");
                $j2=0;       
                $sql1 = "SELECT * FROM LIVRAISON WHERE no_commande='".$num_commande."' AND reference_piece='".$data['reference_piece']."';";
                $req1 = mysql_query($sql1) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                while($data1 = mysql_fetch_assoc($req1))
                    {    
                        $j2++;
                        echo("<td><input readonly type=\"text\" name=\"livraison_environnement_$j1-$j2\" id=\livraison\" value=\"".$data1['date_livraison']."\">
                        <input readonly type=\"text\" name=\"quantite_environnement_$j1-$j2\" id=\"quantite\" value=".$data1['quantite_livree']."></td>");
                   
                        if($j2==5)
                            {
                                echo("</tr><tr><td></td>");
                            }
                    
                    } 
                   
          echo("</tr></table> ");
          
            echo("<td><input type=\"hidden\" name=\"choix_case_remplir_environnement_$j1\" value=".$j2.">");
         echo("<td><input type=\"hidden\" name=\"choix_case_reference_environnement_$j1\" value=".$j1.">");
        }
         
  ?>
            </table><br />
		<input type="submit" id="anu" value="Retour accueil" />
		<?php
		echo "<a href=\"./commande_de_masse_visualisation.php?num_commande=".$num_commande."&choix=4\">Retour commande</a>"
      ?>
            </div>
            
        </form>
    </body>
</html>
