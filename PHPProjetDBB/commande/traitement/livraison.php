<?php 


include('../../connexion/_connexion.php');                         // fichier permettant d'enregistrer des livraison
 mysql_query("SET NAMES UTF8");
   
  $num_commande=$_GET['num_commande'];
  // redirection vers la page contenu_modifier lors du exit()


  /*******************commande principale 1*************/
  
  if(isset($_POST['choix_case_remplir_principale_1']) && isset($_POST['choix_case_reference_principale_1'])) // si il y a une pièce principale 1 on récupère le nombre de livraison pour 
                                                                                                              //connaitre le numéro de la case dont on doit récupèrer les valeur.
  {
        $i=$_POST['choix_case_remplir_principale_1'];
        $i1=$_POST['choix_case_reference_principale_1'];
  
 
        if(isset($_POST['livraison_principale_1-'.$i]) && !empty($_POST['livraison_principale_1-'.$i]) && !empty($_POST['quantite_principale_1-'.$i]) && // vérifie si la case dont on doit prendre les valeur
        isset($_POST['quantite_principale_1-'.$i]) && isset($_POST['reference_principale_'.$i1]) )                                                      // est remplie.
        {
            $date = $_POST['livraison_principale_1-'.$i];
            $date_converti = date("Y-m-d", strtotime("$date")); // on converti la date pour l'insèrer dans la base
            $quantite = $_POST['quantite_principale_1-'.$i];
            $reference = $_POST['reference_principale_'.$i1];
        
            $sql="SELECT date_livraison FROM LIVRAISON WHERE reference_piece='".$reference."' AND no_commande=".$num_commande.";";
            $query = mysql_query($sql);
            $i=0;
            
            if(mysql_fetch_array($query)){
            while($data=mysql_fetch_array($query)){$date_existante[$i]=$data[0]; $i++;} // permet de vérifier si la date éxiste déjà ou pas car c'est une clé primaire on ne peut doc pas avoir 2
                                                                                        // livraisons le même jour.
            }
            else{
            $date_existante[$i]=0;
            }
            if(!in_array($date_converti,$date_existante))
            {
            if(preg_match ('`(\d{1,2})-(\d{1,2})-(\d{4})`', $date, $out) && is_numeric($quantite)) // si la date est de bon format et que la quantité est bien un nombre .
            {
                    //création de la requête SQL:
                    $sql = "INSERT INTO LIVRAISON(reference_piece,no_commande,date_livraison,quantite_livree) VALUES ('$reference','$num_commande','$date_converti','$quantite') ;";
 
                    //exécution de la requête SQL:
                    $requete = mysql_query($sql) or die( mysql_error() ) ;
            }
            else // sinon erreur !
            {
                echo "date ou quantit&eacute incorrect";
                header("Refresh: 2; url=../masses_details.php?num_commande=".$num_commande);
                exit();
            }
        }
        else // si la date est déjà dans la base pour cette pièce et cette cmmande alors erreur!
        {
        echo "date de livraison deja existante";
                header("Refresh: 2; url=../masses_details.php?num_commande=".$num_commande);
                exit();
        }
        }
 
 }
 /***********************commande_principale2*************************/                                                 // même résonement pour les 5 pièces possibles.
 
  if(isset($_POST['choix_case_remplir_principale_2']) && isset($_POST['choix_case_reference_principale_2']))
  {    
    $j=$_POST['choix_case_remplir_principale_2'];
    $j1=$_POST['choix_case_reference_principale_2'];

       if(isset($_POST['livraison_principale_2-'.$j]) && !empty($_POST['livraison_principale_2-'.$j]) && !empty($_POST['quantite_principale_2-'.$j]) && 
       isset($_POST['quantite_principale_2-'.$j]) && isset($_POST['reference_principale_'.$j1]) )
       {
        $date1 = $_POST['livraison_principale_2-'.$j];
        $date_converti1 = date("Y-m-d", strtotime("$date1"));

        $quantite1 = $_POST['quantite_principale_2-'.$j];
        $reference1 = $_POST['reference_principale_'.$j1];

           $sql1="SELECT date_livraison FROM LIVRAISON WHERE reference_piece='".$reference1."' AND no_commande=".$num_commande.";";
            $query1 = mysql_query($sql1);
            $i1=0;
            
            if(mysql_fetch_array($query1)){
            echo "grosse pute";
            while($data1=mysql_fetch_array($query1)){$date_existante1[$i1]=$data1['date_livraison']; $i1++;}
            }
            else{
            $date_existante1[$i1]=0;
            }
            if(!in_array($date_converti1,$date_existante1))
            {
         if(preg_match ('`(\d{1,2})-(\d{1,2})-(\d{4})`', $date1, $out) && is_numeric($quantite1))
          {
    
                    //création de la requête SQL:
                    $sql1 = "INSERT INTO LIVRAISON(reference_piece,no_commande,date_livraison,quantite_livree) VALUES ('$reference1','$num_commande','$date_converti1','$quantite1') ;";
 
                    //exécution de la requête SQL:
                    $requete1 = mysql_query($sql1) or die( mysql_error() ) ;
         }
        else
            {
                echo "date ou quantit&eacute incorrect";
                header("Refresh: 2; url=../masses_details.php?num_commande=".$num_commande);
                exit();
            }
        
        
        }
         else
        {
        echo "date de livraison deja existante";
                header("Refresh: 2; url=../masses_details.php?num_commande=".$num_commande);
                exit();
        }
        }
 
  }
 /**************************commande_environnement1*****************/
 
  if(isset($_POST['choix_case_remplir_environnement_1']) && isset($_POST['choix_case_reference_environnement_1']))
  {
        $k=$_POST['choix_case_remplir_environnement_1'];
        $k1=$_POST['choix_case_reference_environnement_1'];

         if(isset($_POST['livraison_environnement_1-'.$k]) && !empty($_POST['livraison_environnement_1-'.$k]) && !empty($_POST['quantite_environnement_1-'.$k]) &&
         isset($_POST['quantite_environnement_1-'.$k]) && isset($_POST['reference_environnement_'.$k1]) )
        {
            $date2 = $_POST['livraison_environnement_1-'.$k];
            $date_converti2 = date("Y-m-d", strtotime("$date2"));
            $quantite2 = $_POST['quantite_environnement_1-'.$k];
            $reference2 = $_POST['reference_environnement_'.$k1];

            $sql2="SELECT date_livraison FROM LIVRAISON WHERE reference_piece='".$reference2."' AND no_commande=".$num_commande.";";
            $query2 = mysql_query($sql2);
            $i2=0;
             if(mysql_fetch_array($query2)){
            while($data2=mysql_fetch_array($query2)){$date_existante2[$i2]=$data2[0]; $i2++;}
            }
            else{
            $date_existante2[$i2]=0;
            }
            if(!in_array($date_converti2,$date_existante2))
            {

            if(preg_match ('`(\d{1,2})-(\d{1,2})-(\d{4})`', $date2, $out) && is_numeric($quantite2))
          {
                $sql2 = "INSERT INTO LIVRAISON(reference_piece,no_commande,date_livraison,quantite_livree) VALUES ('$reference2','$num_commande','$date_converti2','$quantite2') ;";
 
                //exécution de la requête SQL:
                    $requete2 = mysql_query($sql2) or die( mysql_error() ) ;
         } 
       
        else
            {
                echo "date ou quantit&eacute incorrect";
                header("Refresh: 2; url=../masses_details.php?num_commande=".$num_commande);
                exit();
            }
            
       }
       else
        {
        echo "date de livraison deja existante";
                header("Refresh: 2; url=../masses_details.php?num_commande=".$num_commande);
                exit();
        }
        }
  }
  /**************************commande_environnement2*****************/
  if(isset($_POST['choix_case_remplir_environnement_2']) && isset($_POST['choix_case_reference_environnement_2']))
  {
  
        $l=$_POST['choix_case_remplir_environnement_2'];
        $l1=$_POST['choix_case_reference_environnement_2'];
   
        if(isset($_POST['livraison_environnement_2-'.$l]) && !empty($_POST['livraison_environnement_2-'.$l]) && !empty($_POST['quantite_environnement_2-'.$l]) &&
        isset($_POST['quantite_environnement_2-'.$l]) && isset($_POST['reference_environnement_'.$l1]))
        {
        
            $date3 = $_POST['livraison_environnement_2-'.$l];
            $date_converti3 = date("Y-m-d", strtotime("$date3"));
            $quantite3 = $_POST['quantite_environnement_2-'.$l];
            $reference3 = $_POST['reference_environnement_'.$l1];
        
        $sql3="SELECT date_livraison FROM LIVRAISON WHERE reference_piece='".$reference3."' AND no_commande=".$num_commande.";";
            $query3 = mysql_query($sql3);
            $i3=0;
            if(mysql_fetch_array($query3)){
            while($data3=mysql_fetch_array($query3)){$date_existante3[$i3]=$data3[0]; $i3++;}
            }
             else{
            $date_existante3[$i3]=0;
            }
            
            if(!in_array($date_converti3,$date_existante3))
            {
       if(preg_match ('`(\d{1,2})-(\d{1,2})-(\d{4})`', $date3, $out) && is_numeric($quantite3))
          {
            $sql3 = "INSERT INTO LIVRAISON(reference_piece,no_commande,date_livraison,quantite_livree) VALUES ('$reference3','$num_commande','$date_converti3','$quantite3') ;";
 
        //exécution de la requête SQL:
            $requete3 = mysql_query($sql3) or die( mysql_error() ) ;
            } 
       
        else
            {
                echo "date ou quantit&eacute incorrect";
                header("Refresh: 2; url=../masses_details.php?num_commande=".$num_commande);
                exit();
            }
            
            
        }
        else
        {
        echo "date de livraison deja existante";
                header("Refresh: 2; url=../masses_details.php?num_commande=".$num_commande);
                exit();
        }
        }
 }
  /**************************commande_environnement3*****************/
  if(isset($_POST['choix_case_remplir_environnement_3']) && isset($_POST['choix_case_reference_environnement_3']))
  {
        $m=$_POST['choix_case_remplir_environnement_3'];
        $m1=$_POST['choix_case_reference_environnement_3'];

         if(isset($_POST['livraison_environnement_3-'.$m]) && !empty($_POST['livraison_environnement_3-'.$m]) && !empty($_POST['quantite_environnement_3-'.$m])
         && isset($_POST['quantite_environnement_3-'.$m]) && isset($_POST['reference_environnement_'.$m1]) )
         {
            $date4 = $_POST['livraison_environnement_3-'.$m];
            $date_converti4 = date("Y-m-d", strtotime("$date4"));
           
            $quantite4 = $_POST['quantite_environnement_3-'.$m];
            $reference4 = $_POST['reference_environnement_'.$m1];
       
       $sql4="SELECT date_livraison FROM LIVRAISON WHERE reference_piece='".$reference4."' AND no_commande=".$num_commande.";";
            $query4 = mysql_query($sql4);
            $i4=0;
            if(mysql_fetch_array($query4)){
            while($data4=mysql_fetch_array($query4)){$date_existante4[$i4]=$data4[0]; $i4++;}
            }else{
            $date_existante4[$i4]=0;
            }
            
            if(!in_array($date_converti4,$date_existante4))
            {
       if(preg_match ('`(\d{1,2})-(\d{1,2})-(\d{4})`', $date4, $out) && is_numeric($quantite4))
          {
            $sql4 = "INSERT INTO LIVRAISON(reference_piece,no_commande,date_livraison,quantite_livree) VALUES ('$reference4','$num_commande','$date_converti4','$quantite4') ;";
 
         //exécution de la requête SQL:
            $requete4 = mysql_query($sql4) or die( mysql_error() ) ;
         } 
       
        else
            {
                echo "date ou quantit&eacute incorrect";
                header("Refresh: 2; url=../masses_details.php?num_commande=".$num_commande);
                exit();
            }
        
        
        
        }
        else
        {
        echo "date de livraison deja existante";
                header("Refresh: 2; url=../masses_details.php?num_commande=".$num_commande);
                exit();
        }
        }
 }
  


  mysql_close();
  
