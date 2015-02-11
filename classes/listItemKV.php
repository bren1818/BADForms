<?php
/*  Class Generated by Brendon Irwin's Class Generator

	Class: Listitemkv

	listID, i
	itemkey, v
	item, v
	rowOrder, i

*/

	class Listitemkv{
		private $id;
		private $connection;
		private $errors;
		private $errorCount;
		private $listID;
		private $itemkey;
		private $item;
		private $rowOrder;


		/*Constructor*/
		function __construct($databaseConnection=null){
			$this->connection = $databaseConnection;
		}

		/*Getters and Setters*/
		function getId(){
			return $this->id;
		}

		function setId($id){
			$this->id = $id;
		}

		function getConnection(){
			return $this->connection;
		}

		function setConnection($connection){
			$this->connection = $connection;
		}

		function getErrors(){
			return $this->errors;
		}

		function setErrors($errors){
			$this->errors = $errors;
		}

		function getErrorCount(){
			return $this->errorCount;
		}

		function setErrorCount($errorCount){
			$this->errorCount = $errorCount;
		}

		function getListID(){
			return $this->listID;
		}

		function setListID($listID){
			$this->listID = $listID;
		}

		function getItemkey(){
			return $this->itemkey;
		}

		function setItemkey($itemkey){
			$this->itemkey = $itemkey;
		}

		function getItem(){
			return $this->item;
		}

		function setItem($item){
			$this->item = $item;
		}

		function getRowOrder(){
			return $this->rowOrder;
		}

		function setRowOrder($rowOrder){
			$this->rowOrder = $rowOrder;
		}

		/*Special Functions*/
		function load($id = null){
			if( $this->connection ){
				if( $id == null && $this->getId() != ""){
					$id = $this->getId();
				}

				/*Perform Query*/
				if( $id != "" ){
					$query = $this->connection->prepare("SELECT * FROM `listitemkv` WHERE `id` = :id");
					$query->bindParam(':id', $id);
					if( $query->execute() ){
						$listitemkv = $query->fetchObject("listitemkv");
					}
					if( is_object( $listitemkv ) ){
						$listitemkv->setConnection( $this->connection );
					}
					return $listitemkv;
				}
			}
		}

		function getFromPost(){
			$this->setListID( (isset($_POST["listID"])) ? $_POST["listID"] : $this->getListID() );
			$this->setItemkey( (isset($_POST["itemkey"])) ? $_POST["itemkey"] : $this->getItemkey() );
			$this->setItem( (isset($_POST["item"])) ? $_POST["item"] : $this->getItem() );
			$this->setRowOrder( (isset($_POST["rowOrder"])) ? $_POST["rowOrder"] : $this->getRowOrder() );
		}

		function getFromRequest(){
			$this->setListID( (isset($_REQUEST["listID"])) ? $_REQUEST["listID"] : $this->getListID() );
			$this->setItemkey( (isset($_REQUEST["itemkey"])) ? $_REQUEST["itemkey"] : $this->getItemkey() );
			$this->setItem( (isset($_REQUEST["item"])) ? $_REQUEST["item"] : $this->getItem() );
			$this->setRowOrder( (isset($_REQUEST["rowOrder"])) ? $_REQUEST["rowOrder"] : $this->getRowOrder() );
		}

		function getFromArray($arr){
			$this->setListID( (isset($arr["listID"])) ? $arr["listID"] : $this->getListID() );
			$this->setItemkey( (isset($arr["itemkey"])) ? $arr["itemkey"] : $this->getItemkey() );
			$this->setItem( (isset($arr["item"])) ? $arr["item"] : $this->getItem() );
			$this->setRowOrder( (isset($arr["rowOrder"])) ? $arr["rowOrder"] : $this->getRowOrder() );
		}

		function compareTo($listitemkv){
			$log = array();
			if($this->getId() != $listitemkv->getId() ){
				$log["Id"] = "modified";
			}else{
				$log["Id"] = "un-modified";
			}
			if($this->getConnection() != $listitemkv->getConnection() ){
				$log["Connection"] = "modified";
			}else{
				$log["Connection"] = "un-modified";
			}
			if($this->getErrors() != $listitemkv->getErrors() ){
				$log["Errors"] = "modified";
			}else{
				$log["Errors"] = "un-modified";
			}
			if($this->getErrorCount() != $listitemkv->getErrorCount() ){
				$log["ErrorCount"] = "modified";
			}else{
				$log["ErrorCount"] = "un-modified";
			}
			if($this->getListID() != $listitemkv->getListID() ){
				$log["ListID"] = "modified";
			}else{
				$log["ListID"] = "un-modified";
			}
			if($this->getItemkey() != $listitemkv->getItemkey() ){
				$log["Itemkey"] = "modified";
			}else{
				$log["Itemkey"] = "un-modified";
			}
			if($this->getItem() != $listitemkv->getItem() ){
				$log["Item"] = "modified";
			}else{
				$log["Item"] = "un-modified";
			}
			if($this->getRowOrder() != $listitemkv->getRowOrder() ){
				$log["RowOrder"] = "modified";
			}else{
				$log["RowOrder"] = "un-modified";
			}
		return $log;
		}

		function save(){
			$id = $this->getId();
			$listID = $this->getListID();
			$itemkey = $this->getItemkey();
			$item = $this->getItem();
			$rowOrder = $this->getRowOrder();
			if( $this->connection ){
				if( $id != "" ){
					/*Perform Update Operation*/
					$query = $this->connection->prepare("UPDATE  `listitemkv` SET `listID` = :listID ,`itemkey` = :itemkey ,`item` = :item ,`rowOrder` = :rowOrder WHERE `id` = :id");
					$query->bindParam('listID', $listID);
					$query->bindParam('itemkey', $itemkey);
					$query->bindParam('item', $item);
					$query->bindParam('rowOrder', $rowOrder);
					$query->bindParam('id', $id);
					if( $query->execute() ){
						return $id;
					}else{
						return -1;
					}

				}else{
					/*Perform Insert Operation*/
					$query = $this->connection->prepare("INSERT INTO `listitemkv` (`id`,`listID`,`itemkey`,`item`,`rowOrder`) VALUES (NULL,:listID,:itemkey,:item,:rowOrder);");
					$query->bindParam(':listID', $listID);
					$query->bindParam(':itemkey', $itemkey);
					$query->bindParam(':item', $item);
					$query->bindParam(':rowOrder', $rowOrder);

					if( $query->execute() ){
						$this->setId( $this->connection->lastInsertId() );
						return $this->getId();
					}else{
						return -1;
					}	
				}
			}
		}


		function delete($id = null){
			if( $this->connection ){
				if( $id == null && $this->getId() != ""){
					$id = $this->getId();
				}

				/*Perform Query*/
				if( $id != "" ){
					$query = $this->connection->prepare("DELETE FROM `listitemkv` WHERE `id` = :id");
					$query->bindParam(':id', $id);
					if( $query->execute() ){
						return 1;
					}else{
						return 0;
					}
				}
			}
		}

		function getById($id){
			if( $this->connection ){
				if( $id == null && $this->getId() != ""){
					$id = $this->getId();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `listitemkv` WHERE `id` = :id LIMIT 1");
				$query->bindParam(':id', $id);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("listitemkv") ){
						$object = $result;
					}

				}
				if( is_object( $object ) ){
					return $object;
				}
			}
		}

		function getByListID($listID){
			if( $this->connection ){
				if( $listID == null && $this->getListID() != ""){
					$listID = $this->getListID();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `listitemkv` WHERE `listID` = :listID LIMIT 1");
				$query->bindParam(':listID', $listID);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("listitemkv") ){
						$object = $result;
					}

				}
				if( is_object( $object ) ){
					return $object;
				}
			}
		}

		function getByItemkey($itemkey){
			if( $this->connection ){
				if( $itemkey == null && $this->getItemkey() != ""){
					$itemkey = $this->getItemkey();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `listitemkv` WHERE `itemkey` = :itemkey LIMIT 1");
				$query->bindParam(':itemkey', $itemkey);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("listitemkv") ){
						$object = $result;
					}

				}
				if( is_object( $object ) ){
					return $object;
				}
			}
		}

		function getByItem($item){
			if( $this->connection ){
				if( $item == null && $this->getItem() != ""){
					$item = $this->getItem();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `listitemkv` WHERE `item` = :item LIMIT 1");
				$query->bindParam(':item', $item);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("listitemkv") ){
						$object = $result;
					}

				}
				if( is_object( $object ) ){
					return $object;
				}
			}
		}

		function getByRowOrder($rowOrder){
			if( $this->connection ){
				if( $rowOrder == null && $this->getRowOrder() != ""){
					$rowOrder = $this->getRowOrder();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `listitemkv` WHERE `rowOrder` = :rowOrder LIMIT 1");
				$query->bindParam(':rowOrder', $rowOrder);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("listitemkv") ){
						$object = $result;
					}

				}
				if( is_object( $object ) ){
					return $object;
				}
			}
		}


		function getListById($id=null){
			if( $this->connection ){
				if( $id == null && $this->getId() != ""){
					$id = $this->getId();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `listitemkv` WHERE `id` = :id");
				$query->bindParam(':id', $id);

				if( $query->execute() ){
					while( $result = $query->fetchObject("listitemkv") ){
						$listitemkvs[] = $result;
					}
					if( is_array( $listitemkvs ) ){
						return $listitemkvs;
					}else{
						return array();
					}

				}
			}
		}

		function getListByListID($listID=null){
			if( $this->connection ){
				if( $listID == null && $this->getListID() != ""){
					$listID = $this->getListID();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `listitemkv` WHERE `listID` = :listID");
				$query->bindParam(':listID', $listID);

				if( $query->execute() ){
					while( $result = $query->fetchObject("listitemkv") ){
						$listitemkvs[] = $result;
					}
					if( is_array( $listitemkvs ) ){
						return $listitemkvs;
					}else{
						return array();
					}

				}
			}
		}

		function getListByItemkey($itemkey=null){
			if( $this->connection ){
				if( $itemkey == null && $this->getItemkey() != ""){
					$itemkey = $this->getItemkey();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `listitemkv` WHERE `itemkey` = :itemkey");
				$query->bindParam(':itemkey', $itemkey);

				if( $query->execute() ){
					while( $result = $query->fetchObject("listitemkv") ){
						$listitemkvs[] = $result;
					}
					if( is_array( $listitemkvs ) ){
						return $listitemkvs;
					}else{
						return array();
					}

				}
			}
		}

		function getListByItem($item=null){
			if( $this->connection ){
				if( $item == null && $this->getItem() != ""){
					$item = $this->getItem();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `listitemkv` WHERE `item` = :item");
				$query->bindParam(':item', $item);

				if( $query->execute() ){
					while( $result = $query->fetchObject("listitemkv") ){
						$listitemkvs[] = $result;
					}
					if( is_array( $listitemkvs ) ){
						return $listitemkvs;
					}else{
						return array();
					}

				}
			}
		}

		function getListByRowOrder($rowOrder=null){
			if( $this->connection ){
				if( $rowOrder == null && $this->getRowOrder() != ""){
					$rowOrder = $this->getRowOrder();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `listitemkv` WHERE `rowOrder` = :rowOrder");
				$query->bindParam(':rowOrder', $rowOrder);

				if( $query->execute() ){
					while( $result = $query->fetchObject("listitemkv") ){
						$listitemkvs[] = $result;
					}
					if( is_array( $listitemkvs ) ){
						return $listitemkvs;
					}else{
						return array();
					}

				}
			}
		}

		/*Return parameter (object) as Array*/
		function toArray ($obj=null) {
			if (is_object($obj)) $obj = (array)$obj;
			if (is_array($obj)) {
				$new = array();
				foreach ($obj as $key => $val) {
					$class = get_class($this);
					$k = $key;
					$fkey = trim( str_replace( $class,"",$k));
					if( $fkey == "connection" || $fkey == "errors" || $fkey == "errorCount" ){
						//dont add
					}else{
						$new[$fkey] = $this->toArray($val);
					}
				}
			} else {
				$new = $obj;
			}
			return $new;
		}

		/*Return object as Array*/
		function asArray(){
			$array = $this->toArray( $this );
			return $array;
		}

		/*Return object as JSON String*/
		function asJSON(){
			return json_encode($this->asArray());
		}

		/*Return clone of Object*/
		function getClone(){
			return clone($this);
		}


		/*Echo array as CSV file*/
		function arrayToCSVFile($array, $filename="listitemkv.csv", $delimiter=",", $showHeader=true){
			ob_clean();
			if( !is_array($array) ){
				$array = $this->asArray();
			}
			if( !is_array($showHeader) && $showHeader == true){
				$header=array();
				foreach( $array[0] as $key => $value){
					$header[] = strtoupper($key);
				}
				array_unshift($array, $header);
			}
			if( is_array($showHeader) ){
				array_unshift($array, $showHeader);
			}
			header('Content-Type: application/csv; charset=UTF-8');
			header('Content-Disposition: attachement; filename="'.$filename.'";');
			$f = fopen('php://output', 'w');
			foreach ($array as $line) {
				fputcsv($f, $line, $delimiter);
			}
			exit;
		}


		/*getObjectsLikeThis - returns array*/
		function getObjectsLikeThis($asArray=true){
			if( $this->connection ){
				$buildQuery="SELECT * FROM `listitemkv` WHERE ";
				$numParams = 0;
				$values = array();
				foreach ($this as $key => $value) {
					if( $value != "" && $key != "id" && $key != "connection" && $key != "error" && $key != "errorCount"){
						$buildQuery.="`".$key."` = :value_".$numParams." AND ";
						$numParams++;
						$values[] = $value;
					}
				}
				if( $numParams > 0 ){
					//remove last AND
					$buildQuery = substr( $buildQuery , 0, (strlen($buildQuery) -4) );
					$query = $this->connection->PREPARE($buildQuery);
					for($i=0; $i < $numParams; $i++){
						$query->bindParam(":value_".$i, $values[$i]);
					}
					if( $query->execute() ){
						if( $asArray == true ){
							return $query->fetchAll(PDO::FETCH_ASSOC);
						}else{
							$objArray = array();
							while( $result = $query->fetchObject("listitemkv") ){
								$object = $result;
								$objArray[] = $object;
							}
							return $objArray;
						}
					}
				}
			}
		}

		/*get properties*/
		function getObjectsProperties(){
			$properties = array();
			foreach ($this as $key => $value) {
				if( $key != "id" && $key != "connection" && $key != "error" && $key != "errorCount"){
					$properties[] = $key;
				}
			}
			return $properties;
		}
		/*Human readable print out of object*/
		function printFormatted($return=false){
			if($return){
				return '<pre>'.print_r( $this->asArray(), true ).'</pre>';
			}else{
				echo '<pre>'.print_r( $this->asArray(), true ).'</pre>';
			}
		}

	}
?>