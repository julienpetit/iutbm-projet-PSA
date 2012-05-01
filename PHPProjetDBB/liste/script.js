function affichage(requete){
		xmlhttp = new XMLHttpRequest();
						
			xmlhttp.onreadystatechange=function(){
				if(xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById("content").innerHTML=xmlhttp.responseText;
				}
			}
			xmlhttp.open("POST","affichage.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("req="+requete);
}


function critere(crit){

			xmlhttp = new XMLHttpRequest();
						
			xmlhttp.onreadystatechange=function(){
				if(xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById("date").innerHTML=xmlhttp.responseText;
				}
			}
			xmlhttp.open("POST","dates.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("choix_rech="+crit);
			
}

function choix_(choix){
	
if (choix == 'fournisseur')
var param = "&param="+document.getElementById('noFournisseur').value;
else if(choix == 'piece')
var param = "&param="+document.getElementById('noPiece').value;
else if(choix == 'silhouette')
var param = "&param="+document.getElementById('noSilhouette').value;
else if(choix == 'noCommande')	
var param = "&param="+document.getElementById('noCommande').value;	
else if(choix == 'typeCommande'){
	if(document.getElementById("unit").checked)
	var param = "&param=S";
	else if (document.getElementById("masse").checked)
	var param = "&param=M";
}
else if(choix == 'etatCommande'){
	if(document.getElementById("open").checked)
	var param = "&param=open";
	else if (document.getElementById("close").checked)
	var param = "&param=close";
}
else if(choix == 'date_creation'){
	if(document.getElementById("date1").value == "" && document.getElementById("date2").value == "")
		return;
	else 
		var param = "&param="+document.getElementById("date1").value+"&param2="+document.getElementById("date2").value;
}	
else if(choix == 'date_reception'){
	if(document.getElementById("date1").value == "" && document.getElementById("date2").value == "")
		return;	
	else 
		var param = "&param="+document.getElementById("date1").value+"&param2="+document.getElementById("date2").value;
}		
	
	
	
			xmlhttp = new XMLHttpRequest();
						
			xmlhttp.onreadystatechange=function(){
				if(xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById("content").innerHTML=xmlhttp.responseText;
				}
			}
			xmlhttp.open("POST","recherche.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("choix_rech="+choix+param);
}
