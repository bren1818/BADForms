<?php
	require_once( "includes/include.php" );
	//check owner id
	if( isset($_POST) && isset( $_POST['formID'] ) && $_POST['formID'] != ""){
		$formID = $_POST['formID'];
	}
	$formDATA = json_decode($_POST['form']);
	$con = getConnection();
	
	$ret = array();
	
	$updated = 0;
	$new = 0;
	$failed = 0;
	$deletes = 0;
	
	if( is_numeric($formID) ){
		$theForm = new Theform($con);
		$theForm = $theForm->load( $formID );
		if( $theForm->getId() > 0){
			$theForm->setLastUpdated( date('Y-m-d H:i:s') );
			$theForm->save();
		}
	}else{
		echo "Invalid ID";
		exit;
	}
	
	
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
			$deleted = 0;
			
			
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
			
			if( isset($fo['isDeleted']) && $fo['isDeleted'] == 1 ){
				if( $fo['id'] != "" ){
					$deleted = $rowObj->delete( $fo['id'] );
				}
			}
			
			if( $deleted == 0 ){
				$id = $rowObj->save();
			}
			
			 
			if( $id > 0 ){
				//echo "Saved";
				if( $deleted == 1 ){
					$deletes++;
				}else{
					$updated++;
				}
			}else{
				$failed++;
			}
			
			$tempID = $fo['tempID'];	
			$ret[] = array("tempID"=>$tempID, "id" => $id, "deleted" => $deleted, "fullRet" =>  $rowObj->asArray());
		
		}
		echo json_encode($ret);
	}	
?>