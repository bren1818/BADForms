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
				echo '<p><i class="fa fa-database"></i> Database Error - Database does not appear to exist, please run the <a class="btn" href="/setup/index.php"><i class="fa fa-magic"></i> setup wizard</a></p>';
				logMessage("Database not setup", "setup.txt");
			pageFooter();
			exit;
		}
	}
	
	$sessionManager = new adminSession();
	$sessionManager->setMaxLength( SESSION_LENGTH );
	$sessionManager->load();
	
	$currentUser = new Admin();
	
	if( $sessionManager->getExpired() ){
		//echo "Expired Session";
		$curLocation = $_SERVER["REQUEST_URI"];
		
		if( strpos($curLocation, "setup/") > 0 ||
			strpos($curLocation, "views/admin/login.php") > 0 || 
			strpos($curLocation, "views/admin/logout.php") > 0  ){
			//don't require the session
		}else{
			header("Location: /views/admin/login.php");
		}
	}else{
		$sessionManager->renew();
		if( $sessionManager->getCurrentUserID() != "" ){
			$conn = getConnection();
			$currentUser->setConnection($conn);
			$currentUser = $currentUser->load( $sessionManager->getCurrentUserID() );
		}
		
	}
	
?>