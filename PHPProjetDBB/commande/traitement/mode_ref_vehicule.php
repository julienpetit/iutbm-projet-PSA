<?php
 session_start();
 include('../../connexion/_connexion.php');                   // fichier permettant d'afficher VIS ou OF en label dans le formulaire de commande de pièce synchrone.
 
 mysql_query("SET NAMES UTF8");
 
 $id_fournisseur=$_GET['id_fournisseur'];
  
$sql = "SELECT code_mode_ref_vehicule FROM FOURNISSEUR WHERE id_fournisseur='".$id_fournisseur."';";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_assoc($req)){
echo("<td><label id=\"titre\">".$data['code_mode_ref_vehicule']."</label></td><td><input type=\"hidden\" id=\"mode_ref\" name=\"mode_ref\" value=\"".$data['code_mode_ref_vehicule']."\"/><input type=\"text\" id=\"ref_vehicule\" name=\"ref_vehicule\" value=\"\" /> </td>");
}
?>    
