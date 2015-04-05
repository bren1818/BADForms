<?php
	include "../../includes/include.php";
	$formID = $_REQUEST['formID'];
	$userID = $_REQUEST['userID'];
	$draw = $_REQUEST['draw'];
	$columns = $_REQUEST['draw'];
	$start = $_REQUEST['start'];
	$order = $_REQUEST['order'];
	$length = (int)$_REQUEST['length']; //10,25,50,100 
	$search = $_REQUEST['search'];
	
	$searchStr = "";
	if( $search["value"] != ""){
		$search = "%".$search["value"]."%";
		$searchStr = " AND `fs`.`data` LIKE :search ";	
	}
	
	$conn = getConnection();
	
	
	$requiredIDs;
	$query = $conn->prepare("SELECT fo.`id` FROM `formobject` fo
							LEFT JOIN `objecttype` ot ON ot.`id` = fo.`type`
							
							WHERE `formID` = :formID
							AND ot.`hasReturn` =  1
							order by `rowOrder`");
	$query->bindParam(':formID', $formID);
	if( $query->execute() ){
		while( $item = $query->fetch() ){
				//$formFields.= '<th>'.$item["id"].'</th>';
				$requiredIDs[] = $item['id'];
				
				//return type?
				
		}
	}
	
	//pa($requiredIDs);
	
	$recordsTotal = 0;
	$query = $conn->prepare("SELECT count(`id`) as `cnt` FROM `formentry` WHERE `formID` = :formID");
	$query->bindParam(':formID', $formID);
	if( $query->execute() ){
		$result = $query->fetch();
		$recordsTotal = (int)$result["cnt"];
	}
	 
	
	$query = $conn->prepare("SELECT `fs`.`data`, fe.`saveTime`, `fs`.`entryID`  FROM `formentry` as `fe` 
			INNER JOIN `formsavejson` as `fs` on `fs`.`entryID` = `fe`.`id`
			where `fe`.`formID` = :formID ".$searchStr." order by `fe`.`saveTime` DESC LIMIT :limit"); //
	$query->bindParam(':formID', $formID);
	if( $searchStr != ""){
	$query->bindParam(":search", $search, PDO::PARAM_STR);
	}
	$query->bindParam(':limit', $length, PDO::PARAM_INT);
	
	
	
	
	$recordsFiltered = 0;
	$data = array();
	
	if( $query->execute() ){
		//$recordsTotal = $query->rowCount();
		
		while( $row = $query->fetch() ){
			//echo '<tr>';
			$recordsFiltered++;
			
			$recordRow = array();
			
			//pa( $row );
			
			$recordRow[] = $row["entryID"];
			
			//$rowData = json_decode($row["data"]);
			
			//pa($rowData);
			
			//loop through required data keys - match on fieldObjectID
			
			foreach( $requiredIDs as $id){
				//echo "ID: ".$id;
				//if($rowData)
				$foundVal = "-";
				
				foreach( json_decode($row["data"]) as $key=>$value){
					
					//echo "Checking FOI: ".$id;
					
					$value = (array)$value;
					
					//pa($value);
					
					if( $value["fieldObjectID"] ==  $id ){
						
						
						
						if( $value["encrypted"] == 1 ){
							$val = $encryptor->decrypt( $value["value"] );
							$foundVal = $val;
						}else{
							$foundVal = $value["value"]; 
						}
						
							
					}
					
					//echo "$key -> $value";
					
					
				}
				$recordRow[] = $foundVal;
			}
			
			/*
			foreach( json_decode($row["data"]) as $key=>$value){
				
				//echo $key;
				
				
				$value = (array)$value;
				if( $value["encrypted"] == 1 ){
					$val = $encryptor->decrypt( $value["value"] );
					$recordRow[] = $val;
				}else{
					$recordRow[] = $value["value"]; 
				}
			}
			*/
			
			
			$data[] = $recordRow;	
		}
	}
	
	//ob_clean();
	echo json_encode( array( "draw" => (int)($draw), "recordsTotal" => $recordsTotal, "recordsFiltered" => $recordsFiltered, "data" => $data, "error" => "") ); 
	
	
	
	/*
	https://datatables.net/manual/server-side
	
	*/
?>