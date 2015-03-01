<?php
	include "../includes/include.php";
	pageHeader();
	
	echo $_REQUEST["first"];
	
	logMessage("Finalizing setup", "setup.txt", "" ,"");
	pageFooter();
?>