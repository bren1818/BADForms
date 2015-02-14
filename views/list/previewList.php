<?php
	if( isset($_REQUEST) && $_REQUEST['listID']  != "" ){
		include "../../includes/include.php";
		$conn = getConnection();
		$listID = $_REQUEST['listID'];
		$listset = new Listset( $conn );
		$listset = $listset->load( $listID );
?>
<select>
<?php
	$default = $listset->getDefaultValue();

	if( $listset->getListType() == 1){ //1 key-val list
		$query = $conn->prepare("SELECT * FROM `listitemkv` WHERE `listID` = :listID order by `rowOrder` ASC");
		$object = "listitemkv";
	}else{								//0 val list
		$query = $conn->prepare("SELECT * FROM `listitem` WHERE `listID` = :listID order by `rowOrder` ASC");
		$object = "listitem";
	}
		
	$query->bindParam(':listID', $listset->getId());			
	echo '<option value=""> - </option>';
	if( $query->execute() ){
		while( $result = $query->fetchObject($object) ){
			 if( $listset->getListType() == 1){
    			//key value
				echo '<option value="'.$result->getItemKey().'" '.(trim($default) == trim($result->getItemKey()) ? ' selected' : '').'>'.$result->getItem().'</option>';
    		 }else if( $listset->getListType() == 0 ){
    			//value value
				echo '<option value="'.$result->getItem().'" '.(trim($default) == trim($result->getItemKey()) ? ' selected' : '').'>'.$result->getItem().'</option>';
    		 }
    	}
	}
	?>
</select>
<?php
	}else{
		echo "Could not preview list...";	
	}
?>