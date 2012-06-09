<?php header_html("Détails des livraisons d'une commande de masse", array("web/style.css", "../../include/css/global.css", "../../include/framework/foundation.css"), array("web/scriptDetails.js"))?>
			
			
			<div id='section'>
			
				<form id='formulaire' action='./?action=<?php printHtml($method); ?>' method='post'>
					
					<!-- Affichage de la section Commande -->
					<fieldset id='commande'>
						<legend>Commande</legend> <br />
						<?php $modeleCommande->verifieFermetureAnnulation($commande); ?>
						<table>
							<tr>
								<td><label>Commande n° : </label></td>
								<td><?php printHtml($noCommande); ?></td>
							</tr>
							<tr>
								<td><label>Effectuée le : </label></td>
								<td><?php echo "Le " . convertDate_Amj_string($commande['date_commande']) . " à " . $commande['heure_commande']; ?></td>
							</tr>
							<tr>
								<td><label>Emetteur : </label></td>
								<td><?php echo $userCommande['nom_utilisateur'] . " " . $userCommande['prenom_utilisateur'] . " - " . $userCommande['id_utilisateur']; ?></td>
							</tr>
						</table>	
							
					</fieldset>
					
					
					
					<!-- Affichage de la section Pièce -->
					<fieldset id='piece'>
						<legend>Livraisons</legend>
						<div id="piecesAjoutee">
			
							<table id="piecePrincipales">
								<caption>Pièces principales</caption>
								<thead>
									<tr>
										<th>référence</th>
										<th>libellé</th>
										<th>quantité</th>
										<th>potentiel / jours</th>
										<th>reste à livrer</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($pieces['principales'] as $piece) $modelePiece->displayRowPrincipaleDisabled($piece); ?>
								</tbody>
							</table>
			
			
			
			
							<table id="pieceEnvironnement">
								<caption>Pièces d'environnement</caption>
								<thead>
									<tr>
										<th>référence</th>
										<th>libellé</th>
										<th>quantité</th>
										<th>reste à livrer</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($pieces['environnement'] as $piece) $modelePiece->displayRowEnvironnementDisabled($piece); ?>
								</tbody>
							</table>
			
						</div>
					</fieldset>	
					
					<!-- Champs cachés -->
					<input type='hidden' id='no_commande' name='no_commande' value='<?php echo html($noCommande); ?>' />
					<input type='hidden' id='id_user' name='id_user' value='<?php echo html($user['id_utilisateur']); ?>' />
					
					<!-- Boutons de soumission du formulaire -->
					<a href='./?visualiser=<?php printHtml($commande['no_commande']); ?>' class="small blue nice button radius" >Retour à la commande</a>
					<a href='../../commande/accueil.php' class="small green nice button radius" >Annuler la commande</a>
					<a href='./?fermerCommande=<?php printHtml($commande['no_commande']); ?>' class="small red nice button radius" >Fermer la commande</a>
				</form>
			</div>
<?php footer_html(); 

print_r_html($commande);?>