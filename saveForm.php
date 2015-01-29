<?php
require_once( "includes/include.php" );
	//check security key
	//check owner id

	//echo '<pre>'.print_r($_POST,true).'</pre>';
	$formID = $_POST['formID'];
	$formDATA = json_decode($_POST['form']);
	
	//echo '<pre>'.print_r($formDATA,true).'</pre>';
	
	$con = getConnection();
	
	if( sizeof($formDATA) >= 1 ){
		foreach( $formDATA as $Formobject){
			//echo "formRow";
			$rowObj = new Formobject($con);
			$rowObj->getFromArray( (array)$Formobject);
			//$rowObj->setId( 0 );
			
			echo $rowObj->printFormatted();
			
			if( $rowObj->save() > 0 ){
					echo "Saved";
			}
		}
	}
?>