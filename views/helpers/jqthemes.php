<?php
	include "../../includes/include.php";
	
	if( isset($_REQUEST) && isset($_REQUEST['version']) &&  $_REQUEST['version'] != "" ){
		
		$version = trim($_REQUEST['version']);
		
		$conn = getConnection();
		
		if( strlen( $version ) > 6 || $version == "" ){
			$version = "1.11.2";
		}
		
		$query = $conn->query("SELECT DISTINCT `themeName` FROM  `jquerythemes` WHERE  `themeVersion` = '".$version."'");
		//$query->bindParam(":version", $version);
		
		
		if( $query->execute() ){
			
			//$count = $query->rowCount();
			
			//echo $count;
			//echo $version;
			
			while( $result = $query->fetch(PDO::FETCH_ASSOC) ){
				$array[] = $result["themeName"];
			}
			ob_clean();
			echo json_encode($array);
			exit;
		}else{
			echo "fail";	
		}
										
	}else{
		exit;
	}
?>