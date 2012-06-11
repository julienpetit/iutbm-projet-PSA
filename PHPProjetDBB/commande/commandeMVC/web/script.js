$(document).ready(function() {

	
	/**
	 * Soumission du formulaire
	 */
	$("#formulaire").submit(function(e){
		var valide = true; 
		if(!verifieMotifCommande()) { valide = false; }
		if(!verifieEntiteCommande()) { valide = false; }
		if(!verifieNoDossier()) { valide = false; }
		if(!valide) return false;
		
		ajoutChampsCachesSoumission();
	});
	
	
	/**
	 * Reset du formulaire
	 */
	$("#cancel").click(function(e){
		// Mise par défaut de la liste déroulante "motif du dossier" :
		selectMotif = $("#ReferenceDossierCommandeMasse");
		selectMotif.val("0");
		
		if(selectMotif.parent().find(".error-form").length > 0){
			selectMotif.parent().find(".error-form").remove();		
		}
		
		
		// Suppression des pièces selectonnées
		$('#pieceEnvironnement > tbody > tr').each(function(i, value){
			reference = $(value).find("td:first-child").html();
			supprimerPieceCommande(reference);
		});

		$('#piecePrincipales > tbody > tr').each(function(i, value){
			reference = $(value).find("td:first-child").html();
			supprimerPieceCommande(reference);
		});
		
		// Mise à jour du widget pièces disponibles
		$("input#recherchePiece").val("");
		majRechercheWidgetPiecesDispo("");
		addClassSelectedPiecesDispo();
		
		
		// Mise par défaut des responsable
		select = $("#EntiteCM");
		select.val("0");
		
		if(select.parent().find(".error-form").length > 0){
			select.parent().find(".error-form").remove();		
		}
		$("#CAImpute").val("");
	});
	
	
   /**
    * Widget Pièces ----------------------------------------------------------------------------------------
    */
	
	// Recherche de pièces
	/**
	 * on affiche la nouvelle liste de pièce disponible lors de la modification du champs de recherche de pièces disponibles
	 */
	$("input#recherchePiece").keyup(function(){
		var chaine = $('input#recherchePiece').val();
		
		majRechercheWidgetPiecesDispo(chaine);
		
		addClassSelectedPiecesDispo();
		
	});
	
	
	/*
	 * Ajout d'une pièce à la commande  -----------------------------------------------------------------------
     */

	/**
	 * Lors du click sur une pièce, on affiche un formulaire de validation de la pièce pour connaître :
	 * Quantité
	 * Potentiel / jours
	 * Référence
	 * Libellé
	 * Pièce principale / environnement
	 */
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
	
	/**
	 * Click sur ajouter la pièce d'environnement à la commande sur le formulaire précédent
	 */
	$("#ajoutPieceEnvironnement").live('click', function(e){
		
		// récupération des informations de la pièce à ajouter
		var reference = $("#confirmOverlay td#ajoutPieceCommandeReference").html();
		var libelle   = $("#confirmOverlay td#ajoutPieceCommandeLibelle").html();
		var quantite  = $("#confirmOverlay input#ajoutPieceCommandeQuantite").val();
		
		var chaine = "";
		chaine += "<tr>\n";
		chaine += "<td>" + reference + "</td>\n";
		chaine += "<td>" + libelle + "</td>\n";
		chaine += "<td><input type='text' id='tablePiecePrincipaleQuantite' name='tablePiecePrincipaleQuantite' value='" + quantite + "' /></td>\n";
		chaine += "<td class='clickable removable principale'></td>\n";
		chaine += "</tr>\n";
		
		// suppression du formulaire 
		$("#confirmOverlay").remove();
		
		// Ajout de la pièce dans la commande
		$("table#pieceEnvironnement tbody").append(chaine).hide().fadeIn('slow');
		
		addClassSelectedPiecesDispo();
		e.preventDefault();
	});
	
	
	/**
	 * Click sur ajouter la pièce principale à la commande sur le formulaire précédent
	 */
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
		chaine += "<td><input type='text' class='tablePieceEnvironementQuantite' name='tablePiecePrincipaleQuantite' value='" + quantite + "' /></td>\n";
		chaine += "<td><input type='text' class='tableEnvironnementPotentiel' name='tablePieceEnvironnementPotentiel' value='" + potentiel + "' /></td>\n";
		chaine += "<td class='clickable removable principale'></td>\n";
		chaine += "</tr>\n";
		
		// suppression du formulaire 
		$("#confirmOverlay").remove();
		
		// Ajout de la pièce dans la commande
		$("table#piecePrincipales tbody").append(chaine).hide().fadeIn('slow');
		
		
		addClassSelectedPiecesDispo();
		e.preventDefault();
	});
	
	
	/**
	 * Click sur annuler la pièce sur le formulaire précédent
	 */
	$("#annulerAjoutPieceCommande").live('click', function(e){
		$("#confirmOverlay").remove();
		e.preventDefault();
	});
	
	
	/**
	 * Click sur supprimer une pièce de la commande
	 */
	$("td.principale").live('click', function(e){
		
		reference = $(this).parent().find("td:first-child").html()
		supprimerPieceCommande(reference);
		
		addClassSelectedPiecesDispo();
	});
		
   /**
    * Ajout d'une pièce globale  -------------------------------YOHAN--------------------------------
    */	
	$("div#listePieces > h3 > span > a").live('click',function(e){
		
		$.ajax({
			type: 'post',
			url: 'index.php?ajax=affichageFormulaireAjoutPiece',
			complete: function(x){
				$('body').append(x.responseText);
				$("#confirmOverlay").hide().fadeIn('slow');
			}
		});
		e.preventDefault();
		
		
		
});
	/**
	 * Click sur annuler la pièce sur le formulaire précédent
	 */
	$("#annulerAjoutPiece").live('click', function(e){
		$("#confirmOverlay").remove();
		e.preventDefault();
	});
	
	/**
	 * Click sur ajouter la pièce sur le formulaire précédent
	 */
	$("#ajoutNouvellePiece").live('click', function(e){
		var reference=$("#newReference").val();
		var libelle=$("#newLibelle").val();

		$.ajax({
			type: 'post',
			url: 'index.php?ajax=affichageFormulaireAjoutPiece',
			complete: function(x){
				$('body').append(x.responseText);
				$("#confirmOverlay").hide().fadeIn('slow');
			}
		});

		
		
		e.preventDefault();
	});
	
	
	
