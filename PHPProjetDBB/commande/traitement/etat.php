<?php
include('../../connexion/_connexion.php');                      // fichier permettant de connaitre l'état de la commande au moment de la visualisation et de retourner un paragraphe donnant la
mysql_query("SET NAMES UTF8");                                  // situation de la commande.
//recuperation du numero de l'abonne dans l'url
$num_commande=$_GET["num_commande"];
   

//création de la requête SQL:
$sql="SELECT * FROM COMMANDE WHERE no_commande = '".$num_commande."';";
//exécution de notre requête SQL:
$result = mysql_query($sql);

			
$row = mysql_fetch_array($result);

   
       if(empty($row['date_fermeture']) && empty($row['heure_fermeture']) && empty($row['motif_fermeture']) ) // si commande ouverte
              {
                   echo "";
                }
        else if(!empty($row['date_fermeture']) && !empty($row['heure_fermeture']) && !empty($row['motif_fermeture']) && empty($row['date_reception']) && empty($row['heure_reception']) && empty($row['date_annulation']) && empty($row['heure_annulation']))
        {
        echo "<p style=\"color:red;\">Fermée le ".$row['date_fermeture']."<br/>à ".$row['heure_fermeture']."</p>"; // si commande fermée
         }
        else if(!empty($row['date_fermeture']) && !empty($row['heure_fermeture']) && !empty($row['motif_fermeture']) && !empty($row['date_reception']) && !empty($row['heure_reception'])  && empty($row['date_annulation']) && empty($row['heure_annulation']))
        {
        echo "<p style=\"color:red;\">Receptionnée le ".$row['date_reception']."<br/>à ".$row['heure_reception']."</p>"; // si commande annulée
         }
       else if(!empty($row['date_fermeture']) && !empty($row['heure_fermeture']) && !empty($row['motif_fermeture']) && empty($row['date_reception']) && empty($row['heure_reception']) && !empty($row['date_annulation']) && !empty($row['heure_annulation']) )
        {
        echo "<p style=\"color:red;\">Annulée le ".$row['date_annulation']."<br/>à ".$row['heure_annulation']."</p>"; // si commande réceptionnée
        }
       
   
  ?>