header("Refresh: 2; url=../masses_details.php?num_commande=".$num_commande);                // la livraison a bien fonctionné,on informe l'utilisateur et on redirige .
echo "livraison enregistr&eacutee, vous allez &ecirctre redirig&eacute dans 2 secondes";
  exit();
  
  
  
  
$sql = "SELECT p.reference_piece, p.designation_piece, c.quantite_piece FROM PIECE p, COMPREND c, COMMANDE co
        WHERE co.no_commande=c.no_commande AND p.reference_piece=c.reference_piece AND co.no_commande=".$num_commande." AND c.libelle_type_piece='pieces environnement';";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

while($data = mysql_fetch_assoc($req)){

        $sql_quantite1="SELECT SUM(quantite_livree) AS quantite FROM LIVRAISON WHERE reference_piece='".$data['reference_piece']."' 
                            AND no_commande='".$num_commande."';"; 
        $resultat_quantite1= mysql_query($sql_quantite1) or die('Erreur SQL !<br>'.$sql_quantite1.'<br>'.mysql_error());
        $data2=mysql_fetch_assoc($resultat_quantite1);

        $reste1=$data['quantite_piece']-$data2['quantite'];    

		$reste_total2=$reste_total2+$reste1;
	  }
//fermeture automatique

for($i =0;$i<$data; $i++)
{
	$reste_total3=$reste_total1+$reste_total2;
}

if($reste_total=0)
{
	$sql="UPDATE COMMANDE SET id_utilisateur_ferme='".$_GET['vali']."', heure_fermeture='".$_GET['hour']."', date_fermeture='".$_GET['date']."', motif_fermeture='".$_POST['MotifFermetureCM']."' WHERE no_commande = '".$_GET['num_commande']."'";
$req=mysql_query($sql) or die('Erreur SQL : <br />'.$sql.mysql_error());

	echo "La commande a $eacute;t&eacute; fermeacute; automatiquement ";
 
}
 
  ?>
