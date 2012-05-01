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
			}
		});
	});
	
	
	
});