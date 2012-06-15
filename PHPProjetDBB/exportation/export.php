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
header_html("Exportation des données",array(), array("accueil.js")); 
?>
<fieldset id='fieldexp'><legend>S&eacute;l&eacute;ction des Tables</legend>
<form id='export' name='export' action='export_champs.php' method='post'>
<table id ='tablexp' border='0'> 
<tr><td class='chek'>
<input type='checkbox'  id='synchrone' name='tables[]' value='ADRESSE_MAIL'/></td><td class='lab'><label for='synchrone' id='export'>Adresses Emails</label></td><td class='chek'>

<input type='checkbox'  id='synchrone2' name='tables[]' value='APPROVISIONNE'/></td><td class='lab'><label for='synchrone2' id='export'>Approvisionne</label></td>
</tr>
<tr><td class='chek'>
<input type='checkbox'  id='synchrone3' name='tables[]' value='CADENCEE'/></td><td class='lab'><label for='synchrone3' id='export'>Cadenc&eacute;e</label></td><td class='chek'>

<input type='checkbox'  id='synchrone4' name='tables[]' value='COMMANDE'/></td><td class='lab'><label for='synchrone4' id='export'>Commande</label></td>
</tr>
<tr><td class='chek'>
<input type='checkbox'  id='synchrone5' name='tables[]' value='COMPREND'/></td><td class='lab'><label for='synchrone5' id='export'>Comprend</label></td><td class='chek'>

<input type='checkbox'  id='synchrone6' name='tables[]' value='COPIE_COMMANDE'/></td><td class='lab'><label for='synchrone6' id='export'>Copie Commande</label></td>
</tr>
<tr><td class='chek'>
<input type='checkbox'  id='synchrone7' name='tables[]' value='DEST_COMMANDE'/></td><td class='lab'><label for='synchrone7' id='export'>Destinataire Commande</label></td><td class='chek'>

<input type='checkbox'  id='synchrone8' name='tables[]' value='DROIT'/></td><td class='lab'><label for='synchrone8' id='export'>Droit</label></td>
</tr>
<tr><td class='chek'>
<input type='checkbox'  id='synchrone9' name='tables[]' value='ENTITE'/></td><td class='lab'><label for='synchrone9' id='export'>Entit&eacute;</label></td><td class='chek'>

<input type='checkbox'  id='synchrone10' name='tables[]' value='FOURNISSEUR'/></td><td class='lab'><label for='synchrone10' id='export'>Fournisseur</label></td>
</tr>
<tr><td class='chek'>
<input type='checkbox'  id='synchrone11' name='tables[]' value='INFORME'/></td><td class='lab'><label for='synchrone11' id='export'>Informe</label></td><td class='chek'>

<input type='checkbox'  id='synchrone12' name='tables[]' value='LIVRAISON'/></td><td class='lab'><label for='synchrone12' id='export'>Livraison</label></td>
</tr>
<tr><td class='chek'>
<input type='checkbox'  id='synchrone13' name='tables[]' value='MODE_REF_VEHICULE'/></td><td class='lab'><label for='synchrone13' id='export'>Mode Ref Vehicule</label></td><td class='chek'>

<input type='checkbox'  id='synchrone14' name='tables[]' value='PIECE'/></td><td class='lab'><label for='synchrone14' id='export'>Pi&egrave;ce</label></td>
</tr>
<tr><td class='chek'>
<input type='checkbox'  id='synchrone15' name='tables[]' value='POSSEDE' /></td><td class='lab'><label for='synchrone15' id='export'>Poss&egrave;de</label></td><td class='chek'>

<input type='checkbox'  id='synchrone16' name='tables[]' value='SILHOUETTE'/></td><td class='lab'><label for='synchrone16' id='export'>Silhouette</label></td>
</tr>
<tr><td class='chek'>
<input type='checkbox'  id='synchrone17' name='tables[]' value='TYPE_CHANTIER'/></td><td class='lab'><label for='synchrone17' id='export'>Type Chantier</label></td><td class='chek'>

<input type='checkbox'  id='synchrone18' name='tables[]' value='TYPE_COMMANDE'/></td><td class='lab'><label for='synchrone18' id='export'>Type Commande</label></td>
</tr>
<tr><td class='chek'>

<input type='checkbox'  id='synchrone19' name='tables[]' value='TYPE_PIECE'/></td><td class='lab'><label for='synchrone19' id='export'>Type Pi&egrave;ce</label></td><td class='chek'>

<input type='checkbox'  id='synchrone20' name='tables[]' value='TYPE_PIECE2'/></td><td class='lab'><label for='synchrone20' id='export'>Type Pi&egrave;ce2</label></td>
</tr>
<tr><td class='chek'>
<input type='checkbox'  id='synchrone21' name='tables[]' value='UTILISATEUR'/></td><td class='lab'><label for='synchrone21' id='export'>Utilisateur</label></td><td></td><td></td>
</table>

</fieldset>

<div id='sub'>
<input type='submit' id='val' class='small green nice button radius' value='Exporter tables s&eacute;l&eacute;ctionn&eacute;e(s)'/>
                
<input type='reset' id='anu' class='anul\ small blue nice button radius' value='Page D'acceuil' onclick='javascript:document.location.href='../commande/accueil.php''/>
</div>
</form>
</body>
</html>
<?php 
footer_html();
?>
