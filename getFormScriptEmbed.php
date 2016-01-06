<?php
	include "includes/include.php";
	$formID = "";
	$securityKey = "";
	
	if( isset($_REQUEST) && isset($_REQUEST['ID']) && $_REQUEST['ID'] != "" ){
		$formID = $_REQUEST['ID'];
	}
	
	if( isset($_REQUEST) && isset($_REQUEST['key']) && $_REQUEST['key'] != "" ){
		$securityKey = $_REQUEST['key'];
	}
	
	if( isset($_REQUEST) && isset($_REQUEST['jsync']) && $_REQUEST['jsync'] == 1 ){
		$Standalone_MODE = 0;
	?>	
	if (!window.jQuery) { 
		var jq = document.createElement('script'); jq.type = 'text/javascript';
		// Path to jquery.js file, eg. Google hosted version
		jq.src = '//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js';
		document.getElementsByTagName('head')[0].appendChild(jq);
	}
	window.onload = function() {
		console.log("Initializing Form Load");
		$(function(){
			$('#formContainer').load('<?php echo PUBLIC_SERVER_ADDRESS."/getForm.php?ID=".$formID."&key=".$securityKey; ?>&jsync=1');
		});
	}; 	
	<?php	
	}else{
		exit;
	}
?>