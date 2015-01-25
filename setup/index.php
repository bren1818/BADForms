<?php
	include "../includes/db.php";
	include "../includes/include.php";
?>
<h1>Brens Awesome Dynamic Forms Setup Wizard</h1>

<?php
	//Get Database Connection
	$db = getDB();
	$table = DATABASE_TABLE;
	
	if( DATABASE_TABLE == "" ){
		echo "<p>Database name not defined</p>";
		logMessage( "Database name not defined" , "setup.txt" );
		exit;
	}
	
	echo "<p>Beginning Setup...</p>";
	
	/*Check if Table Exists*/
	logMessage( "Checking for Table '".$table."'" , "setup.txt" );
	if( !tableExists($db,$table) ){
		echo "<p>Table '".$table."' doesn't exist. Creating it...</p>";
		logMessage( "Table '".$table."' doesn't exist. Creating it..." , "setup.txt" );
		
		/*Create Table*/
		
	}else{
		echo "<p>Table: '".$table."' exists</p>";	
	}
	
	
	

?>