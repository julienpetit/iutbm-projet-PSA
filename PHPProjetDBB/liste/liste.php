<?php 
 
include('../connexion/_connexion.php');


require_once("../fonctionhtml.php");  

html_entete_fichier("accueil","../Style.css","script.js","../controle/controle.js");

mysql_query("SET NAMES UTF8");
echo("<body>");


?>
<input type="reset" id="anu" value="Accueil" onclick="document.location.href='../commande/accueil.php';" /> 
    
   <div id="content">
   		<div id="table">
		<table id="tableau_liste">
		<thead>
			<tr>
				<th><label>Numéro commande</label></th>
				<th><label>Date commande</label></th>
				<th><label>Fournisseur commande</label></th>
				<th><label>Type commande</label></th>
				<th><label>Date réception commande</label></th>
				<th><label>Identifiant demandeur commande</label></th>
				<th><label>Motif fermeture</label></th>
			</tr>
		</thead>	
		<?php


$sql= "SELECT * FROM COMMANDE";
$query = mysql_query($sql);

	echo"<tbody>";
	
while($row = mysql_fetch_array($query)){
	
	echo("
			
			<tr>
				<th>".$row['no_commande']."</th>
				<th>".$row['date_commande']."</th>
				<th>".$row['id_fournisseur']."</th>
				<th>".$row['code_type_commande']."</th>
				<th>".$row['date_fermeture']."</th>
				<th>".$row['id_utilisateur_passe']."</th>
				<th>".$row['motif_fermeture']."</th>
			</tr>
	");
}
	?>
		</tbody>
		</table>        
		</div>  	
	</div>
    <?php mysql_close(); // deconnexion de la base ?>
	</body>
</html>
