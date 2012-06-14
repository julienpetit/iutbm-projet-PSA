<?php 

function header_html($title = "Projet PSA iutbm", $styles = array(), $scripts = array(), $accueil = false) { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $title; ?></title>

<!-- Styles -->
<link href='/include/css/global.css' rel='stylesheet' type='text/css'>
<link href='/include/framework/foundation.css' rel='stylesheet' type='text/css'>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<?php foreach ($styles as $css) {
	echo "<link href='$css' rel='stylesheet' type='text/css'>\n";
}?>

<!-- Scripts -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript" ></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

<?php foreach ($scripts as $js) {
	echo "<script src='$js' type='text/javascript'></script>\n";
}?>

<?php if($accueil) echo "<style>div#wrap { background: none; } </style>"?>
</head>
<body>
	<div id='bandeau_connexion'>
		<div id="info_content">
			<ul id='menu'>
				<li><a href='/' >Accueil</a></li>
			</ul>
			
			<ul id='infos'>
				
				<?php if(isset($_SESSION['id'])) 
					  {
					  	print_r_html($_SESSION);
					  	echo "<li>".html($_SESSION['id'])."</li>";
					  	echo "<li><a href='/connexion/deconnexion.php' >Déconnexion</a></li>";
					  }
					  else {
					  	echo "<li><a href='/connexion/page.php' >Connexion</a></li>";
					  }
				?>
			</ul>
		</div>
	</div>
	<div id='main'>
		<div id='header'>
			<img src="/include/css/img/logo.png" width="900px" height="138px" />
			<h1><?php echo $accueil ? "GESTION DES COMMANDES" : ""; ?></h1>
		</div>
		<div id='wrap'>
			<h1><?php echo !$accueil ? html($title) : ""; ?></h1>
<?php } 

function footer_html() { ?>
		</div>
		<div id='footer'>
		      <hr />
		      Site web réalisé par les étudiants de S3 bis A2 - DUT INFO - IUT BM<br />
		</div>
	</div>
</body>
</html>
<?php } ?>