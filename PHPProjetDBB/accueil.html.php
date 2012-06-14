<?php header_html("GESTION DES COMMANDES",array("include/framework/foundation.css", "accueil.css"),array(), true); ?>
<script>
function addFermerAnnuler(elem, link)
{
	if(elem.hasClass("fermer"))
	{

		var box = "";
		box += "<div class='box_shadow absolute' id='confirmFermer' >";
		box += "<h3>Fermeture de la commande</h3>";
		box += "<p><label>Motif de la fermeture : <input id='motifFermeture' /></label></p>";
		box += "<p><a href='"+link+"' id='fermerCommande' class='small green nice button radius' >Fermer la commande</a><a id='cancel' class='small red nice button radius' >Retour</a></p>";
		box += "</div>"; 
		$("body").append(box);

		return true;
	}

	return false;
}


function verifierPresenceCommande()
{
	var champs = $("input#search_commande").val();
	if(champs != "")
	{
		var noCommande = champs;
		var retour = false;
		params = { 'noCommande' : champs };
				$.ajax({
					type: 'post',
					data: params,
					async: false,
					url: 'index.php?ajax=verifierPresenceCommande',
					complete: function(x){
						
						if(x.responseText == "1") 
						{
							retour = true;
						}
					}
				});
		}

		return retour;
	}

	$(document).ready(function(){
		$("TABLE td").mouseover(function(e){
			$("#txt").html($(this).attr("texte"));
			$("#txt").fadeIn("fast", function(){});
		});

		$("TABLE td").mouseout(function(e){
			$("#txt").html("");
			$("#txt").hide();
		}); 


		$('input#seach_commande').autocomplete ({
			source : function(request, callback)
			{
				var data = { term : request.term, type : 'nom' };
				$.ajax ({
					type: "post",
					url : "index.php?ajax=searchCommande",
					data : data,
					complete : function (xhr, result)
					{
						if (result != "success") return;
						var response = xhr.responseText;
						var noms = [];

						$(response).filter ("li").each(function ()
								{
							noms.push ($(this).text ());
								});
						callback (noms);
					}
				});
			}
		});

		/*
		 * Click sur une fonction nécessitant une commande
		 */
		$('a.link_clickable').click(function(e){
			
			var champs = $("#search_commande"); // no de la commande
			
			if(!verifierPresenceCommande()) {
				if(champs.parent().find(".error-form").length == 0){
					champs.parent().append("<p class='error-form' >Veuillez entrer un numéro de commande valide</p>");
				}
			}
			else {
				if(champs.parent().find(".error-form").length > 0){
					champs.parent().find(".error-form").remove();		
				}

				var link = $(this).attr("href")+champs.val();

				if(addFermerAnnuler($(this), link))
				{
					e.preventDefault();
					return;
				}
				
				document.location.href=link;
			}

			e.preventDefault();
		});


		$("#fermerCommande").live('click', function(e){

			var motif = $("#motifFermeture").val();
			var link = $(this).attr("href") + "&motif=" + motif;

			document.location.href=link;
			e.preventDefaut();
		});
		
	});

</script>

<div id='content_search'>
	<input type='text' id='search_commande' name='search_commande' placeholder='Rechercher une commmande' />
</div>
<center>
	<TABLE cellspacing="10px">
		<tr>
			<td texte="Passer une commande de pièces en flux synchrone"><a
				href="/commande/pieces_synchrone.php"><img class="onebutton" src="include/css/img/cmd_pieces.jpg"
					width="80" height="80" border="0" /> </a></td>
			<td texte="Passer une commande de masse"><a href="/commande/commandeMVC/?ajout"><img
					class="onebutton" src="include/css/img/cmd_masse.jpg" width="80"
					height="80" border="0" /> </a></td>
			<td texte="Visualiser une commande"><a href="/commande/commandeMVC/?visualiser=" class='link_clickable' ><img class="onebutton"
					src="include/css/img/visu_cmd.jpg" width="80" height="80"
					border="0" /> </a></td>
			<td texte="Modifier une commande"><a href="/commande/commandeMVC/?modifier=" class='link_clickable' ><img class="onebutton"
					src="include/css/img/modif_cmd.jpg" width="80" height="80"
					border="0" /> </a></td>
			<td texte="Annuler une commande"><a href="/commande/commandeMVC/?annuler=" class='link_clickable annuler' ><img class="onebutton"
					src="include/css/img/annul_cmd.jpg" width="80" height="80"
					border="0" /> </a></td>
		</tr>
		<tr>
			<td texte="Déclarer la réception d'une commande de pièce synchrone"><a
				href="" class='link_clickable'><img class="onebutton"
					src="include/css/img/reception_cmd.jpg" width="80" height="80"
					border="0" /> </a></td>
			<td texte="Déclarer des livraisons de pièces"><a href="/commande/commandeMVC/?details=" class='link_clickable'><img
					class="onebutton" src="include/css/img/livraison_cmd.jpg"
					width="80" height="80" border="0" /> </a></td>
			<td texte="Fermer une commande"><a href="/commande/commandeMVC/?fermer=" class='link_clickable fermer'><img class="onebutton"
					src="include/css/img/fermer_cmd.jpg" width="80" height="80"
					border="0" /> </a></td>
			<td texte="Lister des commandes"><a href="/liste/liste.php"><img class="onebutton"
					src="include/css/img/lister_cmd.jpg" width="80" height="80"
					border="0" /> </a></td>
			<td texte="Extraire des données"><a href="/exportation/export.php"><img class="onebutton"
					src="include/css/img/extraire_donnees.jpg" width="80" height="80"
					border="0" /> </a></td>
		</tr>
		<tr>
			<td texte="Mise à jour des données applicatives"><a href="/donnee_applicative/maj.php"><img
					class="onebutton" src="include/css/img/maj_donnees_app.jpg"
					width="80" height="80" border="0" /> </a></td>
			<td></td>
			<td></td>
			<td></td>
			<td texte="Quitter"><a href="/connexion/deconnexion.php"><img class="onebutton"
					src="include/css/img/quitter.jpg" width="80" height="80" border="0" />
			</a></td>
		</tr>
	</TABLE>
</center>


<div id="divtxt">
	<p id="txt"></p>
</div>

</div>
<?php footer_html(); ?>