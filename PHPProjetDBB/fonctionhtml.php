<?php
function html_entete_fichier($titre,$fichierstyle,$fichierJava="",$fichierJava1="") {
	print("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\"
    \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\n
	<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\" >\n
	<head>\n
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n
	<title>".$titre."</title>\n
	<link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"iconeweb.ico\" />\n
    <meta http-equiv=\"Content-Style-Type\" content=\"text/css\" />\n
   	<link rel=\"stylesheet\" type=\"text/css\" href=\"".$fichierstyle."\" /> \n
	<link rel=\"stylesheet\" href=\"development-bundle/themes/base/jquery.ui.all.css\"/>

    <meta http-equiv=\"Content-Script-Type\" content=\"text/javascript\" /> \n
    <script src=\"jquery-1.3.1.js\" type=\"text/javascript\"></script> \n
    <script src=\"".$fichierJava."\" type=\"text/javascript\"></script> \n
    <script src=\"".$fichierJava1."\" type=\"text/javascript\"></script> \n
    <script src=\"../controle/controle.js\" type=\"text/javascript\"></script>
		<script src=\"development-bundle/jquery-1.6.2.js\" type=\"text/javascript\"></script>
		<script src=\"development-bundle/ui/jquery.ui.core.js\" type=\"text/javascript\"></script>
		<script src=\"development-bundle/ui/jquery.ui.widget.js\" type=\"text/javascript\"></script>
		<script src=\"development-bundle/ui/jquery.ui.datepicker.js\" type=\"text/javascript\"></script>
		
		<script type=\"text/javascript\" >
		$(function() {
			$('.datepicker' ).datepicker({
				dateFormat: 'dd-mm-yy'		
			});
		})
		
		</script>


    </head>\n");
}

?>
