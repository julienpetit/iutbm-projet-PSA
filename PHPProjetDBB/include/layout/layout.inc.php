<?php function header_html($title = "Projet PSA iutbm", $styles = array(), $scripts = array()) { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $title; ?></title>

<!-- Styles -->
<link href='/include/css/global.css' rel='stylesheet' type='text/css'>
<link href='/include/framework/foundation.css' rel='stylesheet' type='text/css'>
<?php foreach ($styles as $css) {
	echo "<link href='$css' rel='stylesheet' type='text/css'>\n";
}?>

<!-- Scripts -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript" ></script>
<?php foreach ($scripts as $js) {
	echo "<script src='$js' type='text/javascript'></script>\n";
}?>

</head>

<body>
	<div id='main'>
		<div id='header'>

		</div>
		<div id='wrap'>
			<h1><?php echo html($title); ?></h1>
<?php } 

function footer_html() { ?>
		</div>
		<div id='footer'>
		</div>
	</div>
</body>
</html>
<?php } ?>