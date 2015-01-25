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
	
	
	

?>