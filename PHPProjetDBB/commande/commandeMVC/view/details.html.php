<?php header_html("Détails des livraisons de la commande n°" . $commande['no_commande'], array("web/style.css", "../../include/css/global.css", "../../include/framework/foundation.css"), array("web/scriptDetails.js"))?>

			<script src="/include/js/development-bundle/jquery.min.js" type="text/javascript"></script>
			<script src="/include/js/development-bundle/ui/jquery.ui.core.js" type="text/javascript"></script>
			<script src="/include/js/development-bundle/ui/jquery.ui.widget.js" type="text/javascript"></script>
			<script src="/include/js/development-bundle/ui/jquery.ui.datepicker.js" type="text/javascript"></script>
			<script type='text/javascript' src='/include/js/development-bundle/jquery.dataTables.min.js'></script>	
			<style>
				table#piecePrincipales, table#pieceEnvironnement {
					width: 900px !important;
				}
				table td > span {
					display: inline-block;
					vertical-align: top;
					margin: 0 10px;
				}
				
				table#piecePrincipales th, table#pieceEnvironnement th, table#piecePrincipales td, table#pieceEnvironnement td {
					width: auto !important;
				}
				
				input.quantite {
					width: 30px;
				}
				
				input.date {
					width: 70px;
				}
			</style>
			
			<div id='message'><p><?php afficheMessage(); ?></p></div>
			<div id='section'>
			
				<form id='formulaire' action='./?action=<?php printHtml($method); ?>' method='post'>
					
					<!-- Affichage de la section Commande -->
					<fieldset id='commande'>
						<legend>Commande</legend> <br />
						<table>
							<tr>
								<td><label>Commande n° : </label></td>
								<td id='noCommande' ><?php printHtml($noCommande); ?></td>
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
									<?php foreach($pieces['principales'] as $piece) $modelePiece->displayRowPrincipaleDisabledLivraisons($piece, $commande['no_commande']); ?>
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
									<?php foreach($pieces['environnement'] as $piece) $modelePiece->displayRowEnvironnementDisabledLivraisons($piece, $commande['no_commande']); ?>
								</tbody>
							</table>
			
						</div>
					</fieldset>
					
					<!-- Champs cachés -->
					<input type='hidden' id='no_commande' name='no_commande' value='<?php echo html($noCommande); ?>' />
					<input type='hidden' id='id_user' name='id_user' value='<?php echo html($user['id_utilisateur']); ?>' />
					
					<!-- Boutons de soumission du formulaire -->	
					<a href='../../commande/accueil.php' id='validerLivraisons' class="small green nice button radius" >Valider la commande</a>
					<a href='./?visualiser=<?php printHtml($commande['no_commande']); ?>' class="small red nice button radius" >Retour à la commande</a>
					
				</form>
			</div>
<?php footer_html(); 

print_r_html($commande);?>