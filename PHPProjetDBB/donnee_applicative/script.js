///////////////////////CHOIX DE LA TABLE///////////////////////
function choix_table(num){

			xmlhttp = new XMLHttpRequest();
			if(num.length==0){
				document.getElementById("page").innerHTML="";
				return;
			}
			
			xmlhttp.onreadystatechange=function(){
				if(xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById("page1").innerHTML=xmlhttp.responseText;
				}
			}
			xmlhttp.open("POST","afficher_table.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("list_value="+num);
			
}
///////////////////////PIECE//////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////Formulaire d'ajout///////////////////////////////////////
function Form_ajout_piece()
{
	xmlhttp=new XMLHttpRequest();

	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    		{
    			document.getElementById("page1").innerHTML=xmlhttp.responseText;
    		}
  	}
	xmlhttp.open("GET","form_ajout_piece.php",true);
	xmlhttp.send(null);
}
///////////////////////ajout////////////////////////////////////////////////////
function ajout_piece(){
	
	xmlhttp = new XMLHttpRequest();

	var designation_piece= document.getElementById("designation_piece").value;	
	var reference_piece= document.getElementById("reference_piece").value;
	if((designation_piece.length==0)||(reference_piece.length==0)){
		alert("Un ou plusieurs champs sont vides");
		return;
	}
			
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("page1").innerHTML=xmlhttp.responseText;
			choix_table('piece');
		}
	}
	xmlhttp.open("POST","ajout_piece.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("reference="+reference_piece+"&designation="+designation_piece);

	alert("La piece a bien été ajoutée");
			
}
///////////////////////Formulaire de modification///////////////////////////////
function Modifier_piece(str)
{
			xmlhttp=new XMLHttpRequest();

			xmlhttp.onreadystatechange=function()
  			{
  				if (xmlhttp.readyState==4 && xmlhttp.status==200)
  		 		{
    			document.getElementById("page1").innerHTML=xmlhttp.responseText;
   			}
  			}
			xmlhttp.open("POST","modif_piece.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("noPiece="+str);
}
///////////////////////sauvegarde de modification///////////////////////////////
function Sauvegarde_piece()
{
	var noPiece = document.getElementById('reference_piece').value;
	var libellePiece = document.getElementById('designation_piece').value;

	xmlhttp=new XMLHttpRequest();

	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    		{
   			document.getElementById("page1").innerHTML=xmlhttp.responseText;
    			choix_table('piece');
   		}
  	}
	xmlhttp.open("POST","sauvegarde_piece.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("noPiece="+noPiece+"&libellePiece="+libellePiece);

}
///////////////////////Suppression////////////////////////////////////////////
function suppression_piece(id_piece){

	xmlhttp = new XMLHttpRequest();
	if(id_piece==0){
		document.getElementById("page").innerHTML="";
		return;
	}
	
	if(confirm("Voulez vous supprimer la piece "+id_piece+" ?")){		
		xmlhttp.onreadystatechange=function(){
			if(xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("page1").innerHTML=xmlhttp.responseText;
				choix_table('piece');
			}
		}
		xmlhttp.open("POST","suppression_piece.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("id="+id_piece);
	}
}
///////////////////////SILOUHETTE//////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////Formulaire d'ajout///////////////////////////////////////
function Form_ajout_silouhette()
{
	xmlhttp=new XMLHttpRequest();

	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    		{
    			document.getElementById("page1").innerHTML=xmlhttp.responseText;
    		}
  	}
	xmlhttp.open("GET","form_ajout_silouhette.php",true);
	xmlhttp.send(null);
}
///////////////////////ajout////////////////////////////////////////////////////
function ajout_silouhette(){
	
	xmlhttp = new XMLHttpRequest();
	
	var code_silouhette= document.getElementById("code_silouhette").value;	
	var libelle_silouhette= document.getElementById("libelle_silouhette").value;
		
	if(code_silouhette.lenght==0 || libelle_silouhette.lenght==0){
		alert("Un ou plusieurs champs sont vides");
		return;
	}
			
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("page1").innerHTML=xmlhttp.responseText;
			choix_table('silouhette');
		}
	}
	xmlhttp.open("POST","ajout_silouhette.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("code="+code_silouhette+"&libelle="+libelle_silouhette);

	alert("La silouhette a bien été ajoutée");
			
}
///////////////////////Formulaire de modification///////////////////////////////
function Modifier_silouhette(str)
{
			xmlhttp=new XMLHttpRequest();

			xmlhttp.onreadystatechange=function()
  			{
  				if (xmlhttp.readyState==4 && xmlhttp.status==200)
  		 		{
    			document.getElementById("page1").innerHTML=xmlhttp.responseText;
   			}
  			}
			xmlhttp.open("POST","modif_silouhette.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("noSilouhette="+str);
}
///////////////////////sauvegarde de modification///////////////////////////////
function Sauvegarde_silouhette()
{
	var noSilouhette = document.getElementById('code_silouhette').value;
	var libelleSilouhette = document.getElementById('libelle_silouhette').value;

	xmlhttp=new XMLHttpRequest();

	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    		{
    			document.getElementById("page1").innerHTML=xmlhttp.responseText;
    			choix_table('silouhette');
    		}
  	}
	xmlhttp.open("POST","sauvegarde_silouhette.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("noSilouhette="+noSilouhette+"&libelleSilouhette="+libelleSilouhette);
}
///////////////////////Suppression//////////////////////////////////////////////
function suppression_silouhette(id_silouhette){

	xmlhttp = new XMLHttpRequest();
	if(id_silouhette==0){
		document.getElementById("page").innerHTML="";
		return;
	}
	
	if(confirm("Voulez vous supprimer la silouhette "+id_silouhette+" ?")){		
		xmlhttp.onreadystatechange=function(){
			if(xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("page1").innerHTML=xmlhttp.responseText;
				choix_table('silouhette');
			}
		}	
		xmlhttp.open("POST","suppression_silouhette.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");		
		xmlhttp.send("id="+id_silouhette);
	}
}
///////////////////////FOURNISSEUR//////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////Formulaire d'ajout///////////////////////////////////////
function Form_ajout_fournisseur()
{
	xmlhttp=new XMLHttpRequest();

	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    		{
    			document.getElementById("page1").innerHTML=xmlhttp.responseText;
    		}
  	}
	xmlhttp.open("GET","form_ajout_fournisseur.php",true);
	xmlhttp.send(null);
}
///////////////////////ajout////////////////////////////////////////////////////
function ajout_fournisseur(){
	
	xmlhttp = new XMLHttpRequest();
	
	var cofor= document.getElementById("cofor").value;
	var nom_fournisseur= document.getElementById("nom_fournisseur").value;	
	var nom_dest_commande= document.getElementById("nom_dest_commande").value;	
	var code_mod_ref_vehicule= document.getElementById("code_mod_ref_vehicule").value;		
	var approvisionne= document.getElementById("approvisionne").value;
	var mail_dest=document.getElementById("mail_dest_commande").value;
    var mail_copie=document.getElementById("mail_copie_commande").value;
    
    
	if(nom_fournisseur.length==0 || cofor.length==0 || nom_dest_commande.lenght==0 || code_mod_ref_vehicule.lenght==0 || approvisionne==0 ||  mail_dest==0 || mail_copie==0){
		alert("Un ou plusieurs champs sont vides");
		return;
	}
			
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("page1").innerHTML=xmlhttp.responseText;
			choix_table('fournisseur');
		}
	}
	xmlhttp.open("POST","ajout_fournisseur.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("nom="+nom_fournisseur+"&code="+cofor+"&nom_dest="+nom_dest_commande+"&code_mod="+code_mod_ref_vehicule+"&approvisionne="+approvisionne+"&mail_dest="+mail_dest+"&mail_copie="+mail_copie);

	alert("Le fournisseur a bien été ajouté");
			
}
///////////////////////Formulaire de modification///////////////////////////////
function Modifier_fournisseur(str)
{
			xmlhttp=new XMLHttpRequest();

			xmlhttp.onreadystatechange=function()
  			{
  				if (xmlhttp.readyState==4 && xmlhttp.status==200)
  		 		{
    			document.getElementById("page1").innerHTML=xmlhttp.responseText;
   			}
  			}
			xmlhttp.open("POST","modif_fournisseur.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("noFournisseur="+str);
}

///////////////////////sauvegarde de modification///////////////////////////////
function Sauvegarde_fournisseur()
{
	var code_mode_ref_vehicule = document.getElementById('code_mode_ref_vehicule').value;
	var nom_dest_commande = document.getElementById('nom_dest_commande').value;
	var cofor = document.getElementById('cofor').value;
	var nom_fournisseur = document.getElementById('nom_fournisseur').value;
	var id_fournisseur = document.getElementById('id_fournisseur').value;

	xmlhttp=new XMLHttpRequest();

	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    		{
    			document.getElementById("page1").innerHTML=xmlhttp.responseText;
    			choix_table('fournisseur');
    		}
  	}
	xmlhttp.open("POST","sauvegarde_fournisseur.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("code_mode_ref_vehicule="+code_mode_ref_vehicule+"&nom_dest_commande="+nom_dest_commande+"&cofor="+cofor+"&nom_fournisseur="+nom_fournisseur+"&id_fournisseur="+id_fournisseur);

}
///////////////////////Suppression//////////////////////////////////////////////
function suppression_fournisseur(id_fournisseur){

	xmlhttp = new XMLHttpRequest();
	if(id_fournisseur==0){
		document.getElementById("page").innerHTML="";
		return;
	}
	
	if(confirm("Voulez vous supprimer le fournisseur "+id_fournisseur+" ?")){		
		xmlhttp.onreadystatechange=function(){
			if(xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("page1").innerHTML=xmlhttp.responseText;
				choix_table('fournisseur');
			}
		}
		xmlhttp.open("POST","suppression_fournisseur.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("id="+id_fournisseur);
	}
}
///////////////////////UTILISATEUR//////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////Formulaire d'ajout///////////////////////////////////////
function Form_ajout_utilisateur()
{
	xmlhttp=new XMLHttpRequest();

	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    		{
    			document.getElementById("page1").innerHTML=xmlhttp.responseText;
    		}
  	}
	xmlhttp.open("GET","form_ajout_utilisateur.php",true);
	xmlhttp.send(null);
}
///////////////////////ajout////////////////////////////////////////////////////
function ajout_utilisateur(form){
	
	xmlhttp = new XMLHttpRequest();

	var code_utilisateur= document.getElementById("code_utilisateur").value;	
	var nom_utilisateur= document.getElementById("nom_utilisateur").value;
	var prenom_utilisateur= document.getElementById("prenom_utilisateur").value;	
	var service_utilisateur= document.getElementById("service_utilisateur").value;
	var no_telephone= document.getElementById("no_telephone").value;	
	var email_utilisateur= document.getElementById("email_utilisateur").value;	
	var mdp_utilisateur= document.getElementById("mdp_utilisateur").value;	
	var droit_utilisateur="";
	var nb_droits=0;
	for(i=0 ; i<document.getElementsByName("droit").length; i++){
		if(document.getElementsByName("droit")[i].checked){
			droit_utilisateur = droit_utilisateur+"&droit_"+nb_droits+"="+document.getElementsByName("droit")[i].value;
			nb_droits+=1;	
		}
	}
	
	if(code_utilisateur.length==0 || nom_utilisateur.length==0 || prenom_utilisateur.length==0 || service_utilisateur.length==0 || no_telephone.length==0 || email_utilisateur.length==0 || mdp_utilisateur.length==0 ){
		alert("Un ou plusieurs champs sont vides");
		return;
	}
			
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("page1").innerHTML=xmlhttp.responseText;
			choix_table('utilisateur');
		}
	}	
	
	xmlhttp.open("POST","ajout_utilisateur.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("code="+code_utilisateur+"&nom="+nom_utilisateur+"&prenom="+prenom_utilisateur+"&service="+service_utilisateur+"&tel="+no_telephone+"&email="+email_utilisateur+"&mdp="+mdp_utilisateur+"&nb_droits="+nb_droits+droit_utilisateur);

	alert("L'utilisateur a bien été ajouté");
			
}
///////////////////////Formulaire de modification///////////////////////////////
function Modifier_utilisateur(str)
{
			xmlhttp=new XMLHttpRequest();

			xmlhttp.onreadystatechange=function()
  			{
  				if (xmlhttp.readyState==4 && xmlhttp.status==200)
  		 		{
    			document.getElementById("page1").innerHTML=xmlhttp.responseText;
   			}
  			}
			xmlhttp.open("POST","modif_utilisateur.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("noUtilisateur="+str);
}
///////////////////////sauvegarde de modification///////////////////////////////
function Sauvegarde_utilisateur()
{
	var id_utilisateur= document.getElementById("id_utilisateur").value;	
	var nom_utilisateur= document.getElementById("nom_utilisateur").value;
	var prenom_utilisateur= document.getElementById("prenom_utilisateur").value;	
	var service_utilisateur= document.getElementById("service_utilisateur").value;
	var no_telephone= document.getElementById("no_telephone").value;	
	var email_utilisateur= document.getElementById("email_utilisateur").value;	
	var mdp_utilisateur= document.getElementById("mdp_utilisateur").value;	
	var droit_utilisateur="";
	var nb_droits=0;
	for(i=0 ; i<document.getElementsByName("droit").length; i++){
		if(document.getElementsByName("droit")[i].checked){
			droit_utilisateur = droit_utilisateur+"&droit_"+nb_droits+"="+document.getElementsByName("droit")[i].value;
			nb_droits+=1;	
		}
	}

	
	if(id_utilisateur.length==0 || nom_utilisateur.length==0 || prenom_utilisateur.length==0 || service_utilisateur.length==0 || no_telephone.length==0 || email_utilisateur.length==0){
		alert("Un ou plusieurs champs sont vides");
		return;
	}
			
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("page1").innerHTML=xmlhttp.responseText;
			choix_table('utilisateur');
		}
	}	
	
	xmlhttp.open("POST","sauvegarde_utilisateur.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("id="+id_utilisateur+"&nom="+nom_utilisateur+"&prenom="+prenom_utilisateur+"&service="+service_utilisateur+"&tel="+no_telephone+"&email="+email_utilisateur+"&mdp="+mdp_utilisateur+"&nb_droits="+nb_droits+droit_utilisateur);

	
	alert("L'utilisateur a bien été modifié");
}
///////////////////////Suppression//////////////////////////////////////////////
function suppression_utilisateur(id_utilisateur){
	
	xmlhttp = new XMLHttpRequest();
	if(id_utilisateur==0){
		document.getElementById("page").innerHTML="";
		return;
	}
	
	if(confirm("Voulez vous supprimer l'utilisateur "+id_utilisateur+" ?")){
		
		xmlhttp.onreadystatechange=function(){
			if(xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("page1").innerHTML=xmlhttp.responseText;
				choix_table('utilisateur');
			}
		}
		xmlhttp.open("POST","suppression_utilisateur.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("id="+id_utilisateur);
	}
}



































			
