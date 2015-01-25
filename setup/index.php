<?php
	include "../includes/db.php";
	include "../includes/include.php";
?>
<h1>Brens Awesome Dynamic Forms Setup Wizard</h1>

<?php
	//Get Database Connection
	$db = getDB();
	$dbName = DATABASE_NAME;
	
	if( DATABASE_NAME == "" ){
		echo "<p>Database name not defined</p>";
		logMessage( "Database name not defined" , "setup.txt" );
		exit;
	}
	
	echo "<p>Beginning Setup...</p>";
	
	/*Check if Table Exists*/
	logMessage( "Checking for Table '".$dbName."'" , "setup.txt" );
	if( dbExists($db,$dbName) == 0  ){
		
		echo "<p>Database '".$dbName."' doesn't exist. Creating it...</p>";
		logMessage( "Database '".$dbName."' doesn't exist. Creating it..." , "setup.txt" );
		
		/*Create Database*/
		try{
			$db->exec("create database ".$dbName);
			echo "<p>Database Created!...</p>";
			logMessage( "Database ".$dbName." created!" , "setup.txt" );
		}catch (Exception $e) {
			echo "<p>Database could not be created!</p>";
			logMessage( "Database ".$dbName." could not be created!" , "setup.txt" );	
			exit;
		}
		
		$db = getDB();
		
		/*Verify database*/
		if( dbExists($db,$dbName) == 1 ){
			echo "<p>Creation of '".$dbName."' verified!...</p>";
			logMessage( "Database '".$dbName."' verified!" , "setup.txt" );
		}else{
			echo "<p>Creation of '".$dbName."' could not be verified...</p>";
			logMessage( "Database '".$dbName."' could not be verified..." , "setup.txt" );
			exit;
		}
		
	}else{
		echo "<p>Database: '".$dbName."' exists, continuing...</p>";	
	}
	
	/*Create Tables*/
	
	echo '<p>Creating Tables...</p>';
	
	$db = getConnection();
	
	$query = "CREATE TABLE  `theform` (
				`id` INT NULL DEFAULT NULL AUTO_INCREMENT PRIMARY KEY,
				`owner` VARCHAR( 60),
				`title` VARCHAR( 45 ),
				`description` VARCHAR( 150),
				`encrypt_all` INTEGER,
				`created` DATETIME,
				`enabled` INTEGER,
				`sunrise` DATETIME,
				`sunset` DATETIME
				);";
	
	createAndTestTable($db, "theform", $query);
	
	$query = "CREATE TABLE  `formobject` (
				`id` INT NULL DEFAULT NULL AUTO_INCREMENT PRIMARY KEY,
				`type` INTEGER,
				`label` VARCHAR( 60 ),
				`name` VARCHAR( 60 ),
				`default` VARCHAR( 60 ),
				`errorText` VARCHAR( 150 ),
				`placeholder` VARCHAR( 60 ),
				`regex` VARCHAR( 255 ),
				`minValue` INTEGER,
				`maxValue` INTEGER,
				`minLength` INTEGER,
				`maxLength` INTEGER,
				`classes` VARCHAR( 150 ),
				`required` INTEGER,
				`encrypted` INTEGER,
				`formID` INTEGER,
				`order` INTEGER
				);";
	
	createAndTestTable($db, "formobject", $query);
	
	$query = "CREATE TABLE  `formobjecttype` (
				`id` INT NULL DEFAULT NULL AUTO_INCREMENT PRIMARY KEY,
				##`isListType` INTEGER,
				##`html` VARCHAR( 45 ),
				##`listItems` VARCHAR( 45 ),
				`value` VARCHAR( 45 ),
				`formID` INTEGER,
				`objectID` INTEGER
				);";
	
	createAndTestTable($db, "formobjecttype", $query);
	
	
	echo "<p>Setup Complete... Login <a href='../index.php'>here</a></p>";
	

?>