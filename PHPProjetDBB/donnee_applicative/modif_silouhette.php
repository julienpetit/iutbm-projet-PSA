<?php include('../connexion/_connexion.php');
mysql_query("SET NAMES UTF8");
//recuperation du numero de l'abonne dans l'url
$silouhette_select=$_POST['noSilouhette'];

//création de la requête SQL:
$sql="SELECT * FROM SILHOUETTE WHERE code_silhouette = '".$silouhette_select."'";
//exécution de notre requête SQL:
$result = mysql_query($sql);

			// AFFICHAGE DU TABLEAU:

while($row = mysql_fetch_array($result))
{
echo "<form id=\"myform\">


<label id=\"label\" for=\"code_silouhette\">Code Silouhette:</label>
<input readonly type=\"text\" name=\"code_silouhette\" id=\"code_silouhette\" value=\"".$row['code_silhouette']."\" /><br/>

<label id=\"label\" for=\"libelle_silouhette\">Libelle Silouhette</label>
<input type=\"text\" name=\"libelle_silouhette\" id=\"libelle_silouhette\" value=\"".$row['libelle_silhouette']."\" /><br/>



<button type=\"button\" id=\"but_mod\" onClick=\"Sauvegarde_silouhette()\">Sauvegarder</button>
<button type=\"button\" onClick=\"choix_table('silouhette')\" >Annuler</button>
</form>";
}
echo "</table>";
mysql_close();
?>
