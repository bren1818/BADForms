<?php
	/*Class Generated by Brendon Irwin's Class Generator*/

	class Base{
		private $id;
		private $connection;
		private $errors;
		private $errorCount;
		private $render;


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

		function getRender(){
			return $this->render;
		}

		function setRender($render){
			$this->render = $render;
		}

		/*Special Functions*/
		function load($id = null){
			if( $this->connection ){
				if( $id == null && $this->getId() != ""){
					$id = $this->getId();
				}

				/*Perform Query*/
				if( $id != "" ){
					$query = $this->connection->prepare("SELECT * FROM `base` WHERE `id` = :id");
					$query->bindParam(':id', $id);
					if( $query->execute() ){
						$base = $query->fetchObject("base");
					}
					if( is_object( $base ) ){
						$base->setConnection( $this->connection );
					}
					return $base;
				}
			}
		}

		function getFromPost(){
			$this->setRender( (isset($_POST["render"])) ? $_POST["render"] : $this->getRender() );
		}

		function getFromRequest(){
			$this->setRender( (isset($_REQUEST["render"])) ? $_REQUEST["render"] : $this->getRender() );
		}

		function save(){
			$id = $this->getId();
			$render = $this->getRender();
			if( $this->connection ){
				if( $id != "" ){
					/*Perform Update Operation*/
					$query = $this->connection->prepare("UPDATE  `base` SET `render` = :render WHERE `id` = :id");
					$query->bindParam('render', $render);
					$query->bindParam('id', $id);
					if( $query->execute() ){
						return $id;
					}else{
						return -1;
					}

				}else{
					/*Perform Insert Operation*/
					$query = $this->connection->prepare("INSERT INTO `base` (`id`,`render`) VALUES (NULL,:render);");
					$query->bindParam(':render', $render);

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
					$query = $this->connection->prepare("DELETE FROM `base` WHERE `id` = :id");
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
				$query = $this->connection->prepare("SELECT * FROM `base` WHERE `id` = :id LIMIT 1");
				$query->bindParam(':id', $id);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("base") ){
						$object = $result;
					}

				}
				if( is_object( $object ) ){
					return $object;
				}
			}
		}

		function getByRender($render){
			if( $this->connection ){
				if( $render == null && $this->getRender() != ""){
					$render = $this->getRender();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `base` WHERE `render` = :render LIMIT 1");
				$query->bindParam(':render', $render);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("base") ){
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
				$query = $this->connection->prepare("SELECT * FROM `base` WHERE `id` = :id");
				$query->bindParam(':id', $id);

				if( $query->execute() ){
					while( $result = $query->fetchObject("base") ){
						$bases[] = $result;
					}
					if( is_array( $bases ) ){
						return $bases;
					}else{
						return array();
					}

				}
			}
		}

		function getListByRender($render=null){
			if( $this->connection ){
				if( $render == null && $this->getRender() != ""){
					$render = $this->getRender();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `base` WHERE `render` = :render");
				$query->bindParam(':render', $render);

				if( $query->execute() ){
					while( $result = $query->fetchObject("base") ){
						$bases[] = $result;
					}
					if( is_array( $bases ) ){
						return $bases;
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
		function arrayToCSVFile($array, $filename="base.csv", $delimiter=",", $showHeader=true){
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
				$buildQuery="SELECT * FROM `base` WHERE ";
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
							while( $result = $query->fetchObject("base") ){
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