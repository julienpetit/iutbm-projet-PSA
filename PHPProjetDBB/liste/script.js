jQuery().ready(function(){
	
		$("#tableau_liste").dataTable({
			"oLanguage":{
				"sUrl":"../../include/js/development-bundle/dataTables.french.txt"
			},
			"aoColumns": [
			  			null,
			  			{ "sType": "fr_date" },
			  			null,
			  			null,
			  			{ "sType": "fr_date" },
			  			null,
			  			null
			],
			"aaSorting": [[ 1, "desc" ]]
		});
	}
);

//Functions for date sorting for DataTables
var months = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];

jQuery.fn.dataTableExt.oSort['fr_date-asc']  = function(a,b) {
	if (a == "") return 1;
	if (b == "") return -1;

	var ukDatea = a.split(' ');
	var ukDateb = b.split(' ');

	var x = (ukDatea[2]*10 + months.indexOf(ukDatea[1]) + ukDatea[0]) * 1;
	var y = (ukDateb[2]*10 + months.indexOf(ukDateb[1]) + ukDateb[0]) * 1;

	return (((x < y) ? -1 : (x > y) ?  1 : 0));
};

jQuery.fn.dataTableExt.oSort['fr_date-desc']  = function(a,b) {
	if (a == "") return 1;
	if (b == "") return -1;

	var ukDatea = a.split(' ');
	var ukDateb = b.split(' ');

	var x = (ukDatea[2]*10 + months.indexOf(ukDatea[1]) + ukDatea[0]) * 1;
	var y = (ukDateb[2]*10 + months.indexOf(ukDateb[1]) + ukDateb[0]) * 1;

	return (((x < y) ? 1 : (x > y) ?  -1 : 0));
};
