<div id="myform" class="myform">
    <form id="formulaire" name="form" method="post" action="">

        <h1>Formulaire d'ajout</h1>
        <p>Vous pouvez ajouter une silhouette</p>


<br /><br />


<label id="label" for="code_silouhette">Code silouhette</label>
<input type="text" id="code_silouhette" value=""/>



<label id="label" for="libelle_silouhette">Libelle silouhette</label>
<input type="text" id="libelle_silouhette" value=""/>



<button type="button" id="but_save"  onClick="ajout_silouhette()">Enregistrer</button>
<button type="button" onClick="choix_table('silouhette')">Annuler</button>
