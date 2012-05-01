<?php 
 
$choix_rech=$_POST['choix_rech'];

        
if($choix_rech=="fournisseur"){

		 	echo"	<br/>	
				<tr>
				<th>Code fournisseur :</th>
        		<th><input type=\"text\" id=\"noFournisseur\" value=\"\"/></td>
        		</tr>
        		<br/><br/>
        		<input type=\"button\" id=\"Rechercher\" value=\"Rechercher\" onclick=\"choix_('fournisseur')\"/>";

} 
else if($choix_rech=="piece"){

		 	echo"	<br/>	
				<tr>
				<th>N° piece</th> 
        		<td><input type=\"text\" id=\"noPiece\" value=\"\" onchange=\"verifierRef('noPiece');\" /></td>
        		</tr>
        		<br/><br/>
        		<input type=\"button\" id=\"Rechercher\" value=\"Rechercher\"  onclick=\"choix_('piece')\"/>";

} 
else if($choix_rech=="silhouette"){

		 	echo"	<br/>	
				<tr>
				<th>N° silhouette </th>
        		<td><input type=\"text\" id=\"noSilhouette\" value=\"\"/></td>
        		</tr>
        		<br/><br/>
        		<input type=\"button\" id=\"Rechercher\" value=\"Rechercher\" onclick=\"choix_('silhouette')\"/>";

} 
else if($choix_rech=="noCommande"){

		 	echo"	<br/>	
				<tr>
				<th>N° commande </th>
        		<td><input type=\"text\" id=\"noCommande\" value=\"\"/></td>
        		</tr>
        		<br/><br/>
        		<input type=\"button\" id=\"Rechercher\" value=\"Rechercher\" onclick=\"choix_('noCommande')\"/>";

} 
else if($choix_rech=="typeCommande"){

		 	echo"	<br/>	
				<tr>
				<th>Type commande :</th>
        		<td><input type='radio' name='type' id='unit' />Commande unitaire<br>
        		<input type='radio' name='type' id='masse' />Commande de masse<br></td>
        		</tr>
        		<br/><br/>
        		<input type=\"button\" id=\"Rechercher\" value=\"Rechercher\" onclick=\"choix_('typeCommande')\"/>";

} 
else if($choix_rech=="etatCommande"){

		 	echo"	<br/>	
				<tr>
				<th>Etat commande :</th>
        		<td><input type='radio' name='type' id='open' />Ouverte<br>
        		<input type='radio' name='type' id='close' />Fermée<br></td>
        		</tr>
        		<br/><br/>
        		<input type=\"button\" id=\"Rechercher\" value=\"Rechercher\" onclick=\"choix_('etatCommande')\"/>";

} 
else if($choix_rech=="date_creation"){

		 	echo"	<br/>	
				<label id=\"label\">Date min création </label>
        		<input type=\"text\" onchange=\"verifierDate('date1');\" id=\"date1\" value=\"aaaa-mm-jj\"/>
        		<br/> 
        		<label id=\"label\">Date max création</label>
        		<input type=\"text\" onchange=\"verifierDate('date2');\" id=\"date2\" value=\"aaaa-mm-jj\"/>
        		<br/><br/>
        		<input type=\"button\" id=\"Rechercher\" value=\"Rechercher\" onclick=\"choix_('date_creation')\"/>";

} 
else if($choix_rech=="date_reception"){

		 	echo"	<br/>	
				<label id=\"label\">Date min reception </label>
        		<input type=\"text\" onchange=\"verifierDate('date1');\" id=\"date1\" value=\"aaaa-mm-jj\"/>
        		<br/> 
        		<label id=\"label\">Date max reception</label>
        		<input type=\"text\" onchange=\"verifierDate('date2');\" id=\"date2\" value=\"aaaa-mm-jj\"/>
        		<br/><br/>
        		<input type=\"button\" id=\"Rechercher\" value=\"Rechercher\" onclick=\"choix_('date_reception')\"/>";

} 



?>
