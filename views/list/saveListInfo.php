<?php
	include "../../includes/include.php";
	$conn = getConnection();

	if( isPostback() ){ 
		$key = ( isset($_POST) ? ( isset($_POST['key']) ? $_POST['key'] : ""  ) : "" );
		$listID = ( isset($_POST) ? ( isset($_POST['listID']) ? $_POST['listID'] : ""  ) : "" ); 
 			$listType = ( isset($_POST) ? ( isset($_POST['listType']) ? $_POST['listType'] : ""  ) : "" ); 
			$formData = ( isset($_POST) ? ( isset($_POST['formData']) ? json_decode($_POST['formData']) : ""  ) : "" );
			
		if( md5( $listID.BASE_ENCRYPTION_SALT.$listType ) == $key ){
			
			
			
			$listSet = new listSet($conn);
			$listSet = $listSet->load( $listID );
			
			$formData = (array)$formData[0]; //first Item
			
			$default = $formData["defaultValue"];
			$visibility = $formData["private"];
			$name = $formData["listName"];
			
			
			$listSet->setListName( $name );
			$listSet->setDefaultValue( $default );
			$listSet->setPrivate( $visibility );
			
			
			if( $listSet->save() > 0 ){
				echo "Saved!";	
			}
		
		}else{
			echo "Invalid Post";	
		}
	}
	
	exit;
?>