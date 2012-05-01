$(document).ready(function() {
   /**
    * Widget Pièces
    */
	
	// Recherche de pièces
	$("input#recherchePiece").keyup(function(){
		var chaine = $('input#recherchePiece').val();
		console.log(chaine);
		
		params = {};
		params['chaine'] = chaine;

		// On vérifie si le classement n'existe pas
		$.ajax({
			type: 'post',
			url: 'index.php?ajax=recherchePieces',
			data: params,
			complete: function(x){
				if(x.responseText != ""){
					$('div#listePieces > table > tbody').html(x.responseText);
				}
				else {
					$('div#listePieces > table > tbody').html("<span id='pasTrouve'>Aucune pièce trouvée.</span>");
				}
			}
		});
	});
	
	
	/*
	 * Ajout d'une pièce à la commande
	 */ 
	// click sur une pièce
	$("div#listePieces > table tr.piece").live('click', function(e){
		var reference = $(this).find("td:first-child").html();
		var libelle = $(this).find("td:last-child").html();
		console.log("click ! " + reference + " - " + libelle);
		
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
		chaine += "<td>" + quantite + "</td>\n";
		chaine += "<td>" + potentiel + "</td>\n";
		chaine += "</tr>\n";
		
		// suppression du formulaire 
		$("#confirmOverlay").remove();
		
		// Ajout de la pièce dans la commande
		$("table#piecePrincipales tbody").append(chaine).hide().fadeIn('slow');
		
		e.preventDefault();
	});
	
	
	// Annulation de l'ajout de la pièce à la commande
	$("#annulerAjoutPieceCommande").live('click', function(e){
		$("#confirmOverlay").remove();
		e.preventDefault();
	});
	
	
});