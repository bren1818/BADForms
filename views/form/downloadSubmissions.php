<?php
	include "../../includes/include.php";
	$conn = getConnection();
	
	$fileType = "";
	$formID = "";
	$contentType = "";
	$extenstion = "";
	
	$errors = 0;
	$errrString = "";
	
	if( isset($_REQUEST) && isset($_REQUEST['formID']) && $_REQUEST['formID'] != "" ){
		$formID = $_REQUEST['formID'];
	}else{
		$errors++;
		$errrString.= "<p>A Form ID was not provided.</p>";
	}
	
	if( isset($_REQUEST) && isset($_REQUEST['fileType']) && $_REQUEST['fileType'] != "" ){
		$fileType = strtolower($_REQUEST['fileType']);
	}else{
		$errors++;
		$errrString.= "<p>A Filetype for export was not provided.</p>";
	}
	
	switch($fileType){
		case "txt":
			$contentType = "text/plain";
			$extenstion = "txt";
			break;
		case "xml":
			$contentType = "application/xml";
			$extenstion = "xml";
			break;
		case "json":
			$contentType = "application/json";
			$extenstion = "json";
			break;
		case "csv":
			$contentType = "text/csv";
			$extenstion = "csv";
			break;
		default :
			$errors++;
			$errrString.= "<p>Unknown Filetype requested</p>";
			break;
	}
	
	
	if( $errors > 0 ){
		pageHeader();
		echo '<h1>Error!</h1>';
		echo $errrString;
		pageFooter();
		exit;
	}else{
		ob_clean();
		
		header("Content-type: ".$contentType);
		header("Content-Disposition: attachment; filename=file.".$extenstion);
		header("Pragma: no-cache");
		header("Expires: 0");
		
	
		$query = "SELECT `fs`.`data`  FROM `formentry` as `fe` 
			INNER JOIN `formsavejson` as `fs` on `fs`.`entryID` = `fe`.`id`
			where `fe`.`formID` = :formID;";
			
		$query = $conn->prepare( $query );
		$query->bindParam(':formID', $formID);
		if( $query->execute() ){
			//$counter = 1;
			
			//header
			
			while( $row = $query->fetch() ){
				//echo pa(json_decode($row["data"]),1);
				if( $fileType == "xml" ){
					echo "<entry>";
				}
				
				if( $fileType == "json" ){
					echo $row["data"];
				}else{
						
					foreach( json_decode($row["data"]) as $key=>$value){
						$value = (array)$value;
						if( $fileType == "xml" ){
							echo "<".$value["name"].">".$value["value"]."</".$value["name"].">";
						}else if( $fileType == "txt"){
							echo $value["name"]." : ".$value["value"]."\n";
						}else if( $fileType == "csv" ){
							echo $value["value"].", ";
						}
					}
				}
				
				if( $fileType == "txt" ){
					echo "\n\n";
				}else if(  $fileType == "csv" ){
					echo "\n";
				}else if( $fileType == "xml" ){
					echo "</entry>";
				}

				//$counter++;	
			}
		}
		
		exit;
	}
?>