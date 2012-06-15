<?php 
include('../connexion/_connexion.php'); 
mysql_query("SET NAMES UTF8");
?>

<br />
<div id="myform" class="myform_uti">
    <form id="formulaire"  name="form" method="post" action="">
        <h1>Formulaire d'ajout</h1>
        <p>Vous pouvez ajouter une silhouette</p>

		<br />	
		<label id="label" for="code_silouhette">Code silhouette</label>
		<input type="text" id="code_silouhette" value=""/>	
		<br/> 
		
		<label id="label" for="libelle_silouhette">Libelle silhouette</label>
		<input type="text" id="libelle_silouhette" value=""/>	
		<br/> 
		
		<button type="button" id="but_save"  onClick="ajout_silouhette()">Enregistrer</button>
		<button type="button" onClick="choix_table('silouhette')">Annuler</button>

	</form>
</div>
