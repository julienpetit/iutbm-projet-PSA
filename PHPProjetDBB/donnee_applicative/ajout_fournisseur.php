<?php include('../connexion/_connexion.php');

mysql_query("SET NAMES UTF8");

	$query2="INSERT INTO FOURNISSEUR values(null,'".$_POST['nom']."','".$_POST['code']."','".$_POST['nom_dest']."','".$_POST['code_mod']."');";

	$reponse2  = mysql_query($query2);
    
    $query3="SELECT id_fournisseur FROM FOURNISSEUR WHERE cofor='".$_POST['code']."';";
   
    $reponse3  = mysql_query($query3);
    
    $data=mysql_fetch_assoc($reponse3);
 
 
    $query4="INSERT INTO ADRESSE_MAIL values('".$_POST['mail_dest']."');";

    $reponse4=mysql_query($query4);
    
   
     $query5="INSERT INTO ADRESSE_MAIL values('".$_POST['mail_copie']."');";

    $reponse5=mysql_query($query5);
    
    $query6="INSERT INTO DEST_COMMANDE values('".$_POST['mail_dest']."','".$data['id_fournisseur']."');";

    $reponse6=mysql_query($query6);
    
    $query7="INSERT INTO COPIE_COMMANDE values('".$_POST['mail_copie']."','".$data['id_fournisseur']."');";


    $reponse7=mysql_query($query7);
    
    
    $query8="INSERT INTO TYPE_PIECE2 values('".$_POST['approvisionne']."');";

    $reponse8=mysql_query($query8);
    
    $query9="INSERT INTO APPROVISIONNE values('".$_POST['approvisionne']."','".$data['id_fournisseur']."');";

    $reponse9=mysql_query($query9);
?>
