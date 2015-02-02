<?php
	require_once( "includes/include.php" );
	//check owner id
	$formID = $_POST['formID'];
	$formDATA = json_decode($_POST['form']);
	$con = getConnection();
	
	$ret = array();
	
	if( sizeof($formDATA) >= 1 ){
		foreach( $formDATA as $Formobject){
			//echo "formRow";
			$rowObj = new Formobject($con);
			
			$fo = (array)$Formobject;
			
			$rowObj->getFromArray( $fo );
			//$rowObj->setId( 0 );
			
			//echo $rowObj->printFormatted();
			
			$id = $rowObj->save(); 
			if( $id > 0 ){
					//echo "Saved";
			}else{
				
			}
			
			$tempID = $fo['tempID'];	
			$ret[] = array("tempID"=>$tempID, "id" => $id, "fullRet" =>  $rowObj->asArray());
		
		}
		echo json_encode($ret);
	}	
?>