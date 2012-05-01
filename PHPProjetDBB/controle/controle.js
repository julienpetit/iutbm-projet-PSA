function showRef(str){ 
				if (str.length==0){ 
					document.getElementById("txtRef").innerHTML=""; 
					return; 
				} 
				xmlhttp=new XMLHttpRequest(); 
				xmlhttp.onreadystatechange=function(){   
					if (xmlhttp.readyState==4 && xmlhttp.status==200)       
						document.getElementById("txtRef").innerHTML=    
						xmlhttp.responseText; 
					} 
				xmlhttp.open("GET","getref.php?ref="+str,true); 
				xmlhttp.send(); 
}
			



function verifierRef(reference){

	
	var expression = /^([A-Za-z0-9]){10}$/;
	var ref = document.getElementById(reference).value;
	var reff = document.getElementById(reference);

	var couleur = new Array("#FF0000","#000000");
	
	
	if(ref=="")
	{
		
		reff.style.color=couleur[0];
		alert('Reference vide');
        document.getElementById(ref).focus();
	}
	else if(expression.exec(ref) == null)
	{
		 
		  reff.style.color=couleur[0];
		  alert('Reference non valide, doit etre une suite alphanumerique de 10 caracteres');
        document.getElementById(ref).focus();
	}
	else
	{
		  reff.style.color=couleur[1];
        
	}
}


function verifierQuant(quantite){
var qte = document.getElementById(quantite).value;
var qtee = document.getElementById(quantite);
var couleur = new Array("#FF0000","#000000");

	if (qte=="") {
			qtee.style.color=couleur[0];
        }
		
	else if (isNaN(qte)){
           
			qtee.style.color=couleur[0];
        }
        else {
		   qtee.style.color=couleur[1];
        }
}

function alertQuant(qte, i) {

var val = document.getElementById(qte).value;

		if (val=="") {
			alert('Quantite vide');
        }
		
	else if (isNaN(val)){
			alert('Quantite non valide');
        }
}

function verifierDate(date){

	var expression = /^([0-9]{2})([\-])([0-9]{2})\2([0-9]{4})$/;

	var valeur = document.getElementById(date).value;
	var valeurr = document.getElementById(date);
	var couleur = new Array("#FF0000","#000000");
	
	   
		var amin=1000; // année mini
		var amax=3000; // année maxi
		var separateur="-"; // separateur entre jour/mois/annee
		var j=(valeur.substring(0,2));
		var m=(valeur.substring(3,5));
		var a=(valeur.substring(6));
		var ok=1;
		valeurr.style.color=couleur[1];
		
		if(valeur==""){
			alert("Le champs est vide");
			valeurr.style.color=couleur[0];
		}
		else if(expression.exec(valeur) == null) {
			alert("le format n'est pas valide ");
			valeurr.style.color=couleur[0];
		}
		else if ( ((isNaN(j))||(j<1)||(j>31)) && (ok==1) ) {
			alert("Le jour n'est pas correct."); ok=0;
			valeurr.style.color=couleur[0];
		}
		else if ( ((isNaN(m))||(m<1)||(m>12)) && (ok==1) ) {
			alert("Le mois n'est pas correct."); ok=0;
			valeurr.style.color=couleur[0];
		}
		else if ( ((isNaN(a))||(a<amin)||(a>amax)) && (ok==1) ) {
			alert("L'année n'est pas correcte."); ok=0;
			valeurr.style.color=couleur[0];
		}
		else if ( ((valeur.substring(2,3)!=separateur)||(valeur.substring(5,6)!=separateur)) && (ok==1) ) {
			alert("Les séparateurs doivent être des "+separateur); ok=0;
			valeurr.style.color=couleur[0];
		}
		else if (ok==1) {
			var d2=new Date(a,m-1,j);
			j2=d2.getDate();
			m2=d2.getMonth()+1;
			a2=d2.getFullYear();
			if (a2<=100) {a2=1900+a2}
			if ( (j!=j2)||(m!=m2)||(a!=a2) ) {
				alert("La date "+valeur+" n'existe pas !");
				valeurr.style.color=couleur[0];
				ok=0;
			}
		}		
}

function verifierTel(tel){
	var expression = /^0[1-9]([-. ]?[0-9]{2}){4}$/;
	
	var valeur = document.getElementById(tel).value;
	var valeurr = document.getElementById(tel);
	var couleur = new Array("#FF0000","#000000");
	
	valeurr.style.color=couleur[1];
	
	if(valeur==""){
			alert("Le champs est vide");
			valeurr.style.color=couleur[0];
		}
		else if(expression.exec(valeur) == null) {
			alert("le format tel est pas valide");
			valeurr.style.color=couleur[0];
		}
}
function isEmail (email_utilisateur) {
        if (!email_utilisateur.match('^[-_\.0-9a-zA-Z]{1,}@[-_\.0-9a-zA-Z]{1,}[\.][0-9a-zA-Z]{2,}$')) {
            alert('test email invalide ');                
            return false;
        }
        
}

function testEmail(email_utilisateur)
{

    if(isEmail(email_utilisateur) ) {
        document.getElementById("icoErr").style.display = "none";
        document.getElementById("icoOk").style.display = "block";
    } else {
        document.getElementById("icoErr").style.display = "block";
        document.getElementById("icoOk").style.display = "none";
    }
}
