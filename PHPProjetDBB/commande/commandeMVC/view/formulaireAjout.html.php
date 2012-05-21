<?php header_html("Ajout d'une commande de masse", array("web/style.css"), array("web/script.js"))?>
			<div id='section'>
				<h2>Commande de masse</h2>
				<form id='formulaire' action='./?action=<?php printHtml($method); ?>' method='post'>
					
					<!-- Affichage de la section Commande -->
					<fieldset id='commande'>
						<legend>Commande</legend> <br />
						
						<table>
							<tr>
								<td><label>Emetteur : </label></td>
								<td>Jean-Pascal FB45034</td>
							</tr>
							<tr>
								<td><label for="ReferenceDossierCommandeMasse">Motif du dossier : </label></td>
								<td>
									<select id="ReferenceDossierCommandeMasse" name="ReferenceDossierCommandeMasse">
			                            <option value="0" >choisir un motif</option>
			                            <option <?php ?>value="crise">Crise</option>
			                            <option value="panne">Panne</option> 
			                        </select>
								</td>
							</tr>
							<tr>
								<td>N° du dossier</td>
								<td><input type='text' id='noDossier' name='noDossier' /></td>
							</tr>

						</table>	
							
					</fieldset>
					
					
					
					<!-- Affichage de la section Pièce -->
					<fieldset id='piece'>
						<legend>Pièces</legend>
						<div id='listePieces'>
							<?php $modelePiece->displayWidgetPiece(); ?>
						</div>
							
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
								<?php $modeleEntite->displaySelect("EntiteCM"); ?>
								</td>
							</tr>
						</table>
					</fieldset>	
					
					<!-- Boutons de soumission du formulaire -->
					<input type='submit' class="small blue nice button radius" id='enregistrer' name='enregistrer' value='enregistrer' />
					<input type='button' class="small red nice button radius" id='cancel' name='cancel' value='effacer' />
				</form>
			</div>
<?php footer_html(); ?>