 <?php

 include('../../connexion/_connexion.php');            // fichier permettant de connaitre les pièces fourni par un fournisseur.
 
 mysql_query("SET NAMES UTF8");
 
 $id_fournisseur=$_GET['id_fournisseur'];
  
$sql = "SELECT t.libelle_type_piece_2 FROM TYPE_PIECE2 t, APPROVISIONNE a, FOURNISSEUR f WHERE a.id_fournisseur=f.id_fournisseur AND a.libelle_type_piece_2=t.libelle_type_piece_2 AND a.id_fournisseur='".$id_fournisseur."';";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_assoc($req)){
echo("<p>Pieces fournies:<br/>".$data['libelle_type_piece_2']."</p>");
}
?>    
