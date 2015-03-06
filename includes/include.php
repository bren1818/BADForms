<?php
	include "privateKeys.php";
	include INCLUDES_DIR.DIRECTORY_SEPARATOR."db.php";
	include INCLUDES_DIR.DIRECTORY_SEPARATOR."functions.php";
	include CLASSES_DIR.DIRECTORY_SEPARATOR."includes.php";
	include INCLUDES_DIR.DIRECTORY_SEPARATOR."template.php";
	
	$db = getDB();
	
	if( dbExists($db, DATABASE_NAME) == 0 ){
		$curLocation = $_SERVER["REQUEST_URI"];
		if( strpos($curLocation, "setup/index.php") > 0 ){
			//we're in the wizard
		}else{
			pageHeader();
				echo '<h1><i class="fa fa-exclamation-triangle"></i> Attention required!</h1>';
				echo '<p><i class="fa fa-database"></i> Database Error - Database does not appear to exist... please run the setup wizard.</p><p><br /><a class="btn" href="/setup/index.php"><i class="fa fa-magic"></i> Run Setup Wizard</a></p>';
				logMessage("Database not setup", "setup.txt");
			pageFooter();
			exit;
		}
	}
	
	$sessionManager = new adminSession();
	$currentUser = new Admin();
	
	
	
	
?>