/*
 * Global functions   ----------------------------------------------------------
 */


/**
 * Affiche un icone "coché" à toutes les pièces qui ont étés ajoutées à la commande dans la liste des pièces disponibles.
 */
function addClassSelectedPiecesDispo(){
	// création d'une liste des pièces ajoutées dans la commande
	pieces = new Array();
	
	$('#pieceEnvironnement > tbody > tr').each(function(i, value){
		pieces.push($(value).find("td:first-child").html());
	});
	
	$('#piecePrincipales > tbody > tr').each(function(i, value){
		pieces.push($(value).find("td:first-child").html());
	});
	
	// Parcours de la liste des pièces disponibles et ajout de classe "selected" si la pièce à été selectionnée
	$('#listePieces table > tbody > tr.piece').each(function(i, value){
		$(value).find('td:last-child').removeClass('selected');
		if($.inArray($(value).find("td:first-child").html(), pieces) != -1){
			$(value).find('td:last-child').addClass('selected');
		}
	});
};

/**
 * Supprime la ligne de la pièce dont la référence est passée en parametre dans le tableau de pièces
 * @param noPiece
 */
function supprimerPieceCommande(noPiece){
	
	// Suppression de la ligne dans les tableaux de pièces 
	$('#pieceEnvironnement > tbody > tr').each(function(i, value){
		reference = $(value).find("td:first-child");
		if(reference.html() == noPiece) {
			reference.parent().fadeOut().remove();
		}
	});
	$('#piecePrincipales > tbody > tr').each(function(i, value){
		reference = $(value).find("td:first-child");
		if(reference.html() == noPiece) {
			reference.parent().fadeOut().remove();
		}
	});
	
};

