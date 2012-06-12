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

function critere2(crit){

	xmlhttp = new XMLHttpRequest();
				
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("date2").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("POST","dates.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("choix_rech="+crit);
	
}

function critere3(crit){

	xmlhttp = new XMLHttpRequest();
				
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("date3").innerHTML=xmlhttp.responseText;
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

function ajout(variable){

	xmlhttp = new XMLHttpRequest();

	//if(variable != 'envoi'){
		var param1 = document.getElementById("param1").value;
		var param2 = document.getElementById("param2").value;
		var param3 = document.getElementById("param3").value;
	
		var col1 = new Array;
		var col2 = new Array;
		var col3 = new Array;
	
		var tableau = new Array;
	
		tableau[0] = col1;
		tableau[1] = col2;
		tableau[2] = col3;
	
		if(param1 != ""){
			tableau[0][0] = param1;
			var donnee1 = variable;
			/*if(donnee1 == 'etatCommande'){
				//var open = document.getElementById('open');
				//var close = document.getElementById('close');
				if(document.getElementById('open').checked){
					var donnee1 = "open";
				}
				else{
					var donnee1 = "close";
				}
			}
			else if(donnee1 == 'typeCommande'){
				//var M = document.getElementById('masse');
				//var S = document.getElementById('unit');
					
				if(document.getElementById("masse").checked){
					var donnee1 = "M";
				}
				else{
					var donnee1 = "S"
				}
			}
			else if(donnee1 == 'date_creation'){
				var date_min = document.getElementById('date1_crea').value;
				var date_max = document.getElementById('date2_crea').value;
			
				if(date_min != "" && date_max == ""){
					var donnee1 = date_min;
				}
				else if(date_min == "" && date_max != ""){
					var donnnee1 = date_max;
				}
				else
					var donnee1 = "&date_min="+date_min+"&date_max="+date_max;
			}
			else if(donne1 == 'date_reception'){
				var date_min = document.getElementById('date1_recep').value;
				var date_max = document.getElementById('date2_recep').value;
			
				if(date_min != "" && date_max == ""){
					var donnee1 = date_min;
				}
				else if(date_min == "" && date_max != ""){
					var donnnee1 = date_max;
				}
				else
					donnee1 = "&date_min="+date_min+"&date_max="+date_max;
			}
			else{
				tableau[0][1] = donnee1;
			}*/
			alert(donnee1);
			document.getElementById("page2").style.display = "inline";
			document.getElementById("envoi").style.display = "inline";
		}
		else if(param1 != "" && param2 != ""){
			tableau[1][0] = param2;
			var donnee2 = variable;
			alert(donnee2);
			alert(tableau[1][0]);
			document.getElementById("page3").style.display = "inline";
		}
		else if(param1 != "" && param2 != "" && param3 != ""){
			tableau[2][0] = param3;
			var donnee3 = variable;
			alert(donnee3);
		}
	/*}
	else if(variable == 'envoi'){
		alert(tableau[0][0]);
		alert(tableau[1][0]);
		alert(tableau[2][0]);
	}*/
}