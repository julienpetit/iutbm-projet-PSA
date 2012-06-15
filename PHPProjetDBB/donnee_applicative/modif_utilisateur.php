<?php session_start();

include('../connexion/_connexion.php');
mysql_query("SET NAMES UTF8");
//recuperation du numero de l'abonne dans l'url
$utilisateur_select=$_POST['noUtilisateur'];
$droit=$_SESSION['no_droit'];
//création de la requête SQL:
$sql="SELECT * FROM UTILISATEUR WHERE id_utilisateur = '".$utilisateur_select."'";

//exécution de notre requête SQL:
$result = mysql_query($sql);

			// AFFICHAGE DU TABLEAU:

while( $row = mysql_fetch_array($result) )
{
echo "
<form id=\"myform\">
<br /><br />


<label id=\"label\" for=\"id_utilisateur\">Identifiant Utilisateur:</label>
<input type=\"text\" disabled='disabled' name=\"id_utilisateur\" id=\"id_utilisateur\" value=\"".$row['id_utilisateur']."\" /><br/>

<label id=\"label\" for=\"nom_utilisateur\">Nom Utilisateur:</label>
<input type=\"text\" name=\"nom_utilisateur\" id=\"nom_utilisateur\" value=\"".$row['nom_utilisateur']."\" /><br/>

<label id=\"label\" for=\"prenom_utilisateur\">Prenom Utilisateur:</label>
<input type=\"text\" name=\"prenom_utilisateur\" id=\"prenom_utilisateur\" value=\"".$row['prenom_utilisateur']."\" /><br/>

<label id=\"label\" for=\"service_utilisateur\">Service Utilisateur:</label>
<input type=\"text\" name=\"service_utilisateur\" id=\"service_utilisateur\" value=\"".$row['service_utilisateur']."\" /><br/>

<label id=\"label\" for=\"no_telephone\">Numéro Telephone:</label>
<input type=\"text\" name=\"no_telephone\" id=\"no_telephone\" value=\"".$row['no_telephone']."\" /><br/>

<label id=\"label\" for=\"email_utilisateur\">Email:</label>
<input type=\"text\" name=\"email_utilisateur\" id=\"email_utilisateur\" value=\"".$row['email_utilisateur']."\" onchange='isEmail()'/><br/>

<label id=\"label\" for=\"mdp_utilisateur\">Mot de Passe:</label>
<input type=\"password\" name=\"mdp_utilisateur\" id=\"mdp_utilisateur\" value='' onchange='verif_mdp(this.value)'/><br/>

<div id='verif_mdp_utilisateur_modif'>
<label id='label' id='label_verif_mdp_utilisateur' for='verif_mdp_utilisateur'>Verification Mot de Passe:</label>
<input type=\"password\" name=\"verif_mdp_utilisateur_modif\" id=\"verif_mdp_utilisateur\" value=''/><br/>
</div>

<label id=\"label_droit_lab\">Droit</label>
<table id=\"label_droit\">
<tr>
";

$query="SELECT * FROM DROIT;";
$query2="SELECT d.no_droit, d.description_droit FROM DROIT d, POSSEDE p WHERE p.id_utilisateur = '".$row['id_utilisateur']."' AND d.no_droit = p.no_droit";

$reponse=mysql_query($query);
$reponse2=mysql_query($query2);

$line2 = mysql_fetch_array($reponse2);
$i=1;
		
			while ( $line =  mysql_fetch_array($reponse) ) {
					if (($i%2)!=0){
						echo("</tr><tr>");
					}
												
					if ($line['no_droit'] == $line2[0])
					{
						
							if(in_array(10,$droit))
							{
					     print("<td><input type='checkbox' checked='checked' name='droit' id='".$line2[0]."' value='".$line2[0]."'/></td><td><label id =\"formaj\" for=\"".$line[0]."\">".$line2[1]."</label></td>");
						  $line2 = mysql_fetch_row($reponse2);
					     }
					     else{
					     	
					     	print("<td><input disabled type='checkbox' checked='checked' name='droit' id='".$line2[0]."' value='".$line2[0]."'/></td><td><label id =\"formaj\" for=\"".$line[0]."\">".$line2[1]."</label></td>");
						  $line2 = mysql_fetch_row($reponse2);
					     	
					     	}
					}
									
									
					else
					{
						if(in_array(10,$droit))
							{
                    print("<td><input type='checkbox' name='droit' id='".$line['no_droit']."' value='".$line['no_droit']."'/></td><td><label id =\"formaj\" for=\"".$line['no_droit']."\">".$line['description_droit']."</label></td>");
			           }
			      else{
			      	print("<td><input disabled type='checkbox' name='droit' id='".$line['no_droit']."' value='".$line['no_droit']."'/></td><td><label id =\"formaj\" for=\"".$line['no_droit']."\">".$line['description_droit']."</label></td>");
			      	
			      	}
			      
			      }
					$i++;		
					

}			
echo"

</tr>
</table>
<button type=\"button\" id=\"but_mod\" onClick=\"Sauvegarde_utilisateur()\">Sauvegarder</button>
<button type=\"button\" onClick=\"choix_table('utilisateur')\" >Annuler</button>
</form>
";
}
echo "</table>";
mysql_close();
?>
