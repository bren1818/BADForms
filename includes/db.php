<?php
	//some instances may bark if date isn't set
	date_default_timezone_set("America/New_York");

	function getConnection() {
		$mode = DATABASE_MODE;
		
		if( $mode == 1 ){
			$dbName = LOCAL_DATABASE; 			//Database Name
			$dbUser = LOCAL_DATABASE_USER; 		//Database User
			$dbPass = LOCAL_DATABASE_PASS; 		//Database Password
			$dbHost = LOCAL_HOST;				//Database Host
		}else if( $mode == 2 ){	
			$dbName = STAGING_DATABASE; 		//Database Name
			$dbUser = STAGING_DATABASE_USER; 	//Database User
			$dbPass = STAGING_DATABASE_PASS; 	//Database Password
			$dbHost = STAGING_HOST;				//Database Host
		}else if( $mode == 3 ){
			$dbName = PRODUCTION_DATABASE; 		//Database Name
			$dbUser = PRODUCTION_DATABASE_USER; //Database User
			$dbPass = PRODUCTION_DATABASE_PASS; //Database Password
			$dbHost = PRODUCTION_HOST;			//Database Host
		}
		
		$dbc = null;
		try {
			$dbc = new PDO('mysql:host='.$dbHost.';dbname='.$dbName, $dbUser, $dbPass);
			$dbc->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		}
		catch(PDOException $e) {
			echo "<h2>An error has occurred connecting to the database (".$dbName.")</h2>";
			echo "<p>".$e->getMessage()."</p>";
			
			if( !file_exists( LOG_DIR) ){
				mkdir( LOG_DIR );
			}

			file_put_contents(LOG_DIR.DIRECTORY_SEPARATOR.'PDOErrorsLog.txt', $e->getMessage(), FILE_APPEND);
			die();
		}
		return $dbc;
	}
	
	function getDB(){
		$mode = DATABASE_MODE;
		
		if( $mode == 1 ){
			$dbName = LOCAL_DATABASE; 			//Database Name
			$dbUser = LOCAL_DATABASE_USER; 		//Database User
			$dbPass = LOCAL_DATABASE_PASS; 		//Database Password
			$dbHost = LOCAL_HOST;				//Database Host
		}else if( $mode == 2 ){	
			$dbName = STAGING_DATABASE; 		//Database Name
			$dbUser = STAGING_DATABASE_USER; 	//Database User
			$dbPass = STAGING_DATABASE_PASS; 	//Database Password
			$dbHost = STAGING_HOST;				//Database Host
		}else if( $mode == 3 ){
			$dbName = PRODUCTION_DATABASE; 		//Database Name
			$dbUser = PRODUCTION_DATABASE_USER; //Database User
			$dbPass = PRODUCTION_DATABASE_PASS; //Database Password
			$dbHost = PRODUCTION_HOST;			//Database Host
		}
		
		$dbc = null;
		try {
			$dbc = new PDO('mysql:host='.$dbHost, $dbUser, $dbPass);
			$dbc->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		}
		catch(PDOException $e) {
			echo "<h2>An error has occurred connecting to the host (".$dbHost.")</h2>";
			echo "<p>".$e->getMessage()."</p>";
			
			if( !file_exists( LOG_DIR) ){
				mkdir( LOG_DIR );
			}

			file_put_contents(LOG_DIR.DIRECTORY_SEPARATOR.'PDOErrorsLog.txt', $e->getMessage(), FILE_APPEND);
			die();
		}
		return $dbc;
	}

	function dbExists($db, $dbName) {
		$query = "SHOW DATABASES LIKE '$dbName';";
		$query = $db->prepare($query);
		if( $query->execute() ){
			$count = $query->rowCount();
			if($count > 0 ){
				return 1;
			}else{
				return 0;
			}
		}else{
			exit;
		}
	}

	function tableExists($db, $tableName){
		$query = "SHOW TABLES LIKE '$tableName';";
		$query = $db->prepare($query);
		if( $query->execute() ){
			$count = $query->rowCount();
			if($count > 0 ){
				return 1;
			}else{
				return 0;
			}
		}else{
			exit;
		}
	}
	
	function createAndTestTable($db, $tableName, $query){
		if( tableExists($db, $tableName) ){
			echo "<p><i class='fa fa-exclamation-triangle'></i> Table: '$tableName' already exists.</p>";
		}else{
			echo '<p><i class="fa fa-table"></i> Creating `'.$tableName.'` table...</p>';
	
			$db->exec( $query );
		
			if( tableExists($db, $tableName) ){
				echo "<p><i class='fa fa-check'></i> Created `".$tableName."` table</p>";
			}else{
				echo "<p><i class='fa fa-times'></i> Could not create `".$tableName."` table</p>";	
			}
		}
	}
	
	
	
	
	
	
	
?>