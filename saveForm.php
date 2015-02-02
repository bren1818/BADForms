<?php
	require_once( "includes/include.php" );
	//check owner id
	$formID = $_POST['formID'];
	$formDATA = json_decode($_POST['form']);
	$con = getConnection();
	
	$ret = array();
	
	$updated = 0;
	$new = 0;
	$failed = 0;
	
	$types = "Select `id`, `isListType` FROM `objecttype`";
	$types = $con->query( $types );
	$listTypes = array();
	if( $types->execute() ){
		while( $result = $types->fetch(PDO::FETCH_ASSOC) ){
			$listTypes[ $result['id'] ] = $result['isListType'];
		}
	}
	
	//pa( $listTypes );
	
	
	//exit;
	if( sizeof($formDATA) >= 1 ){
		foreach( $formDATA as $Formobject){
			//echo "formRow";
			$rowObj = new Formobject($con);
			
			$fo = (array)$Formobject;
			
			$rowObj->getFromArray( $fo );
			$rowObj->setId( $fo['id'] );
			
			if( $fo['id'] == ""){
				$new++;
			}
			
			$type = $rowObj->getType();
			
			if( isset( $listTypes ) && isset($type) && $type != "" && isset($listTypes[$type]) ){
				if( $listTypes[$type] == 1 ){
					//its a valid list type object
					
					//check what type [listID] or [csList] should be cleared
					
				}else{
					$rowObj->setListType( null ); //notta list type
				}
			}
			
			$id = $rowObj->save(); 
			if( $id > 0 ){
				//echo "Saved";
				$updated++;
			}else{
				$failed++;
			}
			
			$tempID = $fo['tempID'];	
			$ret[] = array("tempID"=>$tempID, "id" => $id, "fullRet" =>  $rowObj->asArray());
		
		}
		echo json_encode($ret);
	}	
?>