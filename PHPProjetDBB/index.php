<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
	  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" > 
  <head> 
    <title>PSA Application - Page d'accueil</title> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <link rel="stylesheet" href="include/css/page.css" />  
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript" ></script>
    <script>
      $(document).ready(function(){
         $("TABLE td").mouseover(function(e){
            $("#txt").html($(this).attr("texte"));
            $("#txt").fadeIn("fast", function(){});
         });
         $("TABLE td").mouseout(function(e){
            $("#txt").html("");
            $("#txt").hide();
         }); 
      });
    </script>
  </head> 
  
  
  
  
  <body> 
    

    <div id="header">
      <img src="img/logo.png" width="900px" height="138px" /><br />
      <h1>GESTION DES COMMANDES</h1>
    </div>
      

    <div id="wrap">

      <br />
      <br />
      <br />
      <br />
      <br />

      <center>
	<TABLE cellspacing="10px">
	  <tr>
	    <td texte="Passer une commande de pièces en flux synchrone"><a href=""><img class="onebutton" src="include/css/img/cmd_pieces.jpg" width="80" height="80" border="0" /></a></td>
	    <td texte="Passer une commande de masse"><a href=""><img class="onebutton" src="include/css/img/cmd_masse.jpg" width="80" height="80" border="0" /></a></td>
	    <td texte="Visualiser une commande"><a href=""><img class="onebutton" src="include/css/img/visu_cmd.jpg" width="80" height="80" border="0" /></a></td>
	    <td texte="Modifier une commande"><a href=""><img class="onebutton" src="include/css/img/modif_cmd.jpg" width="80" height="80" border="0" /></a></td>
	    <td texte="Annuler une commande"><a href=""><img class="onebutton" src="include/css/img/annul_cmd.jpg" width="80" height="80" border="0" /></a></td>
	  </tr>
	  <tr>
	    <td texte="Déclarer la réception d'une commande de pièce synchrone"><a href=""><img class="onebutton" src="include/css/img/reception_cmd.jpg" width="80" height="80" border="0" /></a></td>
	    <td texte="Déclarer des livraisons de pièces"><a href=""><img class="onebutton" src="include/css/img/livraison_cmd.jpg" width="80" height="80" border="0" /></a></td>
	    <td texte="Fermer une commande"><a href=""><img class="onebutton" src="include/css/img/fermer_cmd.jpg" width="80" height="80" border="0" /></a></td>
	    <td texte="Lister des commandes"><a href=""><img class="onebutton" src="include/css/img/lister_cmd.jpg" width="80" height="80" border="0" /></a></td>
	    <td texte="Extraire des données"><a href=""><img class="onebutton" src="include/css/img/extraire_donnees.jpg" width="80" height="80" border="0" /></a></td>
	  </tr>
	  <tr>
	    <td texte="Mise à jour des données applicatives"><a href=""><img class="onebutton" src="include/css/img/maj_donnees_app.jpg" width="80" height="80" border="0" /></a></td>
	    <td></td>
	    <td></td>
	    <td></td>
	    <td texte="Quitter"><a href=""><img class="onebutton" src="include/css/img/quitter.jpg" width="80" height="80" border="0" /></a></td>
	  </tr>
	</TABLE>
      </center>

      <br />

      <div id="divtxt">
	<p id="txt"></p>
      </div>

      <br />
      <br />

    </div>
           
  
    <div id="footer">
      <hr />
      Site web réalisé par la superbe équipe de S3bisA2 - DUT INFO - IUT BM<br />
      We rock !
    </div>


  </body>


</html> 
