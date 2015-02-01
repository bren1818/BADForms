<?php
require_once( "includes/include.php" );
	//check security key
	//check owner id

	//echo '<pre>'.print_r($_POST,true).'</pre>';
	$formID = $_POST['formID'];
	$formDATA = json_decode($_POST['form']);
	
	//echo '<pre>'.print_r($formDATA,true).'</pre>';
	
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
			
			$ret[] = array("tempID"=>$tempID, "id" => $id, "error" => $rowObj->getErrorText(), "fullRet" =>  $rowObj->asArray());
		
		}
	
		echo json_encode($ret);
	
	}
	
	
	
?>