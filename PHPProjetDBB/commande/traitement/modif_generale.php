<?php  
include('../../connexion/_connexion.php');

require_once("../../fonctionhtml.php");  

html_entete_fichier("accueil","../Style.css","fonction.js");                               // fichier permettant d'appliquer les modification a une commande de masse mais il manque l'envoi d'un nouveau pdf.
mysql_query("SET NAMES UTF8");
echo("<body>");

$choix = $_GET['choix'];
$num_commande = $_GET['num_commande'];


function test_reference($reference,$num_commande) // fonction de test si la référence est bonne et si elle existe déjà.
{

 if(empty($reference)){ // $reference est vide, on retourne faux

  return false;

 }
else{

$sql = "SELECT reference_piece FROM COMPREND WHERE no_commande=$num_commande ;";
    $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while($line = mysql_fetch_array($req)){
                
	if($line[0]==$reference)
		
		return true;	
		
         
    }
	return false;
 }
}

function test_reference1($reference) // fonction de test si la référence est bonne et si elle existe déjà.
{

 if(empty($reference)){ // $reference est vide, on retourne faux

  return false;

 }
else{

$sql = "SELECT * FROM PIECE;";
    $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while($line = mysql_fetch_array($req)){
                
	if($line[0]==$reference)
		
		return true;	
		
         
    }
	return false;
 }
}



?>


<?php



/****************** pieces_principales_1*****************/

if(isset($_POST['ReferenceCM_pp1']) && isset($_POST['DesignationCM_pp1']) && isset($_POST['PotentielCM_pp1']) && isset($_POST['QuantiteCM_pp1']) && !empty($_POST['DesignationCM_pp1']) && !empty($_POST['PotentielCM_pp1']) && !empty($_POST['QuantiteCM_pp1']) && !empty($_POST['ReferenceCM_pp1']))
{ // tout est bien définie donc on peut appliquer les modif a la commande 
	$DesignationCM_pp1=$_POST['DesignationCM_pp1'];
        
        
            if(test_reference($_POST['ReferenceCM_pp1'],$num_commande)) // si la référence de pièce qu'on viens d'ajouter a la commande existe alors on met juste a jour se qu'il faut.
            {
                    $sql3= "UPDATE PIECE SET designation_piece='$DesignationCM_pp1' WHERE reference_piece='".$_POST['ReferenceCM_pp1']."';";
                    mysql_query($sql3) or die('Erreur SQL1 !<br>'.$sql3.'<br>'.mysql_error());
                    
                    $sql1 = "UPDATE COMPREND SET quantite_piece=".$_POST['QuantiteCM_pp1']." WHERE libelle_type_piece = \"pieces principales\" AND no_commande = $num_commande AND reference_piece='".$_POST['ReferenceCM_pp1']."';";
                    mysql_query($sql1) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());
                    
                    
                    $sql2 = "UPDATE CADENCEE SET potentiel_jour=".$_POST['PotentielCM_pp1']." WHERE no_commande = $num_commande AND reference_piece='".$_POST['ReferenceCM_pp1'].";'";
                    mysql_query($sql2) or die('Erreur SQL1 !<br>'.$sql2.'<br>'.mysql_error());
            
            
            }
            else if(!test_reference1($_POST['ReferenceCM_pp1'])) // sinon c'est que l'utilisateur a ajouter une nouvelle pièce donc on l'insert dans la base
            {
                    $sql3 = "INSERT INTO PIECE values('".$_POST['ReferenceCM_pp1']."','".$_POST['DesignationCM_pp1']."');";
                    mysql_query($sql3) or die('Erreur SQL1 !<br>'.$sql3.'<br>'.mysql_error());
                    
                    $sql1 = "INSERT INTO COMPREND values('pieces principales','".$_POST['ReferenceCM_pp1']."','$num_commande','".$_POST['QuantiteCM_pp1']."');";
                    mysql_query($sql1) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());
                    
                    $sql2 = "INSERT INTO CADENCEE values('$num_commande','".$_POST['ReferenceCM_pp1']."','".$_POST['PotentielCM_pp1']."');";
                    mysql_query($sql2) or die('Erreur SQL1 !<br>'.$sql2.'<br>'.mysql_error());
            
            }
            else if(!test_reference($_POST['ReferenceCM_pp1'],$num_commande) && test_reference1($_POST['ReferenceCM_pp1']))
            {
            
                    $sql1 = "INSERT INTO COMPREND values('pieces principales','".$_POST['ReferenceCM_pp1']."','$num_commande','".$_POST['QuantiteCM_pp1']."');";
                    mysql_query($sql1) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());
                    
                    $sql2 = "INSERT INTO CADENCEE values('$num_commande','".$_POST['ReferenceCM_pp1']."','".$_POST['PotentielCM_pp1']."');";
                    mysql_query($sql2) or die('Erreur SQL1 !<br>'.$sql2.'<br>'.mysql_error());
            
            }


}



