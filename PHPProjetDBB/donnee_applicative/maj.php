<?php 
session_start(); 
include('../connexion/_connexion.php');

require_once("../fonctionhtml.php");  
require_once("../connexion/verification_connexion.php");

require_once("../include/library/bd.inc.php");
require_once("../include/library/library.inc.php");
require_once("../include/layout/layout.inc.php");

header_html("Affichage des tables",array("../Style.css", "../include/css/global.css", "../include/framework/foundation.css"),array("script.js"));

// html_entete_fichier("accueil","../Style.css","script.js");
mysql_query("SET NAMES UTF8");
check_log_user(12,NULL);

echo("<body>");
?>
	<div id="page">
		<form>
			<fieldset>
				<label> Table à sélectionner </label>
				<select name="table" onchange="choix_table(this.value)">
					<option select="selected">Sélectionner table</option>
					<option value="fournisseur">Fournisseur</option>
					<option value="piece">Pièce</option>
					<option value="silouhette">Silhouette</option>
					<option value="utilisateur">Utilisateur</option>
				</select>
			</fieldset>
		</form>
	</div>	
	<br/>	
	<div><a href='/' class='small green nice button radius' >Accueil</a></div>
	<div id="page1"></div>	
   </body>
</html>
<?php footer_html(); ?>