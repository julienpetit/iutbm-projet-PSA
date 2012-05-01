<?php 
 
include('../connexion/_connexion.php');

require_once("../fonctionhtml.php");  

html_entete_fichier("accueil","../Style.css","script.js","../controle/controle.js");

mysql_query("SET NAMES UTF8");
echo("<body>");
?>

      <div id="page">
		<form>
			<fieldset>
				<label> Choix de la recherche </label>
				<select name="table" onchange="critere(this.value)">
					<option select="selected">Selectionner un critère de recherche</option>
					<option value="fournisseur">Fournisseur</option>
					<option value="piece">Piece</option>
					<option value="silhouette">Silhouette</option>
					<option value="noCommande">N° commande</option>
					<option value="typeCommande">Type commande</option>
					<option value="etatCommande">Etat commande(ouverte/fermée)</option>
					<option value="date_creation">Période de création</option>
					<option value="date_reception">Période de réception</option>
				</select>
			<div id="date">
                
                
            </div>
		          
                <input type="reset" id="anu" value="Accueil" onclick="document.location.href='../commande/accueil.php';" /> 
          
			</fieldset>
		</form>

	</div>	
			
        <div id="content">
          
<?php

$sql= "SELECT * FROM COMMANDE";

echo "<script>affichage('".$sql."')</script>";


/**********************Fin tableau************************/

	?>
</div>
        <?php mysql_close(); // deconnexion de la base ?>
	</body>
</html>