/**************************pieces_principales_2********************/                                   // même résonement pour les 5 pèces possibles.

if(isset($_POST['ReferenceCM_pp2']) && isset($_POST['DesignationCM_pp2']) && isset($_POST['PotentielCM_pp2']) && isset($_POST['QuantiteCM_pp2']) && 
    !empty($_POST['DesignationCM_pp2']) && !empty($_POST['PotentielCM_pp2']) && !empty($_POST['QuantiteCM_pp2']) && !empty($_POST['ReferenceCM_pp2']))
{

            $sql = "SELECT * FROM  PIECE WHERE reference_piece='".$_POST['ReferenceCM_pp2']."'"; 
            $exist=mysql_query($sql) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());
           $resultat=mysql_fetch_array($exist);

                    if(test_reference($_POST['ReferenceCM_pp2'],$num_commande)) // si la référence de pièce qu'on viens d'ajouter a la commande existe alors on met juste a jour se qu'il faut.
            {
				
                            $sql3= "UPDATE PIECE SET designation_piece='".$_POST['DesignationCM_pp2']."' WHERE reference_piece='".$_POST['ReferenceCM_pp2']."';";
                            mysql_query($sql3) or die('Erreur SQL1 !<br>'.$sql3.'<br>'.mysql_error());
                            
                            $sql1 = "UPDATE COMPREND SET quantite_piece=".$_POST['QuantiteCM_pp2']." WHERE libelle_type_piece = \"pieces principales\" AND no_commande = $num_commande AND reference_piece='".$_POST['ReferenceCM_pp2']."';";
                            mysql_query($sql1) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());
                            
                            
                            $sql2 = "UPDATE CADENCEE SET potentiel_jour=".$_POST['PotentielCM_pp2']." WHERE no_commande = $num_commande AND reference_piece='".$_POST['ReferenceCM_pp2']."';";
                            mysql_query($sql2) or die('Erreur SQL1 !<br>'.$sql2.'<br>'.mysql_error());
                            
                    
                    }
                    else if(!test_reference1($_POST['ReferenceCM_pp2'])) // sinon c'est que l'utilisateur a ajouter une nouvelle pièce donc on l'insert dans la base
            {
			
                            $sql3 = "INSERT INTO PIECE values('".$_POST['ReferenceCM_pp2']."','".$_POST['DesignationCM_pp2']."');";
				echo $sql3;
                            mysql_query($sql3) or die('Erreur SQL1 !<br>'.$sql3.'<br>'.mysql_error());
                            
                            $sql1 = "INSERT INTO COMPREND values('pieces principales','".$_POST['ReferenceCM_pp2']."','$num_commande','".$_POST['QuantiteCM_pp2']."');";
                            mysql_query($sql1) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());
                            
                            $sql2 = "INSERT INTO CADENCEE values('$num_commande','".$_POST['ReferenceCM_pp2']."','".$_POST['PotentielCM_pp2']."');";
                            mysql_query($sql2) or die('Erreur SQL1 !<br>'.$sql2.'<br>'.mysql_error());
                    
                    }
                     else if(!test_reference($_POST['ReferenceCM_pp2'],$num_commande) && test_reference1($_POST['ReferenceCM_pp2']))
            {
 $sql1 = "INSERT INTO COMPREND values('pieces principales','".$_POST['ReferenceCM_pp2']."','$num_commande','".$_POST['QuantiteCM_pp2']."');";
                            mysql_query($sql1) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());
                            
                            $sql2 = "INSERT INTO CADENCEE values('$num_commande','".$_POST['ReferenceCM_pp2']."','".$_POST['PotentielCM_pp2']."');";
                            mysql_query($sql2) or die('Erreur SQL1 !<br>'.$sql2.'<br>'.mysql_error());
                            }

}
/*************************pieces_environnement_1**********************/

