<?php
	//include "../includes/db.php";
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
	
	//tool tip
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
	
	$query = "CREATE TABLE  `objecttype` (
				`id` INT NULL DEFAULT NULL AUTO_INCREMENT PRIMARY KEY,
				`name` VARCHAR( 45 ),
				`description` VARCHAR( 45 ),
				`isListType` INTEGER,
				`ordered` INTEGER
				);";
				
	createAndTestTable($db, "objecttype", $query);
	
	echo "<p>Creating types...</p>";
	
	$query = "INSERT INTO `objecttype` (`id`, `name`, `description`, `isListType`, `ordered`) VALUES 
	(NULL, 'input', 			'Input box - max chars 60', '0', '1'),
	(NULL, 'textarea', 			'Textarea  - max chars 255', '0', '2'),
	(NULL, 'checkboxsingle', 	'Checkbox - single choice', '0', '3'),
	(NULL, 'checkboxmutiple', 	'Checkbox - list', '1', '4'),
	(NULL, 'selectbox', 		'Select box', '1', '5'),
	(NULL, 'radiobutton', 		'Radio Button', '1', '6'),
	(NULL, 'date', 				'Date Picker', '0', '7'),
	(NULL, 'time', 				'Time Picker', '0', '8'),
	(NULL, 'datetime', 			'Date & Time Picker', '0', '9')
	;";
	
	//multi-select
	//hidden - email on submit (admin submit)
	//slider - range
	//visible - email on submit (user submit)
	//file
	//phone number
	//email format
	
	
	//list items
	
	
	
	$query = $db->prepare($query);
	if( $query->execute() ){
		$count = $query->rowCount();
		echo "<p>Created ".$count." object types</p>";
	}
	
	
	echo "<p>Setup Complete... Login <a href='../index.php'>here</a></p>";
	

?>