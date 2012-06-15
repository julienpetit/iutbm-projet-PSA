function Change(str)
{
	 /*====== Ajout des caractéristiques disabled et readonly ======*/
   $("#numCA").val(str); //fonction affichant le CA imputé
}
    
function pieces_fournies(str) // fonction qui envoie l'id du fournisseur a la page pieces_fournies.php qui va retourner les pièces que fournies le fournisseur
{
    xmlhttp=new XMLHttpRequest();

            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp2.status==200)
                    {
                        document.getElementById('pieces_fournie').innerHTML=xmlhttp.responseText;  
                        
                        document.getElementById('pieces_fournie').style.display="block";
                    }
            }
            xmlhttp.open("GET","traitement/pieces_fournies.php?id_fournisseur="+str,true);
            xmlhttp.send();
   
}

function mode_ref_vehicule(str) // fonction qui envoie l'id_fournisseur a la page mode_ref_vehicule.php qui va retourner VIS ou OF dans un label.
{
    xmlhttp2=new XMLHttpRequest();

            xmlhttp2.onreadystatechange=function()
            {
                if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
                    {
                        document.getElementById('mode_ref_vehicule').innerHTML=xmlhttp2.responseText;
                        
                        
                    }
            }
            xmlhttp2.open("GET","traitement/mode_ref_vehicule.php?id_fournisseur="+str,true);
            xmlhttp2.send();
    
}

function Change1(str)
{
	// fonction qui affiche le code silouhette
	$("#codesil").val(str);
                                     
}

function afficher(){ // fonction permettant d'afficher une ligne suplémentaire dans la page commande de masse
     var clique
     var r = document.getElementById("ReferenceCM_pp2");
     var d = document.getElementById("DesignationCM_pp2");
     var q = document.getElementById("QuantiteCM_pp2");
     var p = document.getElementById("PotentielCM_pp2");
     var plus = document.getElementById("+");
     var espace = document.getElementById("espace");

     if (r.style.display == "none")
     r.style.display = "block";
       
	


     if (d.style.display == "none")
     d.style.display = "block";
    


     if(q.style.display == "none")
     q.style.display="block";
	
	

     if(p.style.display == "none")
     p.style.display = "block";
	

     
	plus.style.display="none";
	espace.style.visibility="block";
	
 }


function afficher2(){// fonction permettant d'afficher une ligne suplémentaire dans la page commande de masse

     var r2 = document.getElementById("ReferenceCM_pe2");
     var d2 = document.getElementById("DesignationCM_pe2");
     var q2 = document.getElementById("QuantiteCM_pe2");
 
 var bouton = document.getElementById("plus");
 var bouton2 = document.getElementById("plus2");
   
     if (r2.style.display == "none")
     r2.style.display = "block";
    
     if (d2.style.display == "none")
     d2.style.display = "block";
     

     if(q2.style.display == "none")
     q2.style.display="block";

     

     bouton.style.display = "none";
     bouton2.style.display = "block";
    


 }

function afficher3(){// fonction permettant d'afficher une ligne suplémentaire dans la page commande de masse

     var r3 = document.getElementById("ReferenceCM_pe3");
     var d3 = document.getElementById("DesignationCM_pe3");
     var q3 = document.getElementById("QuantiteCM_pe3");
     var bouton2 = document.getElementById("plus2");
 
   
     if (r3.style.display == "none")
     r3.style.display = "block";
    
     if (d3.style.display == "none")
     d3.style.display = "block";
     

     if(q3.style.display == "none")
     q3.style.display="block";

    

	bouton2.style.display = "none";
	
}

function delete_ref1() 
{
    
            str = document.getElementById('').value;
            xmlhttp3=new XMLHttpRequest();

            xmlhttp3.onreadystatechange=function()
            {
                if (xmlhttp3.readyState==4 && xmlhttp3.status==200)
                    {
                        document.getElementById('etat').innerHTML=xmlhttp3.responseText;
                        
                      
                    }
            }
            xmlhttp3.open("GET","traitement/etat.php?num_commande="+str,true);
            xmlhttp3.send();
    
    
    
}


