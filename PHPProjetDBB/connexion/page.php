<?php  
session_start(); 
include_once('../connexion/_connexion.php');
include_once('../include/layout/layout.inc.php');
include_once('../include/library/library.inc.php');

require_once("../fonctionhtml.php");  
require_once("../connexion/verification_connexion.php");

mysql_query("SET NAMES UTF8");
header_html("Connexion",array("", "../include/css/global.css", "../include/framework/foundation.css"),array("fonction.js","verifier.js"), true); 
?>
<style>
	.error {
		color: red;
		text-align: center;
		font-size: 22px;
	}
</style>
<div id="content_connexion">
	<form action="login.php" method="post" onsubmit="Verifier_champs(tableau_champs)">
<?php
if(isset($_GET["err"]) && $_GET["err"] == "Login") {
	echo "<p class='error'>Login erroné.</p>";
}
if(isset($_GET["err"]) && $_GET["err"] == "mdp") {
	echo "<p class='error'>Mot de passe erroné.</p>";
}
?>
		<div class="formField">
			<input type="text" name="login" class='verif' id="login" placeholder="Identifiant">
			<img id="user-icon" src="/include/css/img/username.png" alt="username">			
						
		</div>

		<div class="formField">
			<input type="password" name="password" class='verif' id="password" placeholder="Mot de passe">		
			<img id="password-icon" src="/include/css/img/password.png" alt="password">				
		</div>
		<div>
			<input type="hidden" name="action" value="connexion">	
			<input type="submit" class='big blue nice button radius' value="Connexion">				
		</div>

	</form>
</div>

<script type="text/javascript">
	var tableau_champs = new Array(2); 
	tableau_champs[0]="login";
	tableau_champs[1]="password";
</script>


<?php footer_html(); ?>
