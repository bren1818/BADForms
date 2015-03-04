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
			echo "<h2>Could not conntect to database...</h2>";
			echo "<p>Please have a look at the &ldquo;privateKeys.php&rdquo; file and ensure database credentials are up to date.</p>";
			echo "<p>Specified error: ".$e->getMessage()."</p>";
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
			
			pageHeader("Database Error");
			
			echo "<h2><i class='fa fa-exclamation-triangle'></i> Could not conntect to database...</h2>";
			echo "<p>Please have a look at the &ldquo;<b>privateKeys.php</b>&rdquo; file and ensure database credentials are up to date.</p>";
			echo "<p><b>Specified error</b>: <i class='fa fa-terminal'></i>  <i>".$e->getMessage()."</i></p>";
			echo "<br /><p><a class='btn' href=''><i class='fa fa-spin fa-refresh'></i> Retry</a></p>";
			pageFooter();
			
			if( !file_exists( LOG_DIR) ){
				mkdir( LOG_DIR );
			}
			logMessage($e->getMessage(), "error.txt");
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
			logMessage('Table: '.$tableName.' already exists', "setup.txt", "" ,"");
		}else{
			echo '<p><i class="fa fa-table"></i> Creating `'.$tableName.'` table...</p>';
			logMessage('Creating: '.$tableName.' table', "setup.txt", "" ,"");
			$db->exec( $query );
		
			if( tableExists($db, $tableName) ){
				echo "<p><i class='fa fa-check'></i> Created `".$tableName."` table</p>";
				logMessage('Created: '.$tableName.' table', "setup.txt", "" ,"");
			}else{
				echo "<p><i class='fa fa-times'></i> Could not create `".$tableName."` table</p>";
				logMessage('Error could not create: '.$tableName.' table', "setup.txt", "" ,"");
			}
		}
	}
	
	
	
	
	
	
	
?>