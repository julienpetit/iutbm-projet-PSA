<?php

mysql_query("SET NAMES UTF8");
function check_log_user($num_page,$num_commande)
{
	if(!isset($_SESSION['no_droit'])) {
		header("Location: /connexion/page.php"); 
		exit();
	}	
	
	$droit=$_SESSION['no_droit'];
	$page=$num_page;
	if($num_commande!=NULL){
		$commande=$num_commande;
	}

	if(isset($_SESSION['pseudo']) && isset($_SESSION['nom']))
	{

		if($page==1)
		{
			if(!in_array(1,$droit))
			{
				header("Location: /connexion/erreur.html.php");
				echo "vous ne possèdez pas les droits pour executer cette action <br/>";
				echo "<a href=\"../commande/accueil.php\">Accueil</a>";
				exit();
			}
		}

		if($page==2)
		{
			if(!in_array(2,$droit))
			{
				header("Location: /connexion/erreur.html.php");
				echo "vous ne possèdez pas les droits pour executer cette action <br/>";
				echo "<a href=\"../commande/accueil.php\">Accueil</a>";
				exit();
			}
		}


		if($page==4)
		{
			if(!in_array(2,$droit))
			{
				header("Location: /connexion/erreur.html.php");
				echo "vous ne possèdez pas les droits pour executer cette action <br/>";
				echo "<a href=\"../commande/accueil.php\">Accueil</a>";
				exit();
			}

		}

		if($page==5)
		{
			$sql1="SELECT code_type_commande FROM COMMANDE WHERE no_commande = '".$num_commande."'";
			$result1 = mysql_query($sql1);
			$row1 = mysql_fetch_array($result1);
			 
			if($row1['code_type_commande'])
			{
				if($row['code_type_commande']=='S')
				{

					if(!in_array(3,$droit))
					{
						header("Location: /connexion/erreur.html.php");
						echo "vous ne possèdez pas les droits pour executer cette action <br/>";
						echo "<a href=\"../commande/accueil.php\">Accueil</a>";
						exit();
					}

				}
				else if($row['code_type_commande']=='M')
				{

					if(!in_array(4,$droit))
					{
						header("Location: /connexion/erreur.html.php");
						echo "vous ne possèdez pas les droits pour executer cette action <br/>";
						echo "<a href=\"../commande/accueil.php\">Accueil</a>";
						exit();
					}
					 
				}
			}
		}

		if($page==6)
		{
			if(!in_array(5,$droit))
			{
				header("Location: /connexion/erreur.html.php");
				echo "vous ne possèdez pas les droits pour executer cette action <br/>";
				echo "<a href=\"../commande/accueil.php\">Accueil</a>";
				exit();
			}

		}


		if($page==7)
		{
			if(!in_array(6,$droit))
			{
				header("Location: /connexion/erreur.html.php");
				echo "vous ne possèdez pas les droits pour executer cette action <br/>";
				echo "<a href=\"../commande/accueil.php\">Accueil</a>";
				exit();
			}

		}

		if($page==8)
		{
			$sql1="SELECT code_type_commande FROM COMMANDE WHERE no_commande = '".$num_commande."'";
			$result1 = mysql_query($sql1);
			$row1 = mysql_fetch_array($result1);
			 
			if($row1['code_type_commande'])
			{
				if($row1['code_type_commande']=='M')
				{

					if(!in_array(7,$droit))
					{
						header("Location: /connexion/erreur.html.php");
						echo "vous ne possèdez pas les droits pour executer cette action <br/>";
						echo "<a href=\"../commande/accueil.php\">Accueil</a>";
						exit();
					}

				}

			}
		}

		if($page==9)
		{
			if(!in_array(8,$droit))
			{
				header("Location: /connexion/erreur.html.php");
				echo "vous ne possèdez pas les droits pour executer cette action <br/>";
				echo "<a href=\"../commande/accueil.php\">Accueil</a>";
				exit();
			}
		}
		if($page==12)
		{
			if(!in_array(9,$droit) && !in_array(10,$droit))
			{
				header("Location: /connexion/erreur.html.php");
				echo "vous ne possèdez pas les droits pour executer cette action <br/>";
				echo "<a href=\"../commande/accueil.php\">Accueil</a>";
				exit();
			}
		}
	}
}
?>
