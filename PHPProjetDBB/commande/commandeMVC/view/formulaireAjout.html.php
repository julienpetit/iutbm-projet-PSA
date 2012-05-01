<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Ajout d'une commande de masse</title>
<link href='web/style.css' rel='stylesheet' type='text/css'>
<link href='/include/framework/foundation.css' rel='stylesheet' type='text/css'>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript" ></script>
<script src="web/script.js" type="text/javascript" ></script>
</head>
<body>
	<div id='main'>
		<div id='header'>
		</div>
		<div id='wrap'>
			<div id='section'>
			
				<h2>Commande de masse</h2>
				<form id='formulaire' action='./?action=<?php printHtml($method); ?>' method='post'>
					
					<!-- Affichage de la section Commande -->
					<fieldset id='commande'>
						<legend>Commande</legend> <br />
						
						<table>
							<tr>
								<td><label>Commande n° : </label></td>
								<td>1034356543</td>
							</tr>
							<tr>
								<td><label>Effectuée le : </label></td>
								<td>02/02/2012 à 10h54</td>
							</tr>
							<tr>
								<td><label>Emetteur : </label></td>
								<td>Jean-Pascal FB45034</td>
							</tr>
							<tr>
								<td><label for="ReferenceDossierCommandeMasse">Motif du dossier : </label></td>
								<td>
									<select id="ReferenceDossierCommandeMasse" name="ReferenceDossierCommandeMasse">
			                            <option>choisir un motif</option>
			                            <option value="crise">Crise</option>
			                            <option value="panne">Panne</option> 
			                        </select>
								</td>
							</tr>
							<tr>
								<td></td>
								<td></td>
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
										<td>référence</td>
										<td>libellé</td>
										<td>quantité</td>
										<td>potentiel / jours</td>
										<td>supprimer</td>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
							
							
							
							
							<table id='pieceEnvironnement'>
								<caption>Pièces d'environnement</caption>
								<thead>
									<tr>
										<td>référence</td>
										<td>libellé</td>
										<td>quantité</td>
										<td>potentiel / jours</td>
										<td>supprimer</td>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
						
						
						<div id='piecesPrincipalesHidden'>
						</div>
						<div id='piecesEnvironnementHidden'>
						</div>
					</fieldset>
					
					
					<!-- Affichage de la section Responsable -->
					<fieldset id='responsable'>
						<legend>Responsable</legend>
						
						<table>
							<tr>
								<td>Entité</td>
								<td>
									<select id="EntiteCM" name="EntiteCM" onchange="Change(this.value);">
	                                	<option>choisir une entité</option>
	                                    <option value="en001">defaut</option>
	                                    <option value="en002">casse</option>
	                                    <option value="en003">rebut</option>
	                               </select>
								</td>
							</tr>
							<tr>
								<td><label>Chiffre d'affaire imputé : </label></td>
								<td><input type='text' name='CAImpute' id='CAImpute' /></td>
							</tr>
						</table>
					</fieldset>	
					
					<!-- Boutons de soumission du formulaire -->
					<input type='submit' class="small blue nice button radius" id='enregistrer' name='enregistrer' value='enregistrer' />
					<input type='button' class="small red nice button radius" id='cancel' name='cancel' value='effacer' />
				</form>
			</div>
		</div>
		<div id='footer'>
		</div>
	</div>
</body>
</html>