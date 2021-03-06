<?php  
session_start(); 
include_once('../connexion/_connexion.php');
include_once('../include/layout/layout.inc.php');
include_once('../include/library/library.inc.php');

require_once("../fonctionhtml.php");  
require_once("../connexion/verification_connexion.php");
require_once("./nocommande.php");
check_log_user(1,NULL);
header_html("Commande unitaire de pièces synchrones",array("commandeMVC/web/style.css", "../include/css/global.css", "../include/framework/foundation.css"),array("fonction.js","../controle/controle.js")); 
mysql_query("SET NAMES UTF8");

echo("<body>");
?>
<form id="formulaire" method="post" action="send_mail_four_synch.php">
<div id="contenu">
<?php
	$date = date("d/m/Y");
	$heure = date("h:i:s");
	$numCommande = noCommande();
        $droit=$_SESSION['no_droit'];
        echo("<fieldset>");
        echo("<legend>RECAPITULATIF </legend>");
	echo(   "<br />
			<label id=\"titre\">Commande N&deg;</label><input readonly disabled=\"disabled\" type=\"text\" name=\"numCommandeMasse\" id=\"numCommandeMasse\"  value=\"$numCommande\" />
			<label>effectu&eacute;e le</label><input readonly disabled=\"disabled\" type=\"text\" name=\"jourCommandeMasse\" id=\"jourCommandeMasse\" value=\"$date\" />
			<label>&agrave;</label><input readonly disabled=\"disabled\" type=\"text\" name=\"heureCommandeMasse\" id=\"heureCommandeMasse\" value=\"$heure\"/><br /><br />
         ");
		echo("</fieldset>");
		echo("<fieldset>");
	echo("       
			<legend>EMETTEUR</legend><br />
			<table>
				<tr>
					<td><label>Num&eacute;ro</label></td>
					<td><input disabled=\"disabled\" type=\"text\" name=\"Utilisateur\" id=\"utilisateur\" value=\"$_SESSION[id]\"/></td>
				</tr>
				<tr>
					<td><label>Nom</label></td>
					<td><input disabled=\"disabled\" type=\"text\" name=\"EmetteurCM\" id=\"emetteurCM\" value=\"$_SESSION[nom]\"/></td>
				</tr>
				<tr>	
					<td><label>Pr&eacute;nom</label>
					<td><input disabled=\"disabled\" type=\"text\" name=\"Utilisateur\" id=\"utilisateur\" value=\"$_SESSION[prenom]\"/></td>
				</tr></td>
				<tr>	
					<td><label>Affectation</label></td>
					<td><input disabled=\"disabled\" type=\"text\" name=\"Sigle\" id=\"sigle\" value=\"$_SESSION[sigle]\"/></td>
				</tr>
				<tr>
					<td><label>N&deg; de T&eacute;l&eacute;phone</label></td>
					<td><input disabled=\"disabled\" type=\"text\" name=\"Tel\" id=\"tel\" value=\"$_SESSION[telephone]\"/></td>
				</tr>
			</table>
			");
			
        echo("</fieldset>")        
?>

<br /><br />
    
    	<fieldset>
    		<legend> Pi&egrave;ces de la commande </legend>
    		<table>
   	   			<tr> 
	        		<td><label id="titre" class="select">Fournisseurs</label></td>
	        		<td>
                		<select name="four" id='four' onchange="mode_ref_vehicule(this.value); pieces_fournies(this.value);">
                    		<option value='0' >Choisissez un fournisseur</option>
			                    <?php
			$sql = "SELECT nom_fournisseur, id_fournisseur FROM FOURNISSEUR";
			$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
			while($data = mysql_fetch_assoc($req)){
			echo("<option value=".$data['id_fournisseur'].">".$data['nom_fournisseur']."</option>");
			
			}
			               ?>     
                		</select> 
            		</td>
            	</tr>
        		<tr> 
	        		<td><label id="titre">R&eacute;f&eacute;rence</label></td>
	        		<td><input type="text" name="ref" id="ref" value=""/></td>
	        	</tr>
	        	<tr>
	        		<td>
<?php 
if(in_array(11,$droit))
{
	echo "<label>Quantit&eacute;</label></td><td><input type=\"text\" name=\"quant\" id=\"quant\" value=\"1\"/>";
}
else
{
	echo "<label>Quantit&eacute;</label></td><td><input type=\"text\" name=\"quant\" id=\"quant\" value=\"1\"/>";
}
?>
					</td>
        		</tr>
        		<tr>
	        		<td><label id="titre">D&eacute;signation</label></td>
	        		<td><input type="text" id="des" name="des" value=""/></td>
        		</tr>
    		</table>
    	</fieldset>
		<fieldset>
			<legend>Vehicule concern&eacute;</legend>
	    	<table id="vehicule_concerne">
		        <tr id="mode_ref_vehicule"></tr>
		        <tr> 
			        <td><label id="titre" class="select">Silhouette</label></td>
		            <td>
		            	<select name="vehicule" id="vehicule" onchange="Change1(this.value);">
		                    <option>Choisissez la silhouette</option>
<?php
$sql = "SELECT * FROM SILHOUETTE";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_assoc($req))
{
	echo("<option value=".$data['code_silhouette'].">".$data['libelle_silhouette']."</option>");
}
?>
		                </select>
		             </td>
		        </tr>
		        <tr>
		             <td><label id="titre">Code silhouette</label></td>
		             <td><div id="resultat1"><input type='text' readonly id='codesil' name='codesil' value="" /></div></td>
		        </tr>
		        <tr>
		        	<td><label id="titre" class="select">Description d&eacute;faut</label></td>
		        	<td><textarea name="des_def" id="ref"/></textarea></td>
		        </tr>
		    </table>
    	</fieldset>
		<fieldset>
			<legend>Responsable par d&eacute;faut </legend>
		    <table id="Responsable defaut">
				<tr> 
		             <td><label id="titre" class="select">Entit&eacute;</label></td>
		             <td>
		                <select name="nomca" id="nomca" onchange="Change(this.value);">
		                    <option>Choisissez votre entit&eacute;</option>
		                    <?php
		$sql = "SELECT * FROM ENTITE";
		$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		while($data = mysql_fetch_assoc($req)){
		echo("<option value=".$data['code_imputation'].">".$data['libelle_entite']."</option>");
		}
		?>
		                    
		                </select> 
		             </td>
		        </tr>
		        
				<tr> 
		            <td><label id="titre">CA imput&eacute;</label></td>
		            <td><div id="resultat"><input type='text'  readonly  id='numCA' name='numCA' value="" /></div></td>
		        </tr>
		    </table>
		</fieldset>

	  <input id="val" type="submit" class="small green nice button radius" value="Enregistrer la commande">
	  <a href='../commande/accueil.php' class="small red nice button radius" >Annuler la commande</a>
	
		<!-- Bouton de remise à zéro 
		On efface les champs en appelant la page courante
		-->
		<a href='pieces_synchrone.php' class="small blue nice button radius" >Effacer</a>
	
		</div>
	<div id="pieces_fournie" style="display:none;">
	      
	</div>
</form>
<?php footer_html(); ?>