if(isset($_POST['ReferenceCM_pe1']) && isset($_POST['DesignationCM_pe1']) && isset($_POST['QuantiteCM_pe1']) && 
    !empty($_POST['DesignationCM_pe1']) && !empty($_POST['QuantiteCM_pe1']) && !empty($_POST['ReferenceCM_pe1']))
{

        $sql = "SELECT * FROM  PIECE WHERE reference_piece='".$_POST['ReferenceCM_pe1']."'"; 
        $exists=mysql_query($sql) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());

           
                    if(test_reference($_POST['ReferenceCM_pe1'],$num_commande)) // si la référence de pièce qu'on viens d'ajouter a la commande existe alors on met juste a jour se qu'il faut.
            {
                    $sql3= "UPDATE PIECE SET designation_piece='".$_POST['DesignationCM_pe1']."' WHERE reference_piece='".$_POST['ReferenceCM_pe1']."';";
                    mysql_query($sql3) or die('Erreur SQL1 !<br>'.$sql3.'<br>'.mysql_error());
                    
                    $sql1 = "UPDATE COMPREND SET quantite_piece=".$_POST['QuantiteCM_pe1']." WHERE libelle_type_piece = \"pieces environnement\" AND no_commande = $num_commande AND reference_piece='".$_POST['ReferenceCM_pe1']."';";
                    mysql_query($sql1) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());
                    
                               
            
            }
               else if(!test_reference1($_POST['ReferenceCM_pe1'])) // sinon c'est que l'utilisateur a ajouter une nouvelle pièce donc on l'insert dans la base
            {
                    $sql3 = "INSERT INTO PIECE values('".$_POST['ReferenceCM_pe1']."','".$_POST['DesignationCM_pe1']."');";
                    mysql_query($sql3) or die('Erreur SQL1 !<br>'.$sql3.'<br>'.mysql_error());
                    
                    $sql1 = "INSERT INTO COMPREND values('pieces environnement','".$_POST['ReferenceCM_pe1']."','$num_commande','".$_POST['QuantiteCM_pe1']."');";
                    mysql_query($sql1) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());
                    
                               
            }
            else if(!test_reference($_POST['ReferenceCM_pe1'],$num_commande) && test_reference1($_POST['ReferenceCM_pe1']))
            {
  $sql1 = "INSERT INTO COMPREND values('pieces environnement','".$_POST['ReferenceCM_pe1']."','$num_commande','".$_POST['QuantiteCM_pe1']."');";
                    mysql_query($sql1) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());
                   }

}

/************************pieces_environnement_2***********************/

