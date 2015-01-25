<?php
	require_once("privateKeys.php");

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

	function tableExists($db, $table) {
		// Try a select statement against the table
		// Run it in try/catch in case PDO is in ERRMODE_EXCEPTION.
		try {
			$query = "SHOW TABLES LIKE ':table';";
			$query = $db->prepare($query);
			$query->bindParam(':table', $table);
	
			$query->execute();
		} catch (Exception $e) {
			// We got an exception == table not found
			return FALSE;
		}

		// Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
		return $result !== FALSE;
	}	
?>