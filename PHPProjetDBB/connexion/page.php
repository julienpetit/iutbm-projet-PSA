<?php  

session_start(); 
include('../connexion/_connexion.php');
mysql_query("SET NAMES UTF8");
require_once("../fonctionhtml.php");  

html_entete_fichier("accueil","../Style.css","fonction.js"); 

echo("<body>");
?>
<form method="post" action="login.php">
 
   <fieldset>
       <legend>Se connecter : </legend>

       <label for="login">Quel est votre identifiant ?</label>
	   <?php
	   if(isset($_GET['l'])) {
       echo"<input type=\"text\" name=\"login\" id=\"login\" value=\"".$_GET['l']."\"/>";
	   }
	   else {
	   echo"<input type=\"text\" name=\"login\" id=\"login\" />";
	   }
	   ?>
		<br/>
       <label for="password">Quel est votre mot de passe ?</label>
       <input type="password" name="password" id="password"/>
 
		<input type="submit" value="Se connecter"/>
	
   </fieldset>
   
 </form>
</body>
</html>
