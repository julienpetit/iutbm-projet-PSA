$(document).ready(function() {
   /**
    * Widget Pièces ----------------------------------------------------------------------------------------
    */
	
	// Recherche de pièces
	$("input#recherchePiece").keyup(function(){
		var chaine = $('input#recherchePiece').val();
		
		params = {};
		params['chaine'] = chaine;

		// On vérifie si le classement n'existe pas
		$.ajax({
			type: 'post',
			url: 'index.php?ajax=recherchePieces',
			data: params,
			beforeSend: function(){
				// Affichage du loader
				$('div#listePieces > input').toggleClass('loader');
			},
			complete: function(x){
				if(x.responseText != ""){
					$('div#listePieces > table > tbody').html(x.responseText);
				}
				else {
					$('div#listePieces > table > tbody').html("<span id='pasTrouve'>Aucune pièce trouvée.</span>");
				}
				// Masquage du loader
				$('div#listePieces > input').toggleClass('loader');
			}
		});
		
	});
	
	
	/*
	 * Ajout d'une pièce à la commande  -----------------------------------------------------------------------
     */

	// click sur une pièce
	$("div#listePieces > table tr.piece").live('click', function(e){
		var reference = $(this).find("td:first-child").html();
		var libelle = $(this).find("td:last-child").html();
		
		params = {};
		params['reference'] = reference;
		params['libelle']   = libelle;
		
		// Afichage du formulaire
		$.ajax({
			type: 'post',
			data: params,
			url: 'index.php?ajax=affichageFormulaireAjoutPieceCommande',
			complete: function(x){
				$('body').append(x.responseText);
				$("#confirmOverlay").hide().fadeIn('slow');
			}
		});
		
		
		
		$(this).fadeIn('fast', function() {
		    // Animation complete.
		});
	});
	
	// Ajout pièce environnement à la commande
	$("#ajoutPieceEnvironnement").live('click', function(e){
		
		// récupération des informations de la pièce à ajouter
		var reference = $("#confirmOverlay td#ajoutPieceCommandeReference").html();
		var libelle   = $("#confirmOverlay td#ajoutPieceCommandeLibelle").html();
		var quantite  = $("#confirmOverlay input#ajoutPieceCommandeQuantite").val();
		var potentiel = $("#confirmOverlay input#ajoutPieceCommandePj").val();
		
		var chaine = "";
		chaine += "<tr>\n";
		chaine += "<td>" + reference + "</td>\n";
		chaine += "<td>" + libelle + "</td>\n";
		chaine += "<td><input type='text' id='tablePiecePrincipaleQuantite' name='tablePiecePrincipaleQuantite' value='" + quantite + "' /></td>\n";
		chaine += "<td><input type='text' id='tablePiecePrincipalePotentiel' name='tablePiecePrincipalePotentiel' value='" + potentiel + "' /></td>\n";
		chaine += "<td class='clickable removable principal'></td>\n";
		chaine += "</tr>\n";
		
		// suppression du formulaire 
		$("#confirmOverlay").remove();
		
		// Ajout de la pièce dans la commande
		$("table#pieceEnvironnement tbody").append(chaine).hide().fadeIn('slow');
		
		
		// Ajout d'un champs caché pour la soumission du formulaire
		var value = reference + "--" + quantite + "--" + potentiel; 
		$('#piecesEnvironnementHidden').append("<input type='hidden' class='piecesEnv' name='piecesEnv[]' value='" + value + "' />");
		
		e.preventDefault();
	});
	
	
	// Ajout pièce principale à la commande
	$("#ajoutPiecePrincipale").live('click', function(e){
		
		// récupération des informations de la pièce à ajouter
		var reference = $("#confirmOverlay td#ajoutPieceCommandeReference").html();
		var libelle   = $("#confirmOverlay td#ajoutPieceCommandeLibelle").html();
		var quantite  = $("#confirmOverlay input#ajoutPieceCommandeQuantite").val();
		var potentiel = $("#confirmOverlay input#ajoutPieceCommandePj").val();
		
		var chaine = "";
		chaine += "<tr>\n";
		chaine += "<td>" + reference + "</td>\n";
		chaine += "<td>" + libelle + "</td>\n";
		chaine += "<td><input type='text' id='tablePieceEnvironementQuantite' name='tablePiecePrincipaleQuantite' value='" + quantite + "' /></td>\n";
		chaine += "<td><input type='text' id='tableEnvironnementPotentiel' name='tablePieceEnvironnementPotentiel' value='" + potentiel + "' /></td>\n";
		chaine += "<td class='clickable removable environnement'></td>\n";
		chaine += "</tr>\n";
		
		// suppression du formulaire 
		$("#confirmOverlay").remove();
		
		// Ajout de la pièce dans la commande
		$("table#piecePrincipales tbody").append(chaine).hide().fadeIn('slow');
		
		
		// Ajout d'un champs caché pour la soumission du formulaire
		var value = reference + "--" + quantite + "--" + potentiel; 
		$('#piecesPrincipalesHidden').append("<input type='hidden' class='piecesPrinc' name='piecesPrinc[]' value='" + value + "' />");
		
		e.preventDefault();
	});
	
	
	// Annulation de l'ajout de la pièce à la commande
	$("#annulerAjoutPieceCommande").live('click', function(e){
		$("#confirmOverlay").remove();
		e.preventDefault();
	});
	
	
	// Suppression de pièce principale
	$("tr.principale").live('click', function(e){

	})
	
	
	
	
	
	
   /**
    * Ajout d'une pièce globale  -------------------------------YOHAN--------------------------------
    */	
	
	
	
	
	
	
});