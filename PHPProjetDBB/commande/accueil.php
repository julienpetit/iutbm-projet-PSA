<?php  
//include_once("../connexion/login.php");
session_start();
include('../connexion/_connexion.php');
mysql_query("SET NAMES UTF8");
require_once("../fonctionhtml.php");
require_once("../connexion/verification_connexion.php");
require_once("./nocommande.php");

require_once("../include/library/bd.inc.php");
require_once("../include/library/library.inc.php");
require_once("../include/layout/layout.inc.php");


check_log_user(1,NULL);

$droit=$_SESSION['no_droit'];
//html_entete_fichier("accueil","../Style.css","accueil.js");
header_html("Gestion des commandes",array("../Style.css", "../include/css/global.css", "../include/framework/foundation.css"),array("accueil.js"));
echo("<body>");

echo("<form id=\"accueil\" name=\"accueil\" action=\"\" method=\"post\">");

echo("<fieldset><legend>Options</legend>");

if(in_array(1, $droit)) // permet de vérifier si l'utilisateur a le droit ou pas d'accèder a l'option $droit étant un tableau de droit.
{
	echo("<input type=\"radio\"  id=\"synchrone\" name=\"option\" value=\"synchrone\" onclick=\"nobox();choix_action1();\"/><label for=\"synchrone\" id=\"synchrone\">Passer une commande de pi&egrave;ces en flux synchrone</label>
			<br/>");
}
else
{
	echo("<input type=\"radio\"  id=\"synchrone\" name=\"option\" value=\"synchrone\" onclick=\"nobox();choix_action1();\" style=\"display:none;\" /><label for=\"synchrone\" style=\"display:none;\" >Passer une commande de pi&egrave;ces en flux synchrone</label>");
}

if(in_array(2, $droit))
{
	echo("<input type=\"radio\"  id=\"masse\" name=\"option\" value=\"masse\"  onclick=\"nobox();choix_action1()\"/><label for=\"masse\">Passer une commande de masse</label>
			<br/>");
}
else
{
	echo("<input type=\"radio\"  id=\"masse\" name=\"option\" value=\"masse\" style=\"display:none;\" onclick=\"nobox();choix_action1()\" /><label for=\"masse\" style=\"display:none;\">Passer une commande de masse</label>");
}
 
echo("<input type=\"radio\"  id=\"visualiser\" name=\"option\" value=\"visualiser\"  onclick=\"box();choix_action1();\"/><label for=\"visualiser\">Visualiser une commande</label>
		<br/>");

if(in_array(2, $droit))
{
	echo("<input type=\"radio\"  id=\"modifier\" name=\"option\" value=\"modifier\" onclick=\"box();choix_action1();\"/><label for=\"modifier\">Modifier une commande</label>
			<br/>");
}
else
{
	echo("<input type=\"radio\"  id=\"modifier\" name=\"option\" value=\"modifier\" onclick=\"box();choix_action1();\" style=\"display:none;\" /><label for=\"modifier\" style=\"display:none;\">Modifier une commande</label>");
}

if(in_array(3, $droit) or in_array(4, $droit))
{
	echo("<input type=\"radio\"  id=\"annuler\" name=\"option\" value=\"annuler\"  onclick=\"box();choix_action1();\"/><label for=\"annuler\">Annuler une commande</label>
			<br/>");
}
else
{
	echo("<input type=\"radio\"  id=\"annuler\" name=\"option\" value=\"annuler\" style=\"display:none;\" onclick=\"box();choix_action1();\" /><label for=\"annuler\"style=\"display:none;\">Annuler une commande</label>");
}
 
if(in_array(5, $droit))
{
	echo("<input type=\"radio\"  id=\"receptionner\" name=\"option\" value=\"receptionner\" onclick=\"box();choix_action1();\"/><label for=\"receptionner\">D&eacute;clarer la r&eacute;ception d'une commande de pi&egrave;ce synchrone</label>
			<br/>");
}
else
{
	echo("<input type=\"radio\"  id=\"receptionner\" name=\"option\" value=\"receptionner\" onclick=\"box();choix_action1();\" style=\"display:none;\"/><label for=\"receptionner\" style=\"display:none;\">D&eacute;clarer la r&eacute;ception d'une commande de pi&egrave;ce synchrone</label>");
}
 
if(in_array(6 , $droit))
{
	echo("<input type=\"radio\"  id=\"declarer\" name=\"option\" value=\"declarer\" onclick=\"box();choix_action1();\"/><label for=\"declarer\">D&eacute;clarer des livraisons de pi&egrave;ces</label>
			<br/>");
}
else
{
	echo("<input type=\"radio\"  id=\"declarer\" name=\"option\" value=\"declarer\" onclick=\"box();choix_action1();\" style=\"display:none;\" /><label for=\"declarer\" style=\"display:none;\">D&eacute;clarer des livraisons de pi&egrave;ces</label>");
}
 
if(in_array(7, $droit))
{
	echo("<input type=\"radio\"  id=\"fermer\" name=\"option\" value=\"fermer\" onclick=\"box();choix_action1();\" /><label for=\"fermer\">Fermer une commande</label>
			<br/>");
}
else
{
	echo("<input type=\"radio\"  id=\"fermer\" name=\"option\" value=\"fermer\" onclick=\"box();choix_action1();\" style=\"display:none;\" /><label for=\"fermer\" style=\"display:none;\">Fermer une commande</label>");
}
 
echo("<input type=\"radio\"  id=\"lister\" name=\"option\" value=\"lister\" onclick=\"nobox();choix_action1();\"/><label for=\"lister\">Lister des commandes</label><br />");


if(in_array(8, $droit))
{
	echo("<input type=\"radio\"  id=\"extraire\" name=\"option\" value=\"extraire\"  onclick=\"nobox();choix_action1();\"/><label for=\"extraire\">Extraire des données</label>
			<br/>");
}
else
{
	echo("<input type=\"radio\"  id=\"extraire\" name=\"option\" value=\"extraire\" style=\"display:none;\" onclick=\"nobox();choix_action1();\" /><label for=\"extraire\" style=\"display:none;\" >Extraire des données</label>");
}

if(in_array(9, $droit) or in_array(10, $droit))
{
	echo("<input type=\"radio\"  id=\"maj\" name=\"option\" value=\"maj\" onclick=\"nobox();choixaction1();\" /><label for=\"maj\">Mise &agrave jour des donn&eacute;es applivatives</label>");
}
else
{
	echo("<input type=\"radio\"  id=\"maj\" name=\"option\" value=\"maj\" style=\"display:none;\" onclick=\"nobox();choixaction1();\" /><label for=\"maj\" style=\"display:none;\">Mise &agrave jour des donn&eacute;es applivatives</label>");
}


echo("</fieldset>

		<div id=\"commande\" style=\"display:none;\">
		<label>N°Commande concernée? </label><input type='text' id='num_commande' value=''/>
		</div>
		<div id=\"sub\">
		<input type=\"submit\" class=\"small blue nice button radius\"onclick=\"choix_action1(num_commande.value);\" value=\"Valider la demande\"/>
		</div>
		</form>
		<a href='../connexion/deconnexion.php' class=\"small green nice button radius\" >Quitter l'application</a>

		");
?>
</body>
</html>
