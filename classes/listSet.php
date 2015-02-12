<?php
/*  Class Generated by Brendon Irwin's Class Generator

	Class: Listset

	listName, v
	listType, i
	defaultValue, v
	owner, i
	private, i

*/

	class Listset{
		private $id;
		private $connection;
		private $errors;
		private $errorCount;
		private $listName;
		private $listType;
		private $defaultValue;
		private $owner;
		private $private;


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

		function getListName(){
			return $this->listName;
		}

		function setListName($listName){
			$this->listName = $listName;
		}

		function getListType(){
			return $this->listType;
		}

		function setListType($listType){
			$this->listType = $listType;
		}

		function getDefaultValue(){
			return $this->defaultValue;
		}

		function setDefaultValue($defaultValue){
			$this->defaultValue = $defaultValue;
		}

		function getOwner(){
			return $this->owner;
		}

		function setOwner($owner){
			$this->owner = $owner;
		}

		function getPrivate(){
			return $this->private;
		}

		function setPrivate($private){
			$this->private = $private;
		}

		/*Special Functions*/
		function load($id = null){
			if( $this->connection ){
				if( $id == null && $this->getId() != ""){
					$id = $this->getId();
				}

				/*Perform Query*/
				if( $id != "" ){
					$query = $this->connection->prepare("SELECT * FROM `listset` WHERE `id` = :id");
					$query->bindParam(':id', $id);
					if( $query->execute() ){
						$listset = $query->fetchObject("listset");
					}
					if( is_object( $listset ) ){
						$listset->setConnection( $this->connection );
					}
					return $listset;
				}
			}
		}

		function getFromPost(){
			$this->setListName( (isset($_POST["listName"])) ? $_POST["listName"] : $this->getListName() );
			$this->setListType( (isset($_POST["listType"])) ? $_POST["listType"] : $this->getListType() );
			$this->setDefaultValue( (isset($_POST["defaultValue"])) ? $_POST["defaultValue"] : $this->getDefaultValue() );
			$this->setOwner( (isset($_POST["owner"])) ? $_POST["owner"] : $this->getOwner() );
			$this->setPrivate( (isset($_POST["private"])) ? $_POST["private"] : $this->getPrivate() );
		}

		function getFromRequest(){
			$this->setListName( (isset($_REQUEST["listName"])) ? $_REQUEST["listName"] : $this->getListName() );
			$this->setListType( (isset($_REQUEST["listType"])) ? $_REQUEST["listType"] : $this->getListType() );
			$this->setDefaultValue( (isset($_REQUEST["defaultValue"])) ? $_REQUEST["defaultValue"] : $this->getDefaultValue() );
			$this->setOwner( (isset($_REQUEST["owner"])) ? $_REQUEST["owner"] : $this->getOwner() );
			$this->setPrivate( (isset($_REQUEST["private"])) ? $_REQUEST["private"] : $this->getPrivate() );
		}

		function getFromArray($arr){
			$this->setListName( (isset($arr["listName"])) ? $arr["listName"] : $this->getListName() );
			$this->setListType( (isset($arr["listType"])) ? $arr["listType"] : $this->getListType() );
			$this->setDefaultValue( (isset($arr["defaultValue"])) ? $arr["defaultValue"] : $this->getDefaultValue() );
			$this->setOwner( (isset($arr["owner"])) ? $arr["owner"] : $this->getOwner() );
			$this->setPrivate( (isset($arr["private"])) ? $arr["private"] : $this->getPrivate() );
		}

		function compareTo($listset){
			$log = array();
			if($this->getId() != $listset->getId() ){
				$log["Id"] = "modified";
			}else{
				$log["Id"] = "un-modified";
			}
			if($this->getConnection() != $listset->getConnection() ){
				$log["Connection"] = "modified";
			}else{
				$log["Connection"] = "un-modified";
			}
			if($this->getErrors() != $listset->getErrors() ){
				$log["Errors"] = "modified";
			}else{
				$log["Errors"] = "un-modified";
			}
			if($this->getErrorCount() != $listset->getErrorCount() ){
				$log["ErrorCount"] = "modified";
			}else{
				$log["ErrorCount"] = "un-modified";
			}
			if($this->getListName() != $listset->getListName() ){
				$log["ListName"] = "modified";
			}else{
				$log["ListName"] = "un-modified";
			}
			if($this->getListType() != $listset->getListType() ){
				$log["ListType"] = "modified";
			}else{
				$log["ListType"] = "un-modified";
			}
			if($this->getDefaultValue() != $listset->getDefaultValue() ){
				$log["DefaultValue"] = "modified";
			}else{
				$log["DefaultValue"] = "un-modified";
			}
			if($this->getOwner() != $listset->getOwner() ){
				$log["Owner"] = "modified";
			}else{
				$log["Owner"] = "un-modified";
			}
			if($this->getPrivate() != $listset->getPrivate() ){
				$log["Private"] = "modified";
			}else{
				$log["Private"] = "un-modified";
			}
		return $log;
		}

		function save(){
			$id = $this->getId();
			$listName = $this->getListName();
			$listType = $this->getListType();
			$defaultValue = $this->getDefaultValue();
			$owner = $this->getOwner();
			$private = $this->getPrivate();
			if( $this->connection ){
				if( $id != "" ){
					/*Perform Update Operation*/
					$query = $this->connection->prepare("UPDATE  `listset` SET `listName` = :listName ,`listType` = :listType ,`defaultValue` = :defaultValue ,`owner` = :owner ,`private` = :private WHERE `id` = :id");
					$query->bindParam('listName', $listName);
					$query->bindParam('listType', $listType);
					$query->bindParam('defaultValue', $defaultValue);
					$query->bindParam('owner', $owner);
					$query->bindParam('private', $private);
					$query->bindParam('id', $id);
					if( $query->execute() ){
						return $id;
					}else{
						return -1;
					}

				}else{
					/*Perform Insert Operation*/
					$query = $this->connection->prepare("INSERT INTO `listset` (`id`,`listName`,`listType`,`defaultValue`,`owner`,`private`) VALUES (NULL,:listName,:listType,:defaultValue,:owner,:private);");
					$query->bindParam(':listName', $listName);
					$query->bindParam(':listType', $listType);
					$query->bindParam(':defaultValue', $defaultValue);
					$query->bindParam(':owner', $owner);
					$query->bindParam(':private', $private);

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
					$query = $this->connection->prepare("DELETE FROM `listset` WHERE `id` = :id");
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
				$query = $this->connection->prepare("SELECT * FROM `listset` WHERE `id` = :id LIMIT 1");
				$query->bindParam(':id', $id);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("listset") ){
						$object = $result;
					}

				}
				if( is_object( $object ) ){
					return $object;
				}
			}
		}

		function getByListName($listName){
			if( $this->connection ){
				if( $listName == null && $this->getListName() != ""){
					$listName = $this->getListName();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `listset` WHERE `listName` = :listName LIMIT 1");
				$query->bindParam(':listName', $listName);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("listset") ){
						$object = $result;
					}

				}
				if( is_object( $object ) ){
					return $object;
				}
			}
		}

		function getByListType($listType){
			if( $this->connection ){
				if( $listType == null && $this->getListType() != ""){
					$listType = $this->getListType();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `listset` WHERE `listType` = :listType LIMIT 1");
				$query->bindParam(':listType', $listType);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("listset") ){
						$object = $result;
					}

				}
				if( is_object( $object ) ){
					return $object;
				}
			}
		}

		function getByDefaultValue($defaultValue){
			if( $this->connection ){
				if( $defaultValue == null && $this->getDefaultValue() != ""){
					$defaultValue = $this->getDefaultValue();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `listset` WHERE `defaultValue` = :defaultValue LIMIT 1");
				$query->bindParam(':defaultValue', $defaultValue);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("listset") ){
						$object = $result;
					}

				}
				if( is_object( $object ) ){
					return $object;
				}
			}
		}

		function getByOwner($owner){
			if( $this->connection ){
				if( $owner == null && $this->getOwner() != ""){
					$owner = $this->getOwner();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `listset` WHERE `owner` = :owner LIMIT 1");
				$query->bindParam(':owner', $owner);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("listset") ){
						$object = $result;
					}

				}
				if( is_object( $object ) ){
					return $object;
				}
			}
		}

		function getByPrivate($private){
			if( $this->connection ){
				if( $private == null && $this->getPrivate() != ""){
					$private = $this->getPrivate();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `listset` WHERE `private` = :private LIMIT 1");
				$query->bindParam(':private', $private);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("listset") ){
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
				$query = $this->connection->prepare("SELECT * FROM `listset` WHERE `id` = :id");
				$query->bindParam(':id', $id);

				if( $query->execute() ){
					while( $result = $query->fetchObject("listset") ){
						$listsets[] = $result;
					}
					if( is_array( $listsets ) ){
						return $listsets;
					}else{
						return array();
					}

				}
			}
		}

		function getListByListName($listName=null){
			if( $this->connection ){
				if( $listName == null && $this->getListName() != ""){
					$listName = $this->getListName();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `listset` WHERE `listName` = :listName");
				$query->bindParam(':listName', $listName);

				if( $query->execute() ){
					while( $result = $query->fetchObject("listset") ){
						$listsets[] = $result;
					}
					if( is_array( $listsets ) ){
						return $listsets;
					}else{
						return array();
					}

				}
			}
		}

		function getListByListType($listType=null){
			if( $this->connection ){
				if( $listType == null && $this->getListType() != ""){
					$listType = $this->getListType();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `listset` WHERE `listType` = :listType");
				$query->bindParam(':listType', $listType);

				if( $query->execute() ){
					while( $result = $query->fetchObject("listset") ){
						$listsets[] = $result;
					}
					if( is_array( $listsets ) ){
						return $listsets;
					}else{
						return array();
					}

				}
			}
		}

		function getListByDefaultValue($defaultValue=null){
			if( $this->connection ){
				if( $defaultValue == null && $this->getDefaultValue() != ""){
					$defaultValue = $this->getDefaultValue();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `listset` WHERE `defaultValue` = :defaultValue");
				$query->bindParam(':defaultValue', $defaultValue);

				if( $query->execute() ){
					while( $result = $query->fetchObject("listset") ){
						$listsets[] = $result;
					}
					if( is_array( $listsets ) ){
						return $listsets;
					}else{
						return array();
					}

				}
			}
		}

		function getListByOwner($owner=null){
			if( $this->connection ){
				if( $owner == null && $this->getOwner() != ""){
					$owner = $this->getOwner();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `listset` WHERE `owner` = :owner");
				$query->bindParam(':owner', $owner);

				if( $query->execute() ){
					while( $result = $query->fetchObject("listset") ){
						$listsets[] = $result;
					}
					if( is_array( $listsets ) ){
						return $listsets;
					}else{
						return array();
					}

				}
			}
		}

		function getListByPrivate($private=null){
			if( $this->connection ){
				if( $private == null && $this->getPrivate() != ""){
					$private = $this->getPrivate();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `listset` WHERE `private` = :private");
				$query->bindParam(':private', $private);

				if( $query->execute() ){
					while( $result = $query->fetchObject("listset") ){
						$listsets[] = $result;
					}
					if( is_array( $listsets ) ){
						return $listsets;
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
		function arrayToCSVFile($array, $filename="listset.csv", $delimiter=",", $showHeader=true){
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
				$buildQuery="SELECT * FROM `listset` WHERE ";
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
							while( $result = $query->fetchObject("listset") ){
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