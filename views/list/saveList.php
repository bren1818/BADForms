<?php
	include "../../includes/include.php";
	$conn = getConnection();

	if( isPostback() ){
		$listID = ( isset($_POST) ? ( isset($_POST['listID']) ? $_POST['listID'] : ""  ) : "" ); 
		$tempID = ( isset($_POST) ? ( isset($_POST['tempID']) ? $_POST['tempID'] : ""  ) : "" ); 
		$listType = ( isset($_POST) ? ( isset($_POST['listType']) ? $_POST['listType'] : ""  ) : "" ); 
		$key = ( isset($_POST) ? ( isset($_POST['key']) ? $_POST['key'] : ""  ) : "" ); 
		$items = ( isset($_POST) ? ( isset($_POST['items']) ? json_decode($_POST['items']) : ""  ) : "" ); 
		
		if( md5( $listID.BASE_ENCRYPTION_SALT.$listType ) == $key ){
			//echo "listID : ".$listID." key: ".$key." list type: ".$listType;
			
			if( $listType == 1){ //Key-Value
				$listItem = new Listitemkv($conn);
			}else if( $listType == 0 ){ //Value-Value
				$listItem = new Listitem($conn);
			}
			
			$return = array();
			
			foreach( $items as $listValue ){
				$data = (array)$listValue;
				$deleted = 0;
				$id = "-1";
				
				$listItem->getFromArray( $data  );
				
				//pa( $listItem );
				
				if( isset( $data["id"] ) ){
					$listItem->setId( $data["id"] );
				}
				
				$listItem->setListId( $listID );
				
				//check if deleted -----------------------------------------------------------
				if( isset( $data["deleted"] ) && $data["deleted"] == 1  ){
					//$listItem->setId( $data["id"] );
					$deleted = $listItem->delete( $listItem->getId() );
				}else{
					if( $listItem->save() > 0 ){
						$id = $listItem->getId();
					}
				}
				
				$return[] = array("tempID"=>$data["tempID"],"id"=>$id,"deleted"=>$deleted);
				
			}
			
			if( $return != "" ){
				ob_clean();
				echo json_encode( $return );
			}else{
				echo "No Return";	
			}
		
		}else{
			echo "Invalid Post";	
		}
	}
	
	exit;
?>