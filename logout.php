<?php
	error_reporting( E_ALL );
	
	require_once( "includes/include.php" );
	global $sessionManager;
	$sessionManager->destroy();

pageHeader("Logout");
	echo '<p>Logout Complete</p>';
pageFooter();	
?>