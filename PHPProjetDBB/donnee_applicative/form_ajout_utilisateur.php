<?php include('../connexion/_connexion.php'); mysql_query("SET NAMES UTF8");?>


<div id="myform" class="myform_uti">
    <form id="formulaire"  name="form" method="post" action="">
        <h1>Formulaire d'ajout</h1>
        <p>Vous pouvez ajouter un utilisateur</p>
<br /><br />



<label id="label" for="code_utilisateur">Identifiant utilisateur</label>
<input type="text" id="code_utilisateur" value=""/>
<br />


<label id="label" for="nom_utilisateur">Nom</label>
<input type="text" id="nom_utilisateur" value=""/>
<br />

<label id="label" for="prenom_utilisateur">Prenom</label>
<input type="text" id="prenom_utilisateur" value=""/>
<br />

<label id="label" for="service_utilisateur">Service</label>
<input type="text" id="service_utilisateur" value=""/>
<br />


<label id="label" for="no_telephone">Téléphone</label>
<input type="text" id="no_telephone" onchange="verifierTel('no_telephone');" value=""/>
<br />


<label id="label" for="email_utilisateur">Email</label>
<input type="text" id="email_utilisateur" onchange="isEmail('email_utilisateur');" value=""/>
<br />

<label id="label" for="mdp_utilisateur">Mot de passe</label>
<input type="text" id="mdp_utilisateur" value=""/>
<br />


<label id="label_droit_lab">Droit</label>
<table id="label_droit">
<?php $query="SELECT * FROM DROIT;";
						
			$reponse=mysql_query($query);
			$i=1;
			while ( $row =  mysql_fetch_array($reponse) ) 
			{  
				if (($i%2)!=0){
					echo("</tr><tr>");
					
				}
				// Récupère la ligne suivante d'un jeu de résultats 
				echo("<td><input type='checkbox' name='droit' id='".$row[0]."' value='".$row[0]."'/></td><td><label id =\"formaj\" for=\"".$row[0]."\">".$row[1]."</label></td>");
				$i++;
			}
?>
</table>
<br />
<br />
        <button type="button" id="but_save" onClick="ajout_utilisateur(document.getElementById('my_form'))" >Enregistrer</button>
        <button type="button" onClick="choix_table('utilisateur')" >Annuler</button>
    
    
        </form>
</div>
    
    
    
    
    
    
