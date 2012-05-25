<?php header_html("Ajout d'une commande de masse", array("web/style.css", "../../include/global.css", "../../include/framework/foundation.css"), array("web/script.js", "web/scriptModification.js"))?>
			<div id='section'>
				<h2>Commande de masse</h2>
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
								<td>Jean-Pascal <?php printHtml($commande['id_utilisateur_passe']); ?></td>
							</tr>
							<tr>
								<td><label for="ReferenceDossierCommandeMasse">Motif du dossier : </label></td>
								<td><?php printHtml($commande['libelle_type_chantier']); ?></td>
							</tr>
							<tr>
								<td>N° du dossier</td>
								<td><input type='text' id='noDossier' name='noDossier' value='<?php printHtml($commande['no_chantier']); ?>'/></td>
							</tr>

						</table>	
						
						<div id='boxHistory'><?php echo $modeleCommandeHistorique->displayBoxHistory("0111121785"); ?></div>
							
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
										<th>supprimer</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($pieces['principales'] as $piece) $modelePiece->displayRowPrincipale($piece); ?>
								</tbody>
							</table>
							
							
							
							
							<table id='pieceEnvironnement'>
								<caption>Pièces d'environnement</caption>
								<thead>
									<tr>
										<th>référence</th>
										<th>libellé</th>
										<th>quantité</th>
										<th>supprimer</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($pieces['environnement'] as $piece) $modelePiece->displayRowEnvironnement($piece); ?>
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
								<td>Entité</td>
								<td>
								<?php $modeleEntite->displaySelect("EntiteCM", html($commande['code_imputation'])); ?>
								</td>
							</tr>
						</table>
					</fieldset>	
					
				</form>
			</div>

<?php footer_html(); ?>