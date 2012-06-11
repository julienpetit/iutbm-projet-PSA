function Verifier(champ){
	var verif = document.getElementById(champ).value;
	var champs_vide = new Boolean();
	if(verif==""){
		champs_vide = false;
	}
	else{

	champs_vide = true;
	}
	return champs_vide;
}

function Verifier_champs(champs)
{
var formulaire_pret = new Boolean();
formulaire_pret= true;


for (var i=0;i<champs.length;i++) {

	var Verif_formulaire = Verifier(champs[i]);
	if(Verif_formulaire == false) {
		formulaire_pret = false;
		var stock= champs[i];
		 alert("Attention le champ "+ stock +" est vide.");
	}
	} 
 return formulaire_pret;
}
