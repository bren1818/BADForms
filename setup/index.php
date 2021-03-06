<?php
	//echo $_SERVER["REQUEST_URI"];
	
	//exit;

	include "../includes/include.php";
	pageHeader();
?>
<h1><i class="fa fa-puzzle-piece"></i> Bren's Building Block Forms</h1>
<h3>Setup Wizard <i class="fa fa-magic"></i></h3>
<?php
	set_time_limit(0);
	
	logMessage("Beginning Database setup!", "setup.txt", "", "");
	
	//Get Database Connection
	$db = getDB();
	$dbName = DATABASE_NAME;
	
	if( DATABASE_NAME == "" ){
		echo "<p><i class='fa fa-database'></i> Database name not defined - update the private settings file.</p>";
		logMessage( "Database name not defined" , "setup.txt", "","" );
		exit;
	}
	
	echo "<p><i class='fa fa-cog fa-spin'></i> Beginning Setup...</p>";
	flush();
	
	/*Check if Table Exists*/
	logMessage( "Checking for Table '".$dbName."'" , "setup.txt" , "", "");
	if( dbExists($db,$dbName) == 0  ){
		
		echo "<p><i class='fa fa-database'></i> Database '".$dbName."' doesn't exist. Creating it...</p>";
		logMessage( "Database '".$dbName."' doesn't exist. Creating it..." , "setup.txt" , "" ,"");
		
		/*Create Database*/
		try{
			$db->exec("create database ".$dbName);
			echo "<p><i class='fa fa-database'></i> Database Created!...</p>";
			logMessage( "Database ".$dbName." created!" , "setup.txt" , "" ,"");
		}catch (Exception $e) {
			echo "<p><i class='fa fa-exclamation-triangle'></i> Database could not be created!</p>";
			logMessage( "Database ".$dbName." could not be created!" , "setup.txt" , "" ,"");	
			exit;
		}
		
		$db = getDB();
		
		/*Verify database*/
		if( dbExists($db,$dbName) == 1 ){
			echo "<p><i class='fa fa-check'></i> Creation of '".$dbName."' verified!...</p>";
			logMessage( "Database '".$dbName."' verified!" , "setup.txt", "" ,"" );
		}else{
			echo "<p><i class='fa fa-exclamation-triangle'></i> Creation of '".$dbName."' could not be verified...</p>";
			logMessage( "Database '".$dbName."' could not be verified..." , "setup.txt", "" ,"" );
			exit;
		}
		
	}else{
		echo "<p><i class='fa fa-database'></i> Database: '".$dbName."' exists, exitting...</p>";
		logMessage( "Someone trying to re-run setup. Database '".$dbName."' already exists. Exitting Setup..." , "error.txt", "" ,"" );
		echo "<p><a class='btn' href='/'><i class='fa fa-sign-out'></i> Home</a></p>";
		pageFooter();
		exit;	
	}
	
	/*Create Tables*/
	flush();
	
	echo '<p><i class="fa fa-table"></i> Creating Tables...</p>';
	flush();
	$db = getConnection();
	
	//user table
	$query = "CREATE TABLE IF NOT EXISTS `admin` (
			`id` INT NULL DEFAULT NULL AUTO_INCREMENT PRIMARY KEY,
			`username` VARCHAR( 60 ),
			`password` VARCHAR( 60 ),
			`salt` VARCHAR( 60 ),
			`email` VARCHAR( 60 ),
			`userLevel` INTEGER,
			`creationDate` DATETIME,
			`lastLogin` DATETIME,
			`enabled` INTEGER
			);";
				
	createAndTestTable($db, "admin", $query);
	
	ob_flush();
	flush();
	
	
		$query = "CREATE TABLE  `theform` (
			`id` INT NULL DEFAULT NULL AUTO_INCREMENT PRIMARY KEY,
			`title` VARCHAR( 60 ),
			`description` VARCHAR( 60 ),
			`encryptionMode` INTEGER,
			`encryptionSalt` VARCHAR( 60 ),
			`created` DATETIME,
			`lastUpdated` DATETIME,
			`enabled` INTEGER,
			`sunrise` DATETIME,
			`sunset` DATETIME,
			`jqVersion` VARCHAR( 10 ),
			`jqTheme` VARCHAR( 60 ),
			`owner` INTEGER,
			`isPrivate` BOOLEAN,
			`isGroup` BOOLEAN,
			`useCaching` BOOLEAN,
			`usePreviewCSS` BOOLEAN,
			`lastCacheTime` DATETIME,
			`notActiveText` VARCHAR( 255 ),
			`notAvailableText` VARCHAR( 255 ),
			`expiredText` VARCHAR( 255 ),
			`submissionText` VARCHAR( 255 ),
			`numViews` INTEGER,
			`numSubmissions` INTEGER
			);";
				

	
	createAndTestTable($db, "theform", $query);
	
	ob_flush();
	flush();
	//tool tip
	$query = "CREATE TABLE  `formobject` (
			`id` INT NULL DEFAULT NULL AUTO_INCREMENT PRIMARY KEY,
			`formID` INTEGER,
			`type` INTEGER,
			`label` VARCHAR( 60 ),
			`name` VARCHAR( 60 ),
			`defaultVal` VARCHAR( 60 ),
			`errorText` VARCHAR( 60 ),
			`placeholder` VARCHAR( 60 ),
			`regex` VARCHAR( 255 ),
			`minVal` INTEGER,
			`maxVal` INTEGER,
			`minLength` INTEGER,
			`maxLength` INTEGER,
			`listType` INTEGER,
			`listID` INTEGER,
			`csList` VARCHAR( 255 ),
			`reuseableType` INTEGER,
			`reuseableID` INTEGER,
			`classes` VARCHAR( 60 ),
			`required` INTEGER,
			`encrypted` INTEGER,
			`rowOrder` INTEGER,
			`lastUpdated` DATETIME,
			`publicFormObject` BOOLEAN,
			`genericUseID` INTEGER,
			`genericUseText` VARCHAR( 255 )
			);";
	
	
	
	
	ob_flush();flush();
	
	createAndTestTable($db, "formobject", $query);
	
	$query = "CREATE TABLE  IF NOT EXISTS `objecttype` (
		`id` INT NULL DEFAULT NULL AUTO_INCREMENT PRIMARY KEY,
		`name` VARCHAR( 45 ),
		`description` VARCHAR( 45 ),
		`isListType` INTEGER,
		`hasReturn` INTEGER,
		`ordered` INTEGER
		);";
				
	createAndTestTable($db, "objecttype", $query);
	
	ob_flush();flush();
	
	echo "<p><i class='fa fa-bars'></i> Creating types...</p>";
	
	$query = "INSERT INTO `objecttype` (`id`, `name`, `description`, `isListType`, `hasReturn`, `ordered`) VALUES 
		(NULL, 'no-type-select', 	'-=Select=-', 				 '0', '0', '0'),
		(NULL, 'labelField', 		'Label Field', 				 '0', '0', '1'),
		(NULL, 'input', 			'Input box - max chars 60',  '0', '1', '1'),
		(NULL, 'textarea', 			'Textarea  - max chars 255', '0', '1', '2'),
		(NULL, 'checkboxsingle', 	'Checkbox - single choice',  '0', '1', '3'),
		(NULL, 'checkboxmutiple', 	'Checkbox - list', 			 '1', '1', '4'),
		(NULL, 'selectbox', 		'Select box', 				 '1', '1', '5'),
		(NULL, 'radiobutton', 		'Radio Button', 			'1', '1', '6'),
		(NULL, 'datepicker', 		'Date Picker', 				'0', '1','7'),
		(NULL, 'datetimepicker', 	'Date & Time Picker', 		'0','1', '8'),
		(NULL, 'timepicker', 		'Time Picker', 				'0','1', '9'),
		(NULL, 'rangeslider', 		'Range Slider', 			'0','1', '10'),
		(NULL, 'hidden', 			'Hidden', 					'0', '1','11'),
		(NULL, 'email', 			'Email', 					'0','1', '12'),
		(NULL, 'phone', 			'Phone Number', 			'0','1', '13'),
		(NULL, 'selectboxJQ', 		'Select Box - JQuery UI', 	'0','1', '14'),
		(NULL, 'htmlChunk', 		'HTML Code', 				'0','1', '15'),
		(NULL, 'cssChunk', 			'CSS Code', 				'0','1', '16'),
		(NULL, 'group', 			'Form Group', 				'0', '1','17'),
		(NULL, 'formItem', 			'Re-useable Form Item', 	'0','1', '18'),
		(NULL, 'fileupload', 		'File Upload', 				'0', '1','19'),
		(NULL, 'numberInput', 		'Number',	 				'0','1', '20');";
		
	

	//list items
	
	$query = $db->prepare($query);
	if( $query->execute() ){
		$count = $query->rowCount();
		echo "<p><i class='fa fa-plus'></i> Created ".$count." object types</p>";
	}
	
	ob_flush();flush();
	
	
	$query = "CREATE TABLE  IF NOT EXISTS `formcode` (
		`id` INT NULL DEFAULT NULL AUTO_INCREMENT PRIMARY KEY,
		`formID` INTEGER,
		`codeType` INTEGER,
		`version` INTEGER,
		`code` LONGTEXT,
		`lastUpdate` DATETIME
		);";
	
	createAndTestTable($db, "formcode", $query);
	
	ob_flush();flush();
	
	$query = "CREATE TABLE IF NOT EXISTS `jquerythemes` (  `themeName` varchar(55) NOT NULL,  `themeVersion` varchar(6) NOT NULL);";
	
	createAndTestTable($db, "jquerythemes", $query);
	
	ob_flush();flush();
	
	$query = "INSERT INTO `jquerythemes` (`themeName`, `themeVersion`) VALUES  ('black-tie', '1.11.2'), ('blitzer', '1.11.2'), ('cupetino', '1.11.2'), ('dark-hive', '1.11.2'), ('dot-luv', '1.11.2'), ('eggplant', '1.11.2'), ('excite-bike', '1.11.2'), ('flick', '1.11.2'), ('hot-sneaks', '1.11.2'), ('humanity', '1.11.2'), ('le-frog', '1.11.2'), ('mint-choc', '1.11.2'), ('overcaset', '1.11.2'), ('pepper-grinder', '1.11.2'), ('redmond', '1.11.2'), ('smoothness', '1.11.2'), ('south-street', '1.11.2'), ('start', '1.11.2'), ('sunny', '1.11.2'), ('swanky-purse', '1.11.2'), ('ui-darkness', '1.11.2'), ('trontastic', '1.11.2'), ('ui-darkness', '1.11.2'), ('ui-lightness', '1.11.2'), ('vader', '1.11.2');";
	
	$query = $db->prepare($query);
	if( $query->execute() ){
		$count = $query->rowCount();
		echo "<p><i class='fa fa-plus'></i> Added ".$count." jquery themes</p>";
	}
	
	ob_flush();flush();
	
	$query = "CREATE TABLE  IF NOT EXISTS `listset` (
		`id` INT NULL DEFAULT NULL AUTO_INCREMENT PRIMARY KEY,
		`listName` VARCHAR( 60 ),
		`listType` INTEGER,
		`defaultValue` VARCHAR( 60 ),
		`owner` INTEGER,
		`private` INTEGER
		);";
	
	createAndTestTable($db, "listset", $query);
	
	ob_flush();flush();
	
	$query = "CREATE TABLE IF NOT EXISTS `listitem` (
		`id` INT NULL DEFAULT NULL AUTO_INCREMENT PRIMARY KEY,
		`listID` INTEGER,
		`item` VARCHAR( 60 ),
		`rowOrder` INTEGER
		);";
	
	createAndTestTable($db, "listitem", $query);
	
	ob_flush();flush();
	
	$query = "CREATE TABLE   IF NOT EXISTS `listitemkv` (
		`id` INT NULL DEFAULT NULL AUTO_INCREMENT PRIMARY KEY,
		`listID` INTEGER,
		`itemkey` VARCHAR( 60 ),
		`item` VARCHAR( 60 ),
		`rowOrder` INTEGER);";
		
	createAndTestTable($db, "listitemkv", $query);

	ob_flush();flush();
	
	
	$query = "CREATE TABLE  `formrecordentryrow` (
		`id` INT NULL DEFAULT NULL AUTO_INCREMENT PRIMARY KEY,
		`formID` INTEGER,
		`recordNumber` INTEGER,
		`entryTime` DATETIME,
		`remoteIP` VARCHAR( 60 ),
		`remoteSession` VARCHAR( 60 )
		);";
		
	createAndTestTable($db, "formrecordentryrow", $query);

	ob_flush();flush();
			
	
	$query = "CREATE TABLE  `formentryvalue` (
		`id` INT NULL DEFAULT NULL AUTO_INCREMENT PRIMARY KEY,
		`rowID` INTEGER,
		`formID` INTEGER,
		`formKey` INTEGER,
		`formKeyName` VARCHAR( 60 ),
		`encrypted` BOOLEAN,
		`formValue` LONGTEXT
		);";
		
	createAndTestTable($db, "formentryvalue", $query);

	ob_flush();flush();
	
	
	$query = "CREATE TABLE IF NOT EXISTS `formentry` (
			`id` INT NULL DEFAULT NULL AUTO_INCREMENT PRIMARY KEY,
			`formID` INTEGER,
			`saveTime` TIMESTAMP,
			`remoteIP` VARCHAR( 20 ),
			`remoteSession` VARCHAR( 45 )
			);";
		
	createAndTestTable($db, "formentry", $query);

	ob_flush();flush();
	
	
	$query = "CREATE TABLE IF NOT EXISTS `formsavejson` (
			`id` INT NULL DEFAULT NULL AUTO_INCREMENT PRIMARY KEY,
			`entryID` INTEGER,
			`data` LONGTEXT
			);";
					
	createAndTestTable($db, "formsavejson", $query);

	ob_flush();flush();
	
	
	
	
	//Create user...
	$pass = getUniqueID();
	
	$admin = new Admin($db);
	
	$admin->setUsername("admin");
	$admin->setPassword( md5($pass."badForms") );
	
	if( $admin->save() > 0 ){
	
		echo "<p>Setup Complete...<i class='fa fa-check'></i></p>
		 <br /><br />
			<p><a class='btn' href='firstUser.php?first=".$pass."'><i class='fa fa-sign-out'></i> Finish Setup & Create Admin</a></p><br /><br />";		
	}else{
		echo "<p>Admin user could not be created! please see setup log</p>";
		//uh oh
	}
	
	//setup first user
	//create salt
	
	logMessage("Database Setup Complete!", "setup.txt", "" ,"");
	pageFooter();
?>