function etat()
{
            str = document.getElementById('numcom').value;
            xmlhttp4=new XMLHttpRequest();

            xmlhttp4.onreadystatechange=function()
            {
                if (xmlhttp4.readyState==4 && xmlhttp4.status==200)
                    {
                        document.getElementById('etat').innerHTML=xmlhttp4.responseText;
                        
                      
                    }
            }
            xmlhttp4.open("GET","traitement/etat.php?num_commande="+str,true);
            xmlhttp4.send();
}

function toMenu(msg){
	alert(msg);
	document.location.href="../accueil.php";	
}

/*
 * Gestion des erreur de formulaire
 * 
 */

$(document).ready(function() {

	
	/**
	 * Soumission du formulaire
	 */
	$("#formulaire").submit(function(e){
		var valide = true; 

		if(!verifieDesignation()) { valide = false; }
		if(!verifieFournisseur()) { valide = false; }
		if(!verifieRef()) { valide = false; }
		if(!verifieQuantite()) { valide = false; }
		if(!verifieSilhouette()) { valide = false; }
		if(!verifieEntite()) { valide = false; }
//		if(!verifieNoDossier()) { valide = false; }
		if(!valide) return false;
	});
	
	
	/* TEST CHAMPS DE TEXTE
	 * Vérifie que le champs désignation est rempli et est un nombre. return true si valide.
	 * Dans le cas contraire, affichage d'un message + return false
	 */
	function verifieDesignation(){
		champs = $("input#des");
		if(isNaN(champs.val()) || champs.val() == "") {
			if(champs.parent().find(".error-form").length == 0){
				champs.parent().append("<span class='error-form'>Veuillez entrez un numéro de désignation</span>");
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
	
	/* TEST CHAMPS DE TEXTE
	 * Vérifie que le champs référence est rempli et est une suite de 10 caractères alphanumériques. return true si valide.
	 * Dans le cas contraire, affichage d'un message + return false
	 */
	function verifieRef(){
		champs = $("input#ref");
		if(champs.val() == "" || champs.val().length != 10) {
			if(champs.parent().find(".error-form").length == 0){
				champs.parent().append("<span class='error-form'>Veuillez entrez une suite de 10 caracteres alphanumériques</span>");
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
	
	/* TEST CHAMPS DE TEXTE
	 * Vérifie que le champs quantité est rempli et est un nombre. return true si valide.
	 * Dans le cas contraire, affichage d'un message + return false
	 */
	function verifieQuantite(){
		champs = $("input#quant");
		if(isNaN(champs.val()) || champs.val() == "") {
			if(champs.parent().find(".error-form").length == 0){
				champs.parent().append("<span class='error-form'>Veuillez entrer un entier pour la quantité </span>");
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
	
	/* TEST CHAMPS DE LISTE DEROULANTE
	 * Vérifie que le champs désignation est rempli et est un nombre. return true si valide.
	 * Dans le cas contraire, affichage d'un message + return false
	 */
	function verifieFournisseur(){
		selectEntite = $("#four");

		if(selectEntite.val() == "0"){
			if(selectEntite.parent().find(".error-form").length == 0){
				selectEntite.parent().append("<span class='error-form'>Veuillez choisir un fournisseur</span>");
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
	
	/* TEST CHAMPS DE LISTE DEROULANTE
	 * return true si valide.
	 * Dans le cas contraire, affichage d'un message + return false
	 */
	function verifieSilhouette(){
		selectEntite = $("#vehicule");

		if(selectEntite.val() == "0"){
			if(selectEntite.parent().find(".error-form").length == 0){
				selectEntite.parent().append("<span class='error-form'>Veuillez choisir une silhouette</span>");
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
	
	/* TEST CHAMPS DE LISTE DEROULANTE
	 * return true si valide.
	 * Dans le cas contraire, affichage d'un message + return false
	 */
	function verifieEntite(){
		selectEntite = $("#nomca");

		if(selectEntite.val() == "0"){
			if(selectEntite.parent().find(".error-form").length == 0){
				selectEntite.parent().append("<span class='error-form'>Veuillez choisir une entite</span>");
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
	
});