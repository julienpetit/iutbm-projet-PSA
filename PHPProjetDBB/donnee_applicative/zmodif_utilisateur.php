<?php include('../connexion/_connexion.php');
mysql_query("SET NAMES UTF8");
//recuperation du numero de l'abonne dans l'url
$utilisateur_select=$_POST['noUtilisateur'];

//création de la requête SQL:
$sql="SELECT * FROM UTILISATEUR WHERE u.id_utilisateur = '".$utilisateur_select."'";

//exécution de notre requête SQL:
$result = mysql_query($sql);

			// AFFICHAGE DU TABLEAU:

while( $row = mysql_fetch_array($result) )
{
echo "<table border='0'>
<form >

<button type=\"submit\" id=\"but_mod\" onClick=\"Sauvegarde_utilisateur()\">Sauvegarder</button>
<button type=\"button\" onClick=\"choix_table('utilisateur')\" >Annuler</button>

<br /><br />

<tr>
<th>id utilisateur:</th>
<td><input type=\"hidden\" name=\"id_utilisateur\" id=\"id_utilisateur\" value=\"".$row['id_utilisateur']."\" /><p>".$row['id_utilisateur']."</p></td>
</tr>

<tr>
<th>nom utilisateur:</th>
<td><input type=\"text\" name=\"nom_utilisateur\" id=\"nom_utilisateur\" value=\"".$row['nom_utilisateur']."\" /></td>
</tr>

<tr>
<th>prenom utilisateur:</th>
<td><input type=\"text\" name=\"prenom_utilisateur\" id=\"prenom_utilisateur\" value=\"".$row['prenom_utilisateur']."\" /></td>
</tr>

<tr>
<th>service utilisateur:</th>
<td><input type=\"text\" name=\"service_utilisateur\" id=\"service_utilisateur\" value=\"".$row['service_utilisateur']."\" /></td>
</tr>

<tr>
<th>no Telephone:</th>
<td><input type=\"text\" name=\"no_telephone\" id=\"no_telephone\" value=\"".$row['no_telephone']."\" /></td>
</tr>

<tr>
<th>email:</th>
<td><input type=\"text\" name=\"email_utilisateur\" id=\"email_utilisateur\" value=\"".$row['email_utilisateur']."\" /></td>
</tr>

<tr>
<th>mdp:</th>
<td><input type=\"text\" name=\"mdp_utilisateur\" id=\"mdp_utilisateur\" value='' /></td>
</tr>
";/*
<tr>
<th>Droit:</th>
<td>";

$query="SELECT * FROM DROIT;";
$query2="SELECT d.no_droit FROM DROIT d, POSSEDE p WHERE p.id_utilisateur = '".$row['id_utilisateur']."' AND d.no_droit = p.no_droit";

$reponse=mysql_query($query);

						
			while ( $line =  mysql_fetch_array($reponse) ) {
			
			$reponse2=mysql_query($query2);
			
				while ( $line2 = mysql_fetch_array($reponse2) ){
			
					if ($line[0] == $line2[0]){
					print("<input type='checkbox' checked='checked' name='droit' id='".$line[0]."' value='".$line[0]."'/>".$line[1]."<br>");
					}
					
					else
					{  
						// Récupère la ligne suivante d'un jeu de résultats 
						print("<input type='checkbox' name='droit' id='".$line[0]."' value='".$line[0]."'/>".$line[1]."<br>");
					}
				}
			}
echo"

</td>
</tr>
*/";

</form>";
}
echo "</table>";
mysql_close();
?>