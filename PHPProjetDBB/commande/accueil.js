function box(){
	document.getElementById('commande').style.display="block";          // ces deux fonctions permettent d'afficher ou non le champ de numéro de commande dans l'accueil
}  

function nobox(){
	document.getElementById('commande').style.display="none";
}

function choix_action(str){
	xmlhttp=new XMLHttpRequest();

		xmlhttp.onreadystatechange=function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                document.forms["accueil"].action=xmlhttp.responseText;
                document.forms["accueil"].submit();
                }
            }
            xmlhttp.open("GET","traitement/choix_page.php?num_commande="+str,true);
            xmlhttp.send();
}

function choix_action1(str){ // fonction qui permet d'envoyer les bon paramètre a la page "choix_page.php" pour bien rediriger depuis l'accueil.

    if(document.getElementById('accueil').option[0].checked==true){
             document.forms["accueil"].action="pieces_synchrone.php";
        }
    else if(document.getElementById('accueil').option[1].checked==true){
		document.forms["accueil"].action="commandeMVC/?ajout";
        }

    else if(document.getElementById('accueil').option[2].checked==true){
        document.forms["accueil"].action="traitement/choix_page.php?choix=2&num_commande="+str;
        }

    else if(document.getElementById('accueil').option[3].checked==true){
        document.forms["accueil"].action="commandeMVC/?modifier="+str;
        }

    else if(document.getElementById('accueil').option[4].checked==true){
        document.forms["accueil"].action="traitement/choix_page.php?choix=4&num_commande="+str;
        }

    else if(document.getElementById('accueil').option[5].checked==true){
        document.forms["accueil"].action="traitement/choix_page.php?choix=5&num_commande="+str;
        }

    else if(document.getElementById('accueil').option[6].checked==true){
        document.forms["accueil"].action="traitement/choix_page.php?choix=6&num_commande="+str;
        }

    else if(document.getElementById('accueil').option[7].checked==true){
        document.forms["accueil"].action="traitement/choix_page.php?choix=7&num_commande="+str;
        }

    else if(document.getElementById('accueil').option[8].checked==true){
        document.forms["accueil"].action="../liste/liste.php";
        }

    else if(document.getElementById('accueil').option[9].checked==true){
        document.forms["accueil"].action="../exportation/export.php";
        }

    else if(document.getElementById('accueil').option[10].checked==true){
        document.forms["accueil"].action="../donnee_applicative/maj.php";
        }
}

//fonction pour fermer la page (quitter l'application)
function quitter_appli(){
	void window.close() ;
}
