<?php 
session_start();
include_once('../connexion/_connexion.php');
include_once('../include/layout/layout.inc.php');
include_once('../include/library/library.inc.php');
include_once('../include/library/bd.inc.php');
include_once('../include/classes/commande.class.php');

require_once("../fonctionhtml.php");  

header_html("Liste des commandes", array("style.css"), array("script.js", "../controle/controle.js", "../include/js/development-bundle/jquery.dataTables.min.js"));

mysql_query("SET NAMES UTF8");
?>
<div id="content_liste">
   <br/>
	<input type="reset" id="anu" value="Accueil" class='small green nice button radius' onclick="document.location.href='../commande/accueil.php';" /> 
    <br/>
    <br/>
   	<div id="table_liste">
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
		<br/>     
		</div>  	
	</div>
<?php footer_html();?>
