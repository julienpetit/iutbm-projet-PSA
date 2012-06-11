<?php  

session_start(); 
include('../connexion/_connexion.php');
mysql_query("SET NAMES UTF8");
require_once("../fonctionhtml.php");  

html_entete_fichier("accueil","../Style.css","fonction.js","verifier.js"); 

?>
<body>

<form method="post" action="login.php" onsubmit="return Verifier_champs(tableau_champs)">
 
   <fieldset>
       <legend>Se connecter : </legend>

       <label for="login" Class= "Verif">Quel est votre identifiant ?</label>
	   <?php
	   if(isset($_GET['l'])) {
       echo"<input type=\"text\" name=\"login\" id=\"login\" value=\"".$_GET['l']."\"/>";
       
	   }
	   else {
	   echo"<input type=\"text\" name=\"login\" id=\"login\" />";
	   }
	   ?>
		<br/>
       <label for="password" Class="Verif">Quel est votre mot de passe ?</label>
       <input type="password" name="password" id="password"/>
       
 
<script type="text/javascript" >
	var tableau_champs = new Array(2); 
	tableau_champs[0]="login";
	tableau_champs[1]="password";
</script> 
 
		<input type="submit" value="Se connecter" >
	
   </fieldset>
   <script src="verifier.js" language="javascript" type="text/javascript"></script>
 </form>
 <?php
if(isset($_GET["err"]) && $_GET["err"] == "Login") {
	echo "<p class='error'>Login erroné.</p>";   
}
if(isset($_GET["err"]) && $_GET["err"] == "mdp") {
	echo "<p class='error'>Mot de passe erroné.</p>";   
}
?>
</body>
</html>
