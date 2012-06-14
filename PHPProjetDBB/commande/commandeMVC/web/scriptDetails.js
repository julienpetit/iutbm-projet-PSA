function calculOneResteALivrer(e)
{
	var reste = 0;
	$.each($(e).find("input.quantite"), function(index, value){
		var quantite = $(value).val();
		if(quantite != "") reste +=  parseInt(quantite);
	});
	
	var quantiteRestante = parseInt($(e).prev().find("td.qte").html()) - reste;

	$(e).prev().find("td.resteALivrer").html(quantiteRestante);
}

function addColorResteALivrer()
{
	$.each($("tr.piece"), function(index, value){
		reste = $(value).find("td.resteALivrer").html();
		
		if(reste < 0)
		{
			$(value).find("td.resteALivrer").css("background-color", "red");
		}
		else 
			if(reste > 0)
			{
				$(value).find("td.resteALivrer").css("background-color", "green");
			}
			else 
			{
				$(value).find("td.resteALivrer").css("background-color", "blue");
			}
	});
}

function calculAllResteALivrer()
{
	$.each($("table .row_livraisons"), function(index, value){
		calculOneResteALivrer(value);
	});
	
	addColorResteALivrer();
}


function validerLesLivraisons()
{
	
	var noCommande = $('td#noCommande').html();
	
	livraisons = {};
	var i = 0;
	$.each($("table tr.piece"), function(index, value){

		var numPiece = $(value).find("td:first-child").html();
		
		
		$.each($(value).next().find("div.date_quantite"), function(key, val){
			var date = $(val).find("input.date").val();
			var quantite = $(val).find("input.quantite").val();
			
			if(date != "" && quantite != "")
			{
				console.log(i);
				livraisons[i++] = {
						'numPiece' : numPiece,
						'date' 	: date,
						'quantite' : quantite
				};
			}
		});

	});
	
	console.log()
	$.ajax({
		type: 'post',
		data: {
			'noCommande': noCommande,
			'livraisons': livraisons
		},
		url: 'index.php?ajax=ajoutLivraisons',
		complete: function(x){
			$('body').append(x.responseText);
			console.log("complete");
			calculAllResteALivrer()
		}
	});
}

$(document).ready(function() {
	$(function() {
		$('.date' ).datepicker({
			dateFormat: 'dd/mm/yy'		
		});
	})
	calculAllResteALivrer();
	
	
	$("a#validerLivraisons").click(function(e){
		
		validerLesLivraisons();
		console.log("click");
		e.preventDefault();
	});
});