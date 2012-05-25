<?php 
include('../connexion/_connexion.php'); 
mysql_query("SET NAMES UTF8");
?>




<div id="myform" class="myform" style="height:500px;">
    <form id="formulaire" name="form" method="post" action="">
        <h1>Formulaire d'ajout</h1>
        <p>Vous pouvez ajouter un fournisseur</p>

        
        <label id="label" for="cofor">Code fournisseur</label>
        <input type="text" id="cofor" value=""/>
        <br/> 
        <label id="label" for="nom_fournisseur">Nom fournisseur</label>
        <input type="text" id="nom_fournisseur" value=""/>
        <br/>
        <label id="label" for="nom_dest_commande">Nom destinataire</label>
        <input type="text" id="nom_dest_commande" value=""/>
        <br />
        <label id="label" for="mail_dest_commande">Mail destinataire</label>
        <input type="text" id="mail_dest_commande" value="" onchange="testEmail(this.value)"/>
        <br />
        <label id="label" for="mail_copie_commande">Mail copie</label>
        <input type="text" id="mail_copie_commande" value="" onchange="testEmail(this.value)"/>
        <br />
        <label id="label" for="approvisionne">Approvisionne</label>
        <input type="text" id="approvisionne" value="" />
        <br />
        <label id="label">Mode ref vehicule</label>
        <select id="code_mod_ref_vehicule" name="code_mod_ref_vehicule" >
		    <?php		
			    $query="SELECT code_mode_ref_vehicule,libelle_mode_ref_vehicule FROM MODE_REF_VEHICULE;";
						
			    $reponse=mysql_query($query);
						
			    while ( $line =  mysql_fetch_array($reponse) ) 
			    {  
				    // Récupère la ligne suivante d'un jeu de résultats 
				    print("<option value='".$line[0]."'>".$line[1]."</option>");
			    }
		    ?>	
		</select>
        
        <button type="button" id="but_save" onClick="ajout_fournisseur()">Ajouter</button> 
        <button type="button" onClick="choix_table('fournisseur')" >Annuler</button>
        

    </form>
</div>
