<?php

session_start();
include_once('../connexion/_connexion.php');
require_once("../fonctionhtml.php");
require_once("../connexion/verification_connexion.php");
check_log_user(9,NULL);

include_once "../include/library/library.inc.php";
include_once "../include/layout/layout.inc.php";

mysql_query("SET NAMES UTF8");
require_once("../fonctionhtml.php");
require_once("../connexion/verification_connexion.php");


mysql_query("SET NAMES UTF8");
$droit=$_SESSION['no_droit'];
$tables=$_POST['tables'];
html_entete_fichier("accueil","../Style.css","accueil.js");
echo("<h1 id=\"titreprincipal\">Exportation de champs</h1>
		<fieldset id=\"fieldexp\"><legend>S&eacute;l&eacute;ction des Champs</legend>");
echo("<form id=\"export\" name=\"export\" action=\"export_save.php\" method=\"post\">");

foreach($tables as $ligne){
	try {
		echo "<fieldset id=\"nomtable\"><legend>$ligne</legend>"; 
		$sql ="SELECT * FROM $ligne;";
		$resultat = mysql_query($sql);
		$i = 0;
		while ($i < mysql_num_fields($resultat)) {
			$meta = mysql_fetch_field($resultat, $i);
			echo "<table id =\"tablexp\" border=\"0\">"; 
			echo "<tr><td class=\"chek\">";
 			echo "<input type=\"checkbox\"  id=\"synchrone\" name=\"champs[]\" value=\"$meta->name\"/>";
 			echo "<label for=\"synchrone\" id=\"export\">".$meta->name."</label>";
 			echo "</td>";
 			echo "</table>";
			$i++;
		}
		echo "</fieldset>";
		}
	catch(PDOException $e){
	}
}
echo("</fieldset>
		<div id=\"sub\">
		<input type=\"submit\" id=\"val\" value=\"Exporter champs s&eacute;l&eacute;ctionn&eacute;e(s)\"/>

		<input type=\"reset\" id=\"anu\" class=\"anul\" value=\"Page D'acceuil\" onclick=\"javascript:document.location.href='../commande/accueil.php'\"/>
		</div>
		</form>
		</body>
		</html>");


?>