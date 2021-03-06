<?php header_html("Visualisation de la commande n°" . $commande['no_commande'], array("web/style.css", "../../include/global.css", "../../include/framework/foundation.css"), array("web/script.js", "web/scriptModification.js"))?>
			<div id='message'><p><?php afficheMessage(); ?></p></div>
			<div id='section'>
				
				<form id='formulaire' action='./?action=<?php printHtml($method); ?>' method='post'>
					
					<!-- Affichage de la section Commande -->
					<fieldset id='commande'>
						<legend>Commande</legend> <br />
						
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
								<td><?php echo $userCommande['nom_utilisateur'] . " " . $userCommande['prenom_utilisateur'] . " - " . $userCommande['id_utilisateur']; ?></td>
							</tr>
							<tr>
								<td><label for="ReferenceDossierCommandeMasse">Motif du dossier : </label></td>
								<td><?php echo html($commande['libelle_type_chantier']); ?></td>
							</tr>
							<tr>
								<td>N° du dossier</td>
								<td><?php printHtml($commande['no_chantier']); ?></td>
							</tr>
						</table>	
							
						<?php
						if($modeleCommande->isCanceled($commande['no_commande']))
						{
							echo "<div id='commandeCanceled' >Commande annulée</div>";
						}
						if($modeleCommande->isClosed($commande['no_commande']))
						{
							echo "<div id='commandeClosed' >Commande fermée</div>";
						}
					?>
					</fieldset>
					
					
					
					<!-- Affichage de la section Pièce -->
					<fieldset id='piece'>
						<legend>Pièces</legend>
							
						<div id="piecesAjoutee">
						
							<table id='piecePrincipales'>
								<caption>Pièces principales</caption>
								<thead>
									<tr>
										<th>référence</th>
										<th>libellé</th>
										<th>quantité</th>
										<th>potentiel / jours</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($pieces['principales'] as $piece) $modelePiece->displayRowPrincipaleDisabled($piece); ?>
								</tbody>
							</table>
							
							
							<table id='pieceEnvironnement'>
								<caption>Pièces d'environnement</caption>
								<thead>
									<tr>
										<th>référence</th>
										<th>libellé</th>
										<th>quantité</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($pieces['environnement'] as $piece) $modelePiece->displayRowEnvironnementDisabled($piece); ?>
								</tbody>
							</table>
							
						</div>
						
						
						<div id='piecesPrincipalesHidden'></div>
						<div id='piecesEnvironnementHidden'></div>
					</fieldset>
					
					<!-- Affichage de la section Responsable -->
					<fieldset id='responsable'>
						<legend>Responsable</legend>
						
						<table>
							<tr>
								<td>Entité : </td>
								<td>
								<?php $modeleEntite->displayEntite(html($commande['code_imputation'])); ?>
								</td>
							</tr>
						</table>
					</fieldset>	
					
					<input type='hidden' id='noCommande' name='noCommande' value='<?php printHtml($commande['no_commande']); ?>' />		
					<!-- Boutons de soumission du formulaire -->
					<a href='./?details=<?php printHtml($commande['no_commande']); ?>' class="small green nice button radius" >Etat des livraisons</a>
					<a href='./?genererPdf=<?php printHtml($commande['no_commande']); ?>' class="small blue nice button radius" >Générer un Pdf</a>
					<?php
						if(!$modeleCommande->isCanceled($commande['no_commande']) && !$modeleCommande->isClosed($commande['no_commande']))
						{
							echo "<a href='/commande/commandeMVC/?annuler=".$commande['no_commande']."' id='annulerCommande' class='small red nice button radius confirm' >Annuler la commande</a>";
							echo "<a href='/commande/commandeMVC/?fermer=".$commande['no_commande']."' id='fermerCommande' class='small red nice button radius confirm' >Fermer la commande</a>";
						}
					?>
				</form>
			</div>
<?php footer_html(); ?>
