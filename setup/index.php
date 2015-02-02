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
`title` VARCHAR( 100 ),
`description` VARCHAR( 100 ),
`encryptionMode` INTEGER,
`encryptionSalt` VARCHAR( 100 ),
`created` DATETIME,
`enabled` INTEGER,
`sunrise` DATETIME,
`sunset` DATETIME,
`jqVersion` VARCHAR( 10 ),
`jqTheme` VARCHAR( 50 ),
`owner` INTEGER
);";
	
	createAndTestTable($db, "theform", $query);
	
	//tool tip
	$query = "CREATE TABLE  `formobject` (
`id` INT NULL DEFAULT NULL AUTO_INCREMENT PRIMARY KEY,
`type` INTEGER,
`label` VARCHAR( 55 ),
`name` VARCHAR( 55 ),
`defaultVal` VARCHAR( 55 ),
`errorText` VARCHAR( 55 ),
`placeholder` VARCHAR( 55 ),
`regex` VARCHAR( 255 ),
`minVal` INTEGER,
`maxVal` INTEGER,
`minLength` INTEGER,
`maxLength` INTEGER,
`listType` INTEGER,
`listID` INTEGER,
`csList` VARCHAR( 255 ),
`classes` VARCHAR( 100 ),
`required` INTEGER,
`encrypted` INTEGER,
`formID` INTEGER,
`rowOrder` INTEGER
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
	(NULL, 'no-type-select', 					'-=Select=-', '0', '0'),
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
	
	
	
	
	
	$query = "CREATE TABLE IF NOT EXISTS `formcode` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `formID` int(11) NOT NULL,  `codeType` int(11) NOT NULL,  `version` int(11) NOT NULL,  `code` longtext NOT NULL,  PRIMARY KEY (`id`) );";
	
	createAndTestTable($db, "formcode", $query);
	
	$query = "CREATE TABLE IF NOT EXISTS `jquerythemes` (  `themeName` varchar(55) NOT NULL,  `themeVersion` varchar(6) NOT NULL);";
	
	createAndTestTable($db, "jquerythemes", $query);
	
	$query = "INSERT INTO `jquerythemes` (`themeName`, `themeVersion`) VALUES ('base', '1.11.2'), ('black-tie', '1.11.2'), ('blitzer', '1.11.2'), ('cupetino', '1.11.2'), ('dark-hive', '1.11.2'), ('dot-luv', '1.11.2'), ('eggplant', '1.11.2'), ('excite-bike', '1.11.2'), ('flick', '1.11.2'), ('hot-sneaks', '1.11.2'), ('humanity', '1.11.2'), ('le-frog', '1.11.2'), ('mint-choc', '1.11.2'), ('overcaset', '1.11.2'), ('pepper-grinder', '1.11.2'), ('redmond', '1.11.2'), ('smoothness', '1.11.2'), ('south-street', '1.11.2'), ('start', '1.11.2'), ('sunny', '1.11.2'), ('swanky-purse', '1.11.2'), ('ui-darkness', '1.11.2'), ('trontastic', '1.11.2'), ('ui-darkness', '1.11.2'), ('ui-lightness', '1.11.2'), ('vader', '1.11.2');";
	
	$query = $db->prepare($query);
	if( $query->execute() ){
		$count = $query->rowCount();
		echo "<p>Added ".$count." jquery themes</p>";
	}
	
	
	echo "<p>Setup Complete... Login <a href='../index.php'>here</a></p>";
	

?>