if(isset($_POST['ReferenceCM_pe2']) && isset($_POST['DesignationCM_pe2']) && isset($_POST['QuantiteCM_pe2']) && 
    !empty($_POST['DesignationCM_pe2']) && !empty($_POST['QuantiteCM_pe2']) && !empty($_POST['ReferenceCM_pe2']))
{

        $sql = "SELECT * FROM  PIECE WHERE reference_piece='".$_POST['ReferenceCM_pe2']."'"; 
        $exists=mysql_query($sql) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());

            if(test_reference($_POST['ReferenceCM_pe2'],$num_commande)) // si la référence de pièce qu'on viens d'ajouter a la commande existe alors on met juste a jour se qu'il faut.
            {
                    $sql3= "UPDATE PIECE SET designation_piece='".$_POST['DesignationCM_pe2']."' WHERE reference_piece='".$_POST['ReferenceCM_pe2']."';";
                    mysql_query($sql3) or die('Erreur SQL1 !<br>'.$sql3.'<br>'.mysql_error());
                    
                    $sql1 = "UPDATE COMPREND SET quantite_piece=".$_POST['QuantiteCM_pe2']." WHERE libelle_type_piece = \"pieces environnement\" AND no_commande = $num_commande AND reference_piece='".$_POST['ReferenceCM_pe2']."';";
                    mysql_query($sql1) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());
                    
                               
            
            }
            else if(!test_reference1($_POST['ReferenceCM_pe2'])) // sinon c'est que l'utilisateur a ajouter une nouvelle pièce donc on l'insert dans la base
            {
                    $sql3 = "INSERT INTO PIECE values('".$_POST['ReferenceCM_pe2']."','".$_POST['DesignationCM_pe2']."');";
                    mysql_query($sql3) or die('Erreur SQL1 !<br>'.$sql3.'<br>'.mysql_error());
                    
                    $sql1 = "INSERT INTO COMPREND values('pieces environnement','".$_POST['ReferenceCM_pe2']."','$num_commande','".$_POST['QuantiteCM_pe2']."');";
                    mysql_query($sql1) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());
                    
                               
            }
             else if(!test_reference($_POST['ReferenceCM_pe2'],$num_commande) && test_reference1($_POST['ReferenceCM_pe2']))
            {

$sql1 = "INSERT INTO COMPREND values('pieces environnement','".$_POST['ReferenceCM_pe2']."','$num_commande','".$_POST['QuantiteCM_pe2']."');";
                    mysql_query($sql1) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());
                    }
}

/************************pieces_environnement_3***********************/

if(isset($_POST['ReferenceCM_pe3']) && isset($_POST['DesignationCM_pe3']) && isset($_POST['QuantiteCM_pe3']) && 
    !empty($_POST['DesignationCM_pe3']) && !empty($_POST['QuantiteCM_pe3']) && !empty($_POST['ReferenceCM_pe3']))
{

        $sql = "SELECT * FROM  PIECE WHERE reference_piece='".$_POST['ReferenceCM_pe3']."'"; 
        $exists=mysql_query($sql) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());

           if(test_reference($_POST['ReferenceCM_pe3'],$num_commande)) // si la référence de pièce qu'on viens d'ajouter a la commande existe alors on met juste a jour se qu'il faut.
            {
                    $sql3= "UPDATE PIECE SET designation_piece='".$_POST['DesignationCM_pe3']."' WHERE reference_piece='".$_POST['ReferenceCM_pe3']."';";
                    mysql_query($sql3) or die('Erreur SQL1 !<br>'.$sql3.'<br>'.mysql_error());
                    
                    $sql1 = "UPDATE COMPREND SET quantite_piece=".$_POST['QuantiteCM_pe3']." WHERE libelle_type_piece = \"pieces environnement\" AND no_commande = $num_commande AND reference_piece='".$_POST['ReferenceCM_pe3']."';";
                    mysql_query($sql1) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());
                    
                               
            
            }
             else if(!test_reference1($_POST['ReferenceCM_pe3'])) // sinon c'est que l'utilisateur a ajouter une nouvelle pièce donc on l'insert dans la base
            {
                    $sql3 = "INSERT INTO PIECE values('".$_POST['ReferenceCM_pe3']."','".$_POST['DesignationCM_pe3']."');";
                    mysql_query($sql3) or die('Erreur SQL1 !<br>'.$sql3.'<br>'.mysql_error());
                    
                    $sql1 = "INSERT INTO COMPREND values('pieces environnement','".$_POST['ReferenceCM_pe3']."','$num_commande','".$_POST['QuantiteCM_pe3']."');";
                    mysql_query($sql1) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());
                    
                               
            }
            else if(!test_reference($_POST['ReferenceCM_pe3'],$num_commande) && test_reference1($_POST['ReferenceCM_pe3']))
            {

 
                    $sql1 = "INSERT INTO COMPREND values('pieces environnement','".$_POST['ReferenceCM_pe3']."','$num_commande','".$_POST['QuantiteCM_pe3']."');";
                    mysql_query($sql1) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());
                    }
}



echo "modification reussie";
header("Refresh: 2;URL=../modif_commande_de_masse_tab.php?num_commande=$num_commande");



//}
?>

</body>
</html>
