<?php header_html("Ajout d'une commande de masse", array("web/style.css", "../../include/css/global.css", "../../include/framework/foundation.css"), array("web/script.js"))?>
			
			<div id='message'><p><?php afficheMessage(); ?></p></div>
			<div id='section'>
				<form id='formulaire' action='./?action=<?php printHtml($method); ?>' method='post'>
					
					<!-- Affichage de la section Commande -->
					<fieldset id='commande'>
						<legend>Commande</legend> <br />
						
						<table>
							<tr>
								<td><label>Commande n° : </label></td>
								<td><?php printHtml($noCommande); ?></td>
							</tr>
							<tr>
								<td><label>Effectuée le : </label></td>
								<td><?php echo "Le " . convertDate_Amj_string($date) . " à " . $heure; ?></td>
							</tr>
							<tr>
								<td><label>Emetteur : </label></td>
								<td><?php echo html($user['nom_utilisateur']) . " " . html($user['prenom_utilisateur']) . " " . html($user['id_utilisateur']);?></td>
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
					
					<!-- Champs cachés -->
					<input type='hidden' id='no_commande' name='no_commande' value='<?php echo html($noCommande); ?>' />
					<input type='hidden' id='id_user' name='id_user' value='<?php echo html($user['id_utilisateur']); ?>' />
					<input type='hidden' id='date_commande' name='date_commande' value='<?php echo html($date); ?>' />
					<input type='hidden' id='heure_commande' name='heure_commande' value='<?php echo html($heure); ?>' />
					
					<!-- Boutons de soumission du formulaire -->
					<input type='submit' class="small green nice button radius" id='enregistrer' name='enregistrer' value='Enregistrer' />
					<a href='../../commande/accueil.php' class="small red nice button radius" >Annuler la commande</a>
					<input type='button' class="small blue nice button radius" id='cancel' name='cancel' value='Effacer' />
				</form>
			</div>
<?php footer_html(); ?>
