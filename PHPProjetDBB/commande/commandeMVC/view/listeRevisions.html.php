<?php header_html("Ajout d'une commande de masse", array("web/style.css", "web/styleListeRevisions.css", "../../include/global.css", "../../include/framework/foundation.css"), array("web/script.js", "web/scriptModification.js"))?>
			<div id='section'>
				<h2>Commande de masse</h2>
				
				<div id='commandesContent' >
<?php 
					if(!isset($commandes) || empty($commandes)) return false;
					$i = 2;
					foreach($commandes as $commande)
					{ 
?>
						<div class='revision' >
						<h3>N°<?php echo $i; ?></h3>
						<span><a href='./?voir=<?php printHtml($commande['no_commande']); ?>&no_historique=<?php printHtml($commande['no_historique']); ?>' >voir la révision</a></span>
						
							<table>
								<tr>
									<td><label>Commande n° : </label></td>
									<td><?php printHtml($commande['no_commande']); ?></td>
								</tr>
								<tr>
									<td><label>Effectuée le : </label></td>
									<td><?php printHtml(convertDate_Amj_string($commande['date_commande'])); ?> à <?php printHtml($commande['heure_commande']); ?></td>
								</tr>
								<tr>
									<td><label>Emetteur : </label></td>
									<td>Jean-Pascal <?php printHtml($commande['id_utilisateur_passe']); ?></td>
								</tr>
								<tr>
									<td><label for="ReferenceDossierCommandeMasse">Motif du dossier : </label></td>
									<td><?php printHtml($commande['libelle_type_chantier']); ?></td>
								</tr>
								<tr>
									<td>N° du dossier</td>
									<td><?php printHtml($commande['no_chantier']); ?></td>
								</tr>
	
							</table>	
						</div>
<?php
						$i++;
					}
			
				
?>
				</div>
			</div>

<?php footer_html(); ?>