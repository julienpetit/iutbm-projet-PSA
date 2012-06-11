<?php header_html("Ajout d'une piece", array("web/style.css"), array("web/script.js"))?>

<div id='section'>
				<h2>Nouvelle piece</h2>
				<form id='formulaire' action='./?action=<?php printHtml($method); ?>' method='post'>
					<tr>
						<td>Reference</td>
						<td><input type='text' id='reference' name='reference' /></td>
					</tr>
				</form>
</div>
