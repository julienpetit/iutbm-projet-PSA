<?php
include('../../connexion/_connexion.php');         // fichier permettant de rediriger vers la bonne page depuis l'acceuil 
mysql_query("SET NAMES UTF8");
//recuperation du numero de l'abonne dans l'url
$num_commande=$_GET["num_commande"];
$choix=$_GET["choix"];

//création de la requête SQL:
$sql="SELECT code_type_commande FROM COMMANDE WHERE no_commande = '".$num_commande."'";
//exécution de notre requête SQL:
$result = mysql_query($sql);

if(mysql_num_rows($result)>0){
				
	$row = mysql_fetch_array($result);
  
    	if($choix=='2'){                     // si l'utilisateur a choisi la visualisation
       	if($row['code_type_commande']=='S') // si la commande est de type synchrone on va sur cette page sinon sur la page de masse.
        {
        header("Location: ../pieces_synchrone_visualisation.php?num_commande=".$num_commande."&choix=2");
        }
        else if($row['code_type_commande']=='M')
        {
        header("Location: ../commande_de_masse_visualisation.php?num_commande=".$num_commande."&choix=2");
        }
      	}
        
        if($choix=='3'){               // si l'utilisateur a choisi la modification
        
            $sql1="SELECT date_fermeture, date_annulation, date_reception FROM COMMANDE WHERE no_commande = '".$num_commande."'";
            $result1 = mysql_query($sql1);
            $row1 = mysql_fetch_array($result1);
          
            if(!$row1['date_fermeture'] && !$row1['date_reception'] && !$row1['date_annulation'])// si la commande n'est pas fermée, récéptionnée ou annulée 
        	{
            
       	            if($row['code_type_commande']=='S') //si la commande est de type synchrone : erreur on ne peux pas modifier de commande synchrone
                        {
                            echo "<script event=onload>
		                    alert(\"Ce n'est pas une commande de masse\");
		                    document.location.href='../accueil.php';
		                    </script>";
                        }
            else if($row['code_type_commande']=='M')//sinon ok on redirige
                {
                        header("Location: ../modif_commande_de_masse_tab.php?num_commande=".$num_commande);
                }
        
            }
            else  // si la commande est fermée, réceptionnée ou annulée : erreur!
            {
            echo "<script event=onload>
		                    alert(\"La commande ne peut pas etre modifier, elle est deja receptionee, fermee ou annulee\");
		                    document.location.href='../accueil.php';
		                    </script>";
            
            }
        
        }
        
        if($choix=='4'){ 						 // si l'utilisateur choisi d'annuler la commande, on visualise d'abord la commande
        	if($row['code_type_commande']=='S') // si la commande est de type synchrone on va sur cette page sinon sur la page de masse
        	{
        		header("Location: ../pieces_synchrone_visualisation.php?num_commande=".$num_commande."&choix=4");
        	}
        	else if($row['code_type_commande']=='M')
        	{
        		header("Location: ../commande_de_masse_visualisation.php?num_commande=".$num_commande."&choix=4");
        	}
        }
        
        if($choix=='5'){ // si l'utilisateur choisi de réceptionnée une commande synchrone
       	if($row['code_type_commande']=='S')
        {
        header("Location: ../reception_commande_synchrone.php?num_commande=".$num_commande);
        }
        else if($row['code_type_commande']=='M') // erreur il faut une commande synchrone
        {
        echo "<script event=onload>
		alert(\"Vous n'avez pas choisi une commande de type synchrone\");
		document.location.href='../accueil.php';
		</script>";
        }
        }
        
	if($choix=='6'){ // si l'utilisateur choisi de déclarer des livraison de pièces 
    
            $sql1="SELECT date_fermeture, date_annulation, date_reception FROM COMMANDE WHERE no_commande = '".$num_commande."'";
            $result1 = mysql_query($sql1);
            $row1 = mysql_fetch_array($result1);
           
    if(!$row1['date_fermeture'] && !$row1['date_reception'] && !$row1['date_annulation']) // si la commande n'est pas déjà fermée, réceptionnée ou annulée 
        	{
       	        if($row['code_type_commande']=='S')  // erruer il faut une commande de masse
                {
                    echo "<script event=onload>
		            alert(\"Vous n'avez pas choisi une commande de masse\");
		            document.location.href='../accueil.php';
		            </script>";
                }
                else if($row['code_type_commande']=='M')
                {
                    header("Location: ../masses_details.php?num_commande=".$num_commande);
                }
            }
            else                                                                      // sinon erreur!
            {
            echo "<script event=onload>
		            alert(\"La commande est deja fermee, receptionee ou annulee\");
		            document.location.href='../accueil.php';
		            </script>";
            }
            
            }
        
	if($choix=='7'){ // si l'utilisateur choisi de fermer une commande
    
            $sql1="SELECT date_fermeture, date_annulation, date_reception FROM COMMANDE WHERE no_commande = '".$num_commande."'";
            $result1 = mysql_query($sql1);
            $row1= mysql_fetch_array($result1);
           
            if(!$row1['date_fermeture'] && !$row1['date_reception'] && !$row1['date_annulation'])
        	{
       	        if($row['code_type_commande']=='S') // erreur on doit avoir une commande de masse 
                    {
                        echo "<script event=onload>
		                        alert(\"Vous n'avez pas choisi une commande de masse\");
		                        document.location.href='../accueil.php';
		                        </script>";
                    }
                else if($row['code_type_commande']=='M')
                {
                        header("Location: ../fermer_commande.php?num_commande=".$num_commande);
                }
            }
            else
            {
            echo "<script event=onload>
		                        alert(\"La commande est deja fermee, annulee ou receptionee, elle ne donc peux plus etre fermee.\");
		                        document.location.href='../accueil.php';
		                        </script>";
            
            }
        }

}
else  // si le numéro de commande rentré n'existe pas : erreur !
{
echo "<script event=onload>
	alert('Le numero de commande est errone');
	document.location.href='../accueil.php';
	</script>";
}
   
  ?>
