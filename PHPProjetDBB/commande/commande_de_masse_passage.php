<?php  

session_start();
include('../connexion/_connexion.php');
mysql_query("SET NAMES UTF8");
require_once("../fonctionhtml.php");
require_once("../connexion/verification_connexion.php");
require_once("./nocommande.php");                 // fichier permettant de passer une commande de masse : envoi des valeurs des formulaires a la page send_mail_four.php
html_entete_fichier("commande de masse","../Style.css","fonction.js");

check_log_user($_SESSION['no_droit'],2,NULL); //vérifie si l'utilisateur a bien le droit d'accèder a cette page.
echo("<body>");

echo("<h1 id=\"titreprincipal\">Commande de masse</h1>");
?>

<form method="post" action="send_mail_four.php">
	<div id="contenu">
		<table>
			<?php
			$date = date("d/m/Y");
			$heure = date("h:i:s");
			$numCommande = noCommande();
			$emet = $_SESSION['id'];



			/*****************entête******************************/
			echo("<tr><td><label id=\"titre\">Bon de commande N&deg;</label></td><td><input readonly type=\"text\" name=\"numCommandeMasse\" id=\"numCommandeMasse\"  value=\"$numCommande\"/></td>
					<td><label>le</label><input readonly type=\"text\" name=\"jourCommandeMasse\" id=\"jourCommandeMasse\" value=\"$date\" /></td>
					<td><label>&agrave;</label><input readonly type=\"text\" name=\"heureCommandeMasse\" id=\"heureCommandeMasse\" value=\"$heure\"/> ( non d&eacute;finitifs )</td></tr>


					<tr><td><label id=\"titre\">Emetteur</label></td><td><input readonly type=\"text\" name=\"EmetteurCM\" id=\"EmetteurCM\" value=\"".$emet."\"/></td></tr>

					</table><br /><br />

					<label id=\"titre\">R&eacute;f&eacute;rence dossier</label><br />
					<select id=\"ReferenceDossierCM\" name=\"ReferenceDossierCM\">
					<option>choisir une option</option>
					<option value=\"crise\">Crise</option>
					<option value=\"panne\">Panne</option>
					</select>
					<input type=\"text\" name=\"textReferenceDossierCM\" id=\"textReferenceDossierCM\" value=\"\"/><br /><br /><br />");
			/**********************************************************/
			?>

			<table id="masse">
				<caption id="titre1">Commande</caption>
				<tr>
					<th><p id="sous-titre">Ajouter</p></th>
					<th><p id="sous-titre">R&eacute;f&eacute;rence</p>
					</th>
					<th><p id="sous-titre">D&eacute;signation</p>
					</th>
					<th><p id="sous-titre">Quantit&eacute;</p></th>
					<th><p id="sous-titre">Potentiel/jour</p>
					</th>
				</tr>

				<tr>
					<td></td>
					<td></td>
					<td id="type_piece">Pi&egrave;ce principales</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>

				<tr>
					<td><input type="button" name="+" value="+" id="+"
						onclick="afficher();" style="width: 50px;">
					</td>
					<td><input type="text" name="ReferenceCM_pp1" id="ReferenceCM_pp1"
						value="" onchange="verifierRef('ReferenceCM_pp1')" />
					</td>
					<td><input type="text" name="DesignationCM_pp1"
						id="DesignationCM_pp1" value="" style="width: 500px;" />
					</td>
					<td><input type="text" name="QuantiteCM_pp1" id="QuantiteCM_pp1"
						value="" onkeyup="verifierQuant('QuantiteCM_pp1')"
						onchange="alertQuant('QuantiteCM_pp1')" />
					</td>
					<td><input type="text" name="PotentielCM_pp1" id="PotentielCM_pp1"
						value="" />
					</td>


				</tr>

				<tr>
					<td></td>
					<td><input type="text" name="ReferenceCM_pp2" id="ReferenceCM_pp2"
						value="" style="display: none;"
						onchange="verifierRef('ReferenceCM_pp2')" />
					</td>
					<td><input type="text" name="DesignationCM_pp2"
						id="DesignationCM_pp2" value=""
						style="display: none; width: 500px;" />
					</td>
					<td><input type="text" name="QuantiteCM_pp2" id="QuantiteCM_pp2"
						value="" style="display: none;"
						onkeyup="verifierQuant('QuantiteCM_pp2')"
						onchange="alertQuant('QuantiteCM_pp2')" />
					</td>
					<td><input type="text" name="PotentielCM_pp2" id="PotentielCM_pp2"
						value="" style="display: none;" />
					</td>

				</tr>

				<tr>
					<td></td>
					<td></td>
					<td id="type_piece">Pi&egrave;ces d'environnement</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>

				<tr>
					<td><input type='button' name='plus' value='+' id='plus'
						onclick="afficher2();" style="width: 50px;" />
					</td>
					<td><input type="text" name="ReferenceCM_pe1" id="ReferenceCM_pe1"
						value="" onchange="verifierRef('ReferenceCM_pe1')" />
					</td>
					<td><input type="text" name="DesignationCM_pe1"
						id="DesignationCM_pe1" value="" style="width: 500px;" />
					</td>
					<td><input type="text" name="QuantiteCM_pe1" id="QuantiteCM_pe1"
						value="" onkeyup="verifierQuant('QuantiteCM_pe1')"
						onchange="alertQuant('QuantiteCM_pe1')" />
					</td>
					<td></td>

				</tr>
				<tr>

					<td><input type='button' name='plus2' value='+' id='plus2'
						onclick="afficher3();"
						style="display: none; width: 50px; disabled: false;"></td>
					<td><input type="text" name="ReferenceCM_pe2" id="ReferenceCM_pe2"
						value="" style="display: none;"
						onchange="verifierRef('ReferenceCM_pe2')" />
					</td>
					<td><input type="text" name="DesignationCM_pe2"
						id="DesignationCM_pe2" value=""
						style="display: none; width: 500px;" />
					</td>
					<td><input type="text" name="QuantiteCM_pe2" id="QuantiteCM_pe2"
						value="" style="display: none;"
						onkeyup="verifierQuant('QuantiteCM_pe2')"
						onchange="alertQuant('QuantiteCM_pe2')" />
					</td>
					<td></td>

				</tr>

				<tr>
					<td></td>
					<td><input type="text" name="ReferenceCM_pe3" id="ReferenceCM_pe3"
						value="" style="display: none;"
						onchange="verifierRef('ReferenceCM_pe3')" />
					</td>
					<td><input type="text" name="DesignationCM_pe3"
						id="DesignationCM_pe3" value=""
						style="display: none; width: 500px;" />
					</td>
					<td><input type="text" name="QuantiteCM_pe3" id="QuantiteCM_pe3"
						value="" style="display: none;"
						onkeyup="verifierQuant('QuantiteCM_pe3')"
						onchange="alertQuant('QuantiteCM_pe3')" />
					</td>
					<td></td>

				</tr>



			</table>
			<br />

			<table id="derniere">

				<caption id="titre1">Responsable par d&eacute;faut</caption>


				<tr>
					<th>
						<p id="sous-titre">Entit&eacute;</p>
					</th>
					<td><select id="EntiteCM" name="EntiteCM"
						onchange="Change(this.value);">
							<option>choisir option</option>
							<?php
							$sql = "SELECT * FROM ENTITE";
							$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
							while($data = mysql_fetch_assoc($req)){
								echo("<option value=\"".$data['code_imputation']."\">".$data['libelle_entite']."</option>");
							}
							?>
					</select>
					</td>
				</tr>
				<tr>
					<th>
						<p id="sous-titre">CA imput&eacute;</p>
					</th>
					<td>
						<div id="resultat">
							<input type="text" name="CaImputeCM" id="CaImputeCM" value="" />
						</div>
					</td>
				</tr>


			</table>
			<input type="submit" id="val" value="Envoyer la commande">
			<input type="reset" id="anu" value="Remettre a zero">
			<input type="reset" id="anu" value="Accueil"
				onclick="document.location.href='accueil.php';" />
			</div>

			</form>

			</body>

			</html>