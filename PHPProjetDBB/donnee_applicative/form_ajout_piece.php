
<div id="myform" class="myform">
    <form id="formulaire" name="form" method="post" action="">

        <h1>Formulaire d'ajout</h1>
        <p>Vous pouvez ajouter une pièce</p>

        <br /><br />
	<label id="label" for="reference_piece">Reference Pi&egrave;ce</label>
        <input type="text" id="reference_piece" onchange="verifierRef('reference_piece');" value=""/>

        <label id="label" for="designation_piece">Libell&eacute; pi&egrave;ce</label>
        <input type="text" id="designation_piece" value=""/>

        
        <button type="button" id="but_save" onClick="ajout_piece();">Enregistrer</button>
        <button type="button" value="Annuler" onClick="choix_table('piece')" >Annuler</button>
    
    </form>
</div>