/**
 * récupere les valeurs des pièces dans le tableau et les convertis en champs caché pour pouvoir les récupèrer lors de la soumission du formulaire
 */
function ajoutChampsCachesSoumission(){
	$('#pieceEnvironnement > tbody > tr').each(function(i, value){
		reference = $(value).find("td:first-child").html();
		quantite = $(value).find("td:nth-child(3) > input").val();
		
		var value = reference + "--" + quantite; 
		$('#piecesEnvironnementHidden').append("<input type='hidden' class='piecesEnv' name='piecesEnv[]' value='" + value + "' />");

	});

	$('#piecePrincipales > tbody > tr').each(function(i, value){
		reference = $(value).find("td:first-child").html();
		quantite = $(value).find("td:nth-child(3) > input").val();
		potentiel = $(value).find("td:nth-child(4) > input").val();
		
		var value = reference + "--" + quantite + "--" + potentiel; 
		$('#piecesPrincipalesHidden').append("<input type='hidden' class='piecesPrinc' name='piecesPrinc[]' value='" + value + "' />");

	});
	
};

/**
 * Met à jour la liste des pièces disponible en fonction d'un motif de recherche
 */
function majRechercheWidgetPiecesDispo(chaine){
	params = {};
	params['chaine'] = chaine;

	$.ajax({
		type: 'post',
		url: 'index.php?ajax=recherchePieces',
		data: params,
		beforeSend: function(){
			// Affichage du loader
			$('div#listePieces > input').toggleClass('loader');
		},
		async: false,
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
};

/*
 * Vérifie qu'une valeur à été choisie dans la liste déroulante motif du dossier. return true si valide.
 * Dans le cas contraire, affichage d'un message + return false
 */
function verifieMotifCommande(){
	selectMotif = $("#ReferenceDossierCommandeMasse");

	if(selectMotif.val() == "0"){
		if(selectMotif.parent().find(".error-form").length == 0){
			selectMotif.parent().append("<span class='error-form'>Veuillez choisir un motif</span>");
			
		}
		return false;
	}
	else {
		if(selectMotif.parent().find(".error-form").length > 0){
			selectMotif.parent().find(".error-form").remove();		
		}
		return true;
	}
	
}



/*
 * Vérifie qu'une valeur à été choisie dans la liste déroulante entité. return true si valide.
 * Dans le cas contraire, affichage d'un message + return false
 */
function verifieEntiteCommande(){
	selectEntite = $("#EntiteCM");

	if(selectEntite.val() == "0"){
		if(selectEntite.parent().find(".error-form").length == 0){
			selectEntite.parent().append("<span class='error-form'>Veuillez choisir une entité</span>");
		}
		return false;
	}
	else {
		if(selectEntite.parent().find(".error-form").length > 0){
			selectEntite.parent().find(".error-form").remove();		
		}
		return true;
	}
}

/*
 * Vérifie que le champs NoDossier est rempli et est un nombre. return true si valide.
 * Dans le cas contraire, affichage d'un message + return false
 */
function verifieNoDossier(){
	champs = $("input#noDossier");
	if(isNaN(champs.val()) || champs.val() == "") {
		if(champs.parent().find(".error-form").length == 0){
			champs.parent().append("<span class='error-form'>Veuillez entrez un numéro de dossier</span>");
		}
		return false;
	}
	else {
		if(champs.parent().find(".error-form").length > 0){
			champs.parent().find(".error-form").remove();		
		}
		return true;
	}
}
});
