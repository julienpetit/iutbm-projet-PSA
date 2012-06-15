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
header_html("Exportation des données", array(), array("accueil.js"));

?>
<fieldset id='fieldexp'>
	<legend>S&eacute;l&eacute;ction des Champs</legend>
	<form id='export' name='export' action='export_save.php' method='post'>
		<?php
		foreach($tables as $ligne){
			echo "<fieldset id=\"nomtable\"><legend>$ligne</legend>";
			$sql ="SELECT * FROM $ligne;";
			$resultat = mysql_query($sql);
			$i = 0;
			while ($row = mysql_num_fields($resultat)) {
// 				$meta = mysql_fetch_field($resultat, $i);
				$donnee = mysql_query("SELECT $meta->name FROM $ligne;");
				echo "<table id ='tablexp' border='0'>";
				echo "<tr><td class='chek'>";
				echo "<input type='checkbox'  id='synchrone' name='donnee[]' value='$meta->name'/>";
				echo "<label for='synchrone' id='export'>".$meta->name."</label>";
				echo "</td>";
				echo "</table>";
				while($row2=mysql_fetch_array($donnee)){
					print_r_html($row2);
				}
			}
			echo "</fieldset>";

		}
		?>

</fieldset>
<div id='sub'>
	<input type='submit' id='val' class='small green nice button radius'
		value='Exporter champs s&eacute;l&eacute;ctionn&eacute;e(s)' /> <a
		href='/' class='small blue nice button radius'>Accueil</a>
</div>
</form>
</body>
</html>
<?php footer_html(); ?>
