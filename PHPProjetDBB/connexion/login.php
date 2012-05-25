<?php
session_start();
include('_connexion.php');
mysql_query("SET NAMES UTF8");


$loginOK = false; 

if (isset($_POST['login']) && isset($_POST['password']))
{
if (!empty($_POST['login'])) && (!empty($_POST['password'])) {

  $sql = "SELECT id_utilisateur FROM UTILISATEUR WHERE id_utilisateur = '".$_POST['login']."'";
  $req = mysql_query($sql) or die('Erreur SQL : <br />'.$sql);

  if (mysql_num_rows($req) == 0) {
     header("Location: page.php?err=Login");
   }
  $sql = "SELECT u.id_utilisateur, u.prenom_utilisateur, u.nom_utilisateur, u.service_utilisateur, u.no_telephone, u.mdp_utilisateur
          FROM UTILISATEUR u WHERE u.id_utilisateur = '".$_POST['login']."';";
  $req = mysql_query($sql) or die('Erreur SQL : <br />'.$sql);

  if (mysql_num_rows($req) > 0) 
  {
  
     $data = mysql_fetch_array($req);
    // On v�rifie que son mot de passe est correct

    if (md5($_POST['password'])== $data['mdp_utilisateur']) {
      $loginOK = true;
    }
    else{
    	header("Location: page.php?err=mdp");
    	}
  }
}
}

  $sql1 = "SELECT no_droit FROM POSSEDE WHERE id_utilisateur = '".$_POST['login']."';";
  $req1 = mysql_query($sql1) or die('Erreur SQL : <br />'.$sql);
// Si le login a �t� valid� on met les donn�es en sessions
if ($loginOK) {
	
  $_SESSION['id'] = $data['id_utilisateur'];
  $_SESSION['prenom'] = $data['prenom_utilisateur'];
  $_SESSION['nom'] = $data['nom_utilisateur'];
  $_SESSION['service'] = $data['service_utilisateur'];
  $_SESSION['telephone'] = $data['no_telephone'];
  
    $droit=array();
	$i=0;
	while($d=mysql_fetch_array($req1))
	{
		$droit[$i]=$d[0];
		$i++;
	}
    if(!empty($droit)){
	$_SESSION['no_droit'] = $droit;
  }
  else{
  $droit[0]=15;
  $_SESSION['no_droit']=$droit;
  }
   header("Location: ../commande/accueil.php");

}

?>
