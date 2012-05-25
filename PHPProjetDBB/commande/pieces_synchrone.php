<?php  

session_start(); 
include('../connexion/_connexion.php');
include ('../include/layout/layout.inc.php');
include('../include/library/library.inc.php');

require_once("../fonctionhtml.php");  
require_once("../connexion/verification_connexion.php");
require_once("./nocommande.php");
header_html("Commande de pièces synchrones",array("../Style.css"),array("fonction.js","../controle/controle.js")); 
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
	echo(   "<label id=\"titre1\">RECAPITULATIF</label><br />
			<label id=\"titre\">Commande N&deg;</label><input readonly disabled=\"disabled\" type=\"text\" name=\"numCommandeMasse\" id=\"numCommandeMasse\"  value=\"$numCommande\" />
			<label>effectu&eacute;e le</label><input readonly disabled=\"disabled\" type=\"text\" name=\"jourCommandeMasse\" id=\"jourCommandeMasse\" value=\"$date\" />
			<label>&agrave;</label><input readonly disabled=\"disabled\" type=\"text\" name=\"heureCommandeMasse\" id=\"heureCommandeMasse\" value=\"$heure\"/><br /><br />
                
			<label id=\"titre1\">EMETTEUR</label><br />
			<label>Num&eacute;ro</label><input readonly disabled=\"disabled\" type=\"text\" name=\"Utilisateur\" id=\"utilisateur\" value=\"$_SESSION[id]\"/><br />
			<label>Nom</label><input readonly disabled=\"disabled\" type=\"text\" name=\"EmetteurCM\" id=\"emetteurCM\" value=\"$_SESSION[nom]\"/><br />
			<label>Pr&eacute;nom</label><input readonly disabled=\"disabled\" type=\"text\" name=\"Utilisateur\" id=\"utilisateur\" value=\"$_SESSION[prenom]\"/><br />
			<label>Affectation</label><input readonly disabled=\"disabled\" type=\"text\" name=\"Sigle\" id=\"sigle\" value=\"$_SESSION[service]\"/><br />
			<label>N&deg; de T&eacute;l&eacute;phone</label><input readonly disabled=\"disabled\" type=\"text\" name=\"Tel\" id=\"tel\" value=\"$_SESSION[telephone]\"/>
			");
			
                
?>

<br /><br />
    <table>
        <caption id="titre1"> Pi&egrave;ces de la commande </caption>
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
	        <td><label id="titre">R&eacute;f&eacute;rence</label> <input type="text" name="ref" id="ref" value="" onchange="verifierRef('ref')"/></td>
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
<br />
    <table id="vehicule_concerne">
        <caption id="titre1">Vehicule concern&eacute;</caption>
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
                <label id="titre">Code silhouette</label><div id="resultat1"><input readonly value="" /></div>
            </td>
        </tr>
        
        <tr>
	        <td><label id="titre" class="select">Description d&eacute;faut</label> <textarea name="des_def" id="ref"/></textarea>
        </tr>

    </table>
<br />
    <table id="Responsable defaut">
        <caption id="titre1">Responsable par d&eacute;faut </caption>
   	
		<tr> 
             <td><label id="titre" class="select">Entit&eacute;</label>
                <select name="nomca" onchange="Change(this.value);">
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
            <td><label id="titre">CA imput&eacute;</label><div id="resultat"><input readonly value="" /> </div> </td>
        </tr>
		
    </table>
    <br />
    <br />
  <input id="val" type="submit" action="" value="Enregistrer la commande">
  <input type="reset" id="anu" value="Annuler la commande" onclick="document.location.href='../commande/accueil.php';">
</div>
<div id="pieces_fournie" style="display:none;">
  
      
</div>
</form>

<?php 
footer_html();
?>
