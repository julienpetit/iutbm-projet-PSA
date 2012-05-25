<?php  

session_start(); 
include('../connexion/_connexion.php');
include('../include/layout/layout.inc.php');
include('../include/library/library.inc.php');
header_html("Commande de pièces synchrones",array("../Style.css"),array("fonction.js","../controle/controle.js"));

require_once("../fonctionhtml.php");  
require_once("../connexion/verification_connexion.php");
require_once("./nocommande.php");
// html_entete_fichier("accueil","../Style.css","fonction.js","../controle/controle.js"); 
mysql_query("SET NAMES UTF8");
check_log_user($_SESSION['no_droit'],1,NULL);
echo("<body>");
?>
<div id="titreprincipal">Commande unitaire de pi&egrave;ce synchrone</div><br/><br/>
<form method="post" action="send_mail_four_synch.php">
<div id="contenu">
<?php
	$date = date("d/m/Y");
	$heure = date("h:i:s");
	$numCommande = noCommande();
        $droit=$_SESSION['no_droit'];   

    echo("<fieldset>");
    echo("<legend>Informations </legend>");
	echo(   "<label id=\"titre\">Commande N&deg;</label><input readonly type=\"text\" name=\"numCommandeMasse\" id=\"numCommandeMasse\"  value=\"$numCommande\" disabled=\"disabled\" />
			<label>Date</label><input readonly type=\"text\" name=\"jourCommandeMasse\" id=\"jourCommandeMasse\" value=\"$date\" disabled=\"disabled\" />
			<label>&agrave;</label><input readonly type=\"text\" name=\"heureCommandeMasse\" id=\"heureCommandeMasse\" value=\"$heure\" disabled=\"disabled\"/><br /><br />
                
			<label id=\"titre\">Emetteur</label><input readonly type=\"text\" name=\"EmetteurCM\" id=\"emetteurCM\" value=\"$_SESSION[nom]\" disabled=\"disabled\"/>
			<input readonly type=\"text\" name=\"Utilisateur\" id=\"utilisateur\" value=\"$_SESSION[prenom]\" disabled=\"disabled\"/>
			<input readonly type=\"text\" name=\"Sigle\" id=\"sigle\"  value=\"$_SESSION[sigle]\" disabled=\"disabled\"/><br />
			<label id=\"titre\">Et</label><input readonly type=\"text\" name=\"Tel\" id=\"tel\"  value=\"$_SESSION[telephone]\" disabled=\"disabled\"/>
			");
	echo("</fieldset>");
                
?>

<br /><br />

	<fieldset>
    <legend>Pi&egrave;ces commande </legend>

    <table>
    
        <!-- <caption id="titre1"> Pi&egrave;ces commande </caption> -->
   	    <tr> 
	        <td><label id="titre" class="select">Fournisseurs</label> 
                <select name="four" onchange="mode_ref_vehicule(this.value); pieces_fournies(this.value);">
                    <option>Choisissez un fournisseur</option>
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
	        <td><label id="titre">R&eacute;ference</label> <input type="text" name="ref" id="ref" value="" onchange="verifierRef('ref')"/></td>
		<?php if(in_array(11,$droit))
			{
	       echo "<td><label>Quantit&eacute;</label> <input type=\"text\" name=\"quant\" id=\"quant\" value=\"1\" onkeyup=\"verifierQuant('quant')\" onchange=\"alertQuant('quant')\" /></td>";
			}
else{
		echo "<td><label>Quantit&eacute;</label> <input readonly type=\"text\" name=\"quant\" id=\"quant\" value=\"1\" onkeyup=\"verifierQuant('quant')\" onchange=\"alertQuant('quant')\" /></td>";
}

?>
        </tr>
        <tr>
	        <td><label id="titre">D&eacute;signation</label> <input type="text" id="des" name="des" value=""/></td>
        </tr>

    </table>
    </fieldset>
<br />

	<fieldset>
    <legend>Vehicule concern&eacute; </legend>
    <table id="vehicule_concerne">
        <!-- <caption id="titre1">Vehicule concern&eacute;</caption>  -->
        
        <tr id="mode_ref_vehicule">
        
        </tr>
        
        <tr> 
	        <td><label id="titre" class="select">Silhouette</label>
                <select name="vehicule" id="vehicule" onchange="Change1(this.value);">
                    <option>Choisissez la silhouette</option>
                     <?php
						$sql = "SELECT * FROM SILHOUETTE";
						$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
						while($data = mysql_fetch_assoc($req)){
							echo("<option value=".$data['code_silhouette'].">".$data['libelle_silhouette']."</option>");
						}
					?>	
                </select> 
            </td>

	        <td>
                
                <div id="resultat1"><input readonly value="" disabled="disabled"/></div>
                
            </td>
        </tr>
        
        <tr>
	        <td><label id="titre" class="select">Description defaut</label> <textarea name="des_def" id="ref"/></textarea>
        </tr>

    </table>
    </fieldset>
<br />

	<fieldset>
	<legend>Responsable d&eacute;faut </legend>
    <table id="Responsable defaut">
   <!--  <caption id="titre1">Responsable d&eacute;faut </caption> -->    
   	
		<tr> 
             <td><label id="titre" class="select">Entit&eacute;</label> 
                <select name="nomca" onchange="Change(this.value);">
                    <option>Choisissez votre entite</option>
                    <?php
						$sql = "SELECT * FROM ENTITE";
						$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
						while($data = mysql_fetch_assoc($req)){
							echo("<option value=".$data['code_imputation']." >".$data['libelle_entite']."</option>");
						}
					?>
                    
                </select> 
             </td>
        </tr>
		<tr> 
            <td><label id="titre">CA imput&eacute;</label><div id="resultat"><input value="" /> </div> </td>
        </tr>
		
    </table>
    </fieldset>
    <br />
    <br />
  <input id="val" type="submit" action="" value="Enregistrer la commande">
  <input type="reset" id="anu" value="Abandonner la commande" onclick="document.location.href='../commande/accueil.php';">
  
   <!-- Bouton de remise à zéro 
        On efface les champs en appelant la page courante
    -->
    <input id='reset' type='button' value="Effacer" onclick="document.location.href='pieces_synchrone.php';" />
  
</div>
<div id="pieces_fournie" style="display:none;">
  
      
</div>
</form>

<?php 
footer_html();
?>

