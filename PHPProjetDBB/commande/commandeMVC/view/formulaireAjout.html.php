<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
<link href='web/style.css' rel='stylesheet' type='text/css'>
</head>
<body>
	<div id='main'>
		<div id='header'>
		</div>
		<div id='wrap'>
			<div id='section'>
			
			
				<form id='formulaire' action='./?action=<?php printHtml($method); ?>' method='post'>
				
					<fieldset id='commande'>
						<legend>Commande</legend> <br />
						
						<label>Commande n° : </label>
						<span>1034356543</span> 
						<br />
						
						<label>Effectuée le : </label> 
						<span>02/02/2012 à 10h54</span>
						<br />
						
						<label>Emetteur : </label> 
						<span>Jean-Pascal FB45034</span>
						<br />
							
					</fieldset>
					
					
					
					
					<fieldset id='piece'>
						<legend>Pièces</legend>
						
						<label for='piecePrincipales'>Pièces principales</label>
						<p>
							<input type='texte' name='piecePrincipales' id='piece'/>
						</p>
						<label for='pieceEnvironnement'>Pièces d'environnement</label>
						<p>
							<input type='texte' name='pieceEnvironement' id='piece'/>
						</p>
						
					</fieldset>
					
					
					
					<fieldset id='responsable'>
						<legend>Responsable</legend>
					</fieldset>	
					
					
					<input type='submit' id='enregistrer' name='enregistrer' value='enregistrer' />
					<input type='button' id='cancel' name='cancel' value='effacer' />
				</form>
			</div>
		</div>
		<div id='footer'>
		</div>
	</div>
</body>
</html>