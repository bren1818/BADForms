<?php
	include "includes/include.php";
	
	
	if( isPostback() ){
	
		pa( $_POST );
	
		exit;
	}
?>