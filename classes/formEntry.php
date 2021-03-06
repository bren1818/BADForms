<?php
/*  Class Generated by Brendon Irwin's Class Generator

	Class: Formentry

	formID, i
	saveTime, ts
	remoteIP, v
	remoteSession, v

*/

	class Formentry{
		private $id;
		private $connection;
		private $errors;
		private $errorCount;
		private $formID;
		private $saveTime;
		private $remoteIP;
		private $remoteSession;


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

		function getFormID(){
			return $this->formID;
		}

		function setFormID($formID){
			$this->formID = $formID;
		}

		function getSaveTime(){
			return $this->saveTime;
		}

		function setSaveTime($saveTime){
			$this->saveTime = $saveTime;
		}

		function getRemoteIP(){
			return $this->remoteIP;
		}

		function setRemoteIP($remoteIP){
			$this->remoteIP = $remoteIP;
		}

		function getRemoteSession(){
			return $this->remoteSession;
		}

		function setRemoteSession($remoteSession){
			$this->remoteSession = $remoteSession;
		}

		/*Special Functions*/
		function load($id = null){
			if( $this->connection ){
				if( $id == null && $this->getId() != ""){
					$id = $this->getId();
				}

				/*Perform Query*/
				if( $id != "" ){
					$query = $this->connection->prepare("SELECT * FROM `formentry` WHERE `id` = :id");
					$query->bindParam(':id', $id);
					if( $query->execute() ){
						$formentry = $query->fetchObject("formentry");
					}
					if( is_object( $formentry ) ){
						$formentry->setConnection( $this->connection );
					}
					return $formentry;
				}
			}
		}

		function getFromPost(){
			$this->setFormID( (isset($_POST["formID"])) ? $_POST["formID"] : $this->getFormID() );
			$this->setSaveTime( (isset($_POST["saveTime"])) ? $_POST["saveTime"] : $this->getSaveTime() );
			$this->setRemoteIP( (isset($_POST["remoteIP"])) ? $_POST["remoteIP"] : $this->getRemoteIP() );
			$this->setRemoteSession( (isset($_POST["remoteSession"])) ? $_POST["remoteSession"] : $this->getRemoteSession() );
		}

		function getFromRequest(){
			$this->setFormID( (isset($_REQUEST["formID"])) ? $_REQUEST["formID"] : $this->getFormID() );
			$this->setSaveTime( (isset($_REQUEST["saveTime"])) ? $_REQUEST["saveTime"] : $this->getSaveTime() );
			$this->setRemoteIP( (isset($_REQUEST["remoteIP"])) ? $_REQUEST["remoteIP"] : $this->getRemoteIP() );
			$this->setRemoteSession( (isset($_REQUEST["remoteSession"])) ? $_REQUEST["remoteSession"] : $this->getRemoteSession() );
		}

		function getFromArray($arr){
			$this->setFormID( (isset($arr["formID"])) ? $arr["formID"] : $this->getFormID() );
			$this->setSaveTime( (isset($arr["saveTime"])) ? $arr["saveTime"] : $this->getSaveTime() );
			$this->setRemoteIP( (isset($arr["remoteIP"])) ? $arr["remoteIP"] : $this->getRemoteIP() );
			$this->setRemoteSession( (isset($arr["remoteSession"])) ? $arr["remoteSession"] : $this->getRemoteSession() );
		}

		function compareTo($formentry){
			$log = array();
			if($this->getId() != $formentry->getId() ){
				$log["Id"] = "modified";
			}else{
				$log["Id"] = "un-modified";
			}
			if($this->getConnection() != $formentry->getConnection() ){
				$log["Connection"] = "modified";
			}else{
				$log["Connection"] = "un-modified";
			}
			if($this->getErrors() != $formentry->getErrors() ){
				$log["Errors"] = "modified";
			}else{
				$log["Errors"] = "un-modified";
			}
			if($this->getErrorCount() != $formentry->getErrorCount() ){
				$log["ErrorCount"] = "modified";
			}else{
				$log["ErrorCount"] = "un-modified";
			}
			if($this->getFormID() != $formentry->getFormID() ){
				$log["FormID"] = "modified";
			}else{
				$log["FormID"] = "un-modified";
			}
			if($this->getSaveTime() != $formentry->getSaveTime() ){
				$log["SaveTime"] = "modified";
			}else{
				$log["SaveTime"] = "un-modified";
			}
			if($this->getRemoteIP() != $formentry->getRemoteIP() ){
				$log["RemoteIP"] = "modified";
			}else{
				$log["RemoteIP"] = "un-modified";
			}
			if($this->getRemoteSession() != $formentry->getRemoteSession() ){
				$log["RemoteSession"] = "modified";
			}else{
				$log["RemoteSession"] = "un-modified";
			}
		return $log;
		}

		function save(){
			$id = $this->getId();
			$formID = $this->getFormID();
			$saveTime = $this->getSaveTime();
			$remoteIP = $this->getRemoteIP();
			$remoteSession = $this->getRemoteSession();
			if( $this->connection ){
				if( $id != "" ){
					/*Perform Update Operation*/
					$query = $this->connection->prepare("UPDATE  `formentry` SET `formID` = :formID ,`saveTime` = :saveTime ,`remoteIP` = :remoteIP ,`remoteSession` = :remoteSession WHERE `id` = :id");
					$query->bindParam('formID', $formID);
					$query->bindParam('saveTime', $saveTime);
					$query->bindParam('remoteIP', $remoteIP);
					$query->bindParam('remoteSession', $remoteSession);
					$query->bindParam('id', $id);
					if( $query->execute() ){
						return $id;
					}else{
						return -1;
					}

				}else{
					/*Perform Insert Operation*/
					$query = $this->connection->prepare("INSERT INTO `formentry` (`id`,`formID`,`saveTime`,`remoteIP`,`remoteSession`) VALUES (NULL,:formID,:saveTime,:remoteIP,:remoteSession);");
					$query->bindParam(':formID', $formID);
					$query->bindParam(':saveTime', $saveTime);
					$query->bindParam(':remoteIP', $remoteIP);
					$query->bindParam(':remoteSession', $remoteSession);

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
					$query = $this->connection->prepare("DELETE FROM `formentry` WHERE `id` = :id");
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
				$query = $this->connection->prepare("SELECT * FROM `formentry` WHERE `id` = :id LIMIT 1");
				$query->bindParam(':id', $id);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("formentry") ){
						$object = $result;
					}

				}
				if( is_object( $object ) ){
					return $object;
				}
			}
		}

		function getByFormID($formID){
			if( $this->connection ){
				if( $formID == null && $this->getFormID() != ""){
					$formID = $this->getFormID();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `formentry` WHERE `formID` = :formID LIMIT 1");
				$query->bindParam(':formID', $formID);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("formentry") ){
						$object = $result;
					}

				}
				if( is_object( $object ) ){
					return $object;
				}
			}
		}

		function getBySaveTime($saveTime){
			if( $this->connection ){
				if( $saveTime == null && $this->getSaveTime() != ""){
					$saveTime = $this->getSaveTime();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `formentry` WHERE `saveTime` = :saveTime LIMIT 1");
				$query->bindParam(':saveTime', $saveTime);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("formentry") ){
						$object = $result;
					}

				}
				if( is_object( $object ) ){
					return $object;
				}
			}
		}

		function getByRemoteIP($remoteIP){
			if( $this->connection ){
				if( $remoteIP == null && $this->getRemoteIP() != ""){
					$remoteIP = $this->getRemoteIP();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `formentry` WHERE `remoteIP` = :remoteIP LIMIT 1");
				$query->bindParam(':remoteIP', $remoteIP);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("formentry") ){
						$object = $result;
					}

				}
				if( is_object( $object ) ){
					return $object;
				}
			}
		}

		function getByRemoteSession($remoteSession){
			if( $this->connection ){
				if( $remoteSession == null && $this->getRemoteSession() != ""){
					$remoteSession = $this->getRemoteSession();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `formentry` WHERE `remoteSession` = :remoteSession LIMIT 1");
				$query->bindParam(':remoteSession', $remoteSession);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("formentry") ){
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
				$query = $this->connection->prepare("SELECT * FROM `formentry` WHERE `id` = :id");
				$query->bindParam(':id', $id);

				if( $query->execute() ){
					while( $result = $query->fetchObject("formentry") ){
						$formentrys[] = $result;
					}
					if( is_array( $formentrys ) ){
						return $formentrys;
					}else{
						return array();
					}

				}
			}
		}

		function getListByFormID($formID=null){
			if( $this->connection ){
				if( $formID == null && $this->getFormID() != ""){
					$formID = $this->getFormID();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `formentry` WHERE `formID` = :formID");
				$query->bindParam(':formID', $formID);

				if( $query->execute() ){
					while( $result = $query->fetchObject("formentry") ){
						$formentrys[] = $result;
					}
					if( is_array( $formentrys ) ){
						return $formentrys;
					}else{
						return array();
					}

				}
			}
		}

		function getListBySaveTime($saveTime=null){
			if( $this->connection ){
				if( $saveTime == null && $this->getSaveTime() != ""){
					$saveTime = $this->getSaveTime();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `formentry` WHERE `saveTime` = :saveTime");
				$query->bindParam(':saveTime', $saveTime);

				if( $query->execute() ){
					while( $result = $query->fetchObject("formentry") ){
						$formentrys[] = $result;
					}
					if( is_array( $formentrys ) ){
						return $formentrys;
					}else{
						return array();
					}

				}
			}
		}

		function getListByRemoteIP($remoteIP=null){
			if( $this->connection ){
				if( $remoteIP == null && $this->getRemoteIP() != ""){
					$remoteIP = $this->getRemoteIP();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `formentry` WHERE `remoteIP` = :remoteIP");
				$query->bindParam(':remoteIP', $remoteIP);

				if( $query->execute() ){
					while( $result = $query->fetchObject("formentry") ){
						$formentrys[] = $result;
					}
					if( is_array( $formentrys ) ){
						return $formentrys;
					}else{
						return array();
					}

				}
			}
		}

		function getListByRemoteSession($remoteSession=null){
			if( $this->connection ){
				if( $remoteSession == null && $this->getRemoteSession() != ""){
					$remoteSession = $this->getRemoteSession();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `formentry` WHERE `remoteSession` = :remoteSession");
				$query->bindParam(':remoteSession', $remoteSession);

				if( $query->execute() ){
					while( $result = $query->fetchObject("formentry") ){
						$formentrys[] = $result;
					}
					if( is_array( $formentrys ) ){
						return $formentrys;
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
		function arrayToCSVFile($array, $filename="formentry.csv", $delimiter=",", $showHeader=true){
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
				$buildQuery="SELECT * FROM `formentry` WHERE ";
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
							while( $result = $query->fetchObject("formentry") ){
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