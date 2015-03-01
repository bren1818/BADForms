<?php
/*  Class Generated by Brendon Irwin's Class Generator

	Class: Admin

	username, v
	password, v
	salt, v
	email, v
	userLevel, i
	creationDate, ts
	lastLogin, dt
	enabled, i

*/

	class Admin{
		private $id;
		private $connection;
		private $errors;
		private $errorCount;
		private $username;
		private $password;
		private $salt;
		private $email;
		private $userLevel;
		private $creationDate;
		private $lastLogin;
		private $enabled;


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

		function getUsername(){
			return $this->username;
		}

		function setUsername($username){
			$this->username = $username;
		}

		function getPassword(){
			return $this->password;
		}

		function setPassword($password){
			$this->password = $password;
		}

		function getSalt(){
			return $this->salt;
		}

		function setSalt($salt){
			$this->salt = $salt;
		}

		function getEmail(){
			return $this->email;
		}

		function setEmail($email){
			$this->email = $email;
		}

		function getUserLevel(){
			return $this->userLevel;
		}

		function setUserLevel($userLevel){
			$this->userLevel = $userLevel;
		}

		function getCreationDate(){
			return $this->creationDate;
		}

		function setCreationDate($creationDate){
			$this->creationDate = $creationDate;
		}

		function getLastLogin(){
			return $this->lastLogin;
		}

		function setLastLogin($lastLogin){
			$this->lastLogin = $lastLogin;
		}

		function getEnabled(){
			return $this->enabled;
		}

		function setEnabled($enabled){
			$this->enabled = $enabled;
		}

		/*Special Functions*/
		function load($id = null){
			if( $this->connection ){
				if( $id == null && $this->getId() != ""){
					$id = $this->getId();
				}

				/*Perform Query*/
				if( $id != "" ){
					$query = $this->connection->prepare("SELECT * FROM `admin` WHERE `id` = :id");
					$query->bindParam(':id', $id);
					if( $query->execute() ){
						$admin = $query->fetchObject("admin");
					}
					if( is_object( $admin ) ){
						$admin->setConnection( $this->connection );
					}
					return $admin;
				}
			}
		}

		function getFromPost(){
			$this->setUsername( (isset($_POST["username"])) ? $_POST["username"] : $this->getUsername() );
			$this->setPassword( (isset($_POST["password"])) ? $_POST["password"] : $this->getPassword() );
			$this->setSalt( (isset($_POST["salt"])) ? $_POST["salt"] : $this->getSalt() );
			$this->setEmail( (isset($_POST["email"])) ? $_POST["email"] : $this->getEmail() );
			$this->setUserLevel( (isset($_POST["userLevel"])) ? $_POST["userLevel"] : $this->getUserLevel() );
			$this->setCreationDate( (isset($_POST["creationDate"])) ? $_POST["creationDate"] : $this->getCreationDate() );
			$this->setLastLogin( (isset($_POST["lastLogin"])) ? $_POST["lastLogin"] : $this->getLastLogin() );
			$this->setEnabled( (isset($_POST["enabled"])) ? $_POST["enabled"] : $this->getEnabled() );
		}

		function getFromRequest(){
			$this->setUsername( (isset($_REQUEST["username"])) ? $_REQUEST["username"] : $this->getUsername() );
			$this->setPassword( (isset($_REQUEST["password"])) ? $_REQUEST["password"] : $this->getPassword() );
			$this->setSalt( (isset($_REQUEST["salt"])) ? $_REQUEST["salt"] : $this->getSalt() );
			$this->setEmail( (isset($_REQUEST["email"])) ? $_REQUEST["email"] : $this->getEmail() );
			$this->setUserLevel( (isset($_REQUEST["userLevel"])) ? $_REQUEST["userLevel"] : $this->getUserLevel() );
			$this->setCreationDate( (isset($_REQUEST["creationDate"])) ? $_REQUEST["creationDate"] : $this->getCreationDate() );
			$this->setLastLogin( (isset($_REQUEST["lastLogin"])) ? $_REQUEST["lastLogin"] : $this->getLastLogin() );
			$this->setEnabled( (isset($_REQUEST["enabled"])) ? $_REQUEST["enabled"] : $this->getEnabled() );
		}

		function getFromArray($arr){
			$this->setUsername( (isset($arr["username"])) ? $arr["username"] : $this->getUsername() );
			$this->setPassword( (isset($arr["password"])) ? $arr["password"] : $this->getPassword() );
			$this->setSalt( (isset($arr["salt"])) ? $arr["salt"] : $this->getSalt() );
			$this->setEmail( (isset($arr["email"])) ? $arr["email"] : $this->getEmail() );
			$this->setUserLevel( (isset($arr["userLevel"])) ? $arr["userLevel"] : $this->getUserLevel() );
			$this->setCreationDate( (isset($arr["creationDate"])) ? $arr["creationDate"] : $this->getCreationDate() );
			$this->setLastLogin( (isset($arr["lastLogin"])) ? $arr["lastLogin"] : $this->getLastLogin() );
			$this->setEnabled( (isset($arr["enabled"])) ? $arr["enabled"] : $this->getEnabled() );
		}

		function compareTo($admin){
			$log = array();
			if($this->getId() != $admin->getId() ){
				$log["Id"] = "modified";
			}else{
				$log["Id"] = "un-modified";
			}
			if($this->getConnection() != $admin->getConnection() ){
				$log["Connection"] = "modified";
			}else{
				$log["Connection"] = "un-modified";
			}
			if($this->getErrors() != $admin->getErrors() ){
				$log["Errors"] = "modified";
			}else{
				$log["Errors"] = "un-modified";
			}
			if($this->getErrorCount() != $admin->getErrorCount() ){
				$log["ErrorCount"] = "modified";
			}else{
				$log["ErrorCount"] = "un-modified";
			}
			if($this->getUsername() != $admin->getUsername() ){
				$log["Username"] = "modified";
			}else{
				$log["Username"] = "un-modified";
			}
			if($this->getPassword() != $admin->getPassword() ){
				$log["Password"] = "modified";
			}else{
				$log["Password"] = "un-modified";
			}
			if($this->getSalt() != $admin->getSalt() ){
				$log["Salt"] = "modified";
			}else{
				$log["Salt"] = "un-modified";
			}
			if($this->getEmail() != $admin->getEmail() ){
				$log["Email"] = "modified";
			}else{
				$log["Email"] = "un-modified";
			}
			if($this->getUserLevel() != $admin->getUserLevel() ){
				$log["UserLevel"] = "modified";
			}else{
				$log["UserLevel"] = "un-modified";
			}
			if($this->getCreationDate() != $admin->getCreationDate() ){
				$log["CreationDate"] = "modified";
			}else{
				$log["CreationDate"] = "un-modified";
			}
			if($this->getLastLogin() != $admin->getLastLogin() ){
				$log["LastLogin"] = "modified";
			}else{
				$log["LastLogin"] = "un-modified";
			}
			if($this->getEnabled() != $admin->getEnabled() ){
				$log["Enabled"] = "modified";
			}else{
				$log["Enabled"] = "un-modified";
			}
		return $log;
		}

		function save(){
			$id = $this->getId();
			$username = $this->getUsername();
			$password = $this->getPassword();
			$salt = $this->getSalt();
			$email = $this->getEmail();
			$userLevel = $this->getUserLevel();
			$creationDate = $this->getCreationDate();
			$lastLogin = $this->getLastLogin();
			$enabled = $this->getEnabled();
			if( $this->connection ){
				if( $id != "" ){
					/*Perform Update Operation*/
					$query = $this->connection->prepare("UPDATE  `admin` SET `username` = :username ,`password` = :password ,`salt` = :salt ,`email` = :email ,`userLevel` = :userLevel ,`creationDate` = :creationDate ,`lastLogin` = :lastLogin ,`enabled` = :enabled WHERE `id` = :id");
					$query->bindParam('username', $username);
					$query->bindParam('password', $password);
					$query->bindParam('salt', $salt);
					$query->bindParam('email', $email);
					$query->bindParam('userLevel', $userLevel);
					$query->bindParam('creationDate', $creationDate);
					$query->bindParam('lastLogin', $lastLogin);
					$query->bindParam('enabled', $enabled);
					$query->bindParam('id', $id);
					if( $query->execute() ){
						return $id;
					}else{
						return -1;
					}

				}else{
					/*Perform Insert Operation*/
					$query = $this->connection->prepare("INSERT INTO `admin` (`id`,`username`,`password`,`salt`,`email`,`userLevel`,`creationDate`,`lastLogin`,`enabled`) VALUES (NULL,:username,:password,:salt,:email,:userLevel,:creationDate,:lastLogin,:enabled);");
					$query->bindParam(':username', $username);
					$query->bindParam(':password', $password);
					$query->bindParam(':salt', $salt);
					$query->bindParam(':email', $email);
					$query->bindParam(':userLevel', $userLevel);
					$query->bindParam(':creationDate', $creationDate);
					$query->bindParam(':lastLogin', $lastLogin);
					$query->bindParam(':enabled', $enabled);

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
					$query = $this->connection->prepare("DELETE FROM `admin` WHERE `id` = :id");
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
				$query = $this->connection->prepare("SELECT * FROM `admin` WHERE `id` = :id LIMIT 1");
				$query->bindParam(':id', $id);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("admin") ){
						$object = $result;
					}

				}
				if( is_object( $object ) ){
					return $object;
				}
			}
		}

		function getByUsername($username){
			if( $this->connection ){
				if( $username == null && $this->getUsername() != ""){
					$username = $this->getUsername();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `admin` WHERE `username` = :username LIMIT 1");
				$query->bindParam(':username', $username);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("admin") ){
						$object = $result;
					}

				}
				if( is_object( $object ) ){
					return $object;
				}
			}
		}

		function getByPassword($password){
			if( $this->connection ){
				if( $password == null && $this->getPassword() != ""){
					$password = $this->getPassword();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `admin` WHERE `password` = :password LIMIT 1");
				$query->bindParam(':password', $password);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("admin") ){
						$object = $result;
					}

				}
				if( is_object( $object ) ){
					return $object;
				}
			}
		}

		function getBySalt($salt){
			if( $this->connection ){
				if( $salt == null && $this->getSalt() != ""){
					$salt = $this->getSalt();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `admin` WHERE `salt` = :salt LIMIT 1");
				$query->bindParam(':salt', $salt);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("admin") ){
						$object = $result;
					}

				}
				if( is_object( $object ) ){
					return $object;
				}
			}
		}

		function getByEmail($email){
			if( $this->connection ){
				if( $email == null && $this->getEmail() != ""){
					$email = $this->getEmail();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `admin` WHERE `email` = :email LIMIT 1");
				$query->bindParam(':email', $email);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("admin") ){
						$object = $result;
					}

				}
				if( is_object( $object ) ){
					return $object;
				}
			}
		}

		function getByUserLevel($userLevel){
			if( $this->connection ){
				if( $userLevel == null && $this->getUserLevel() != ""){
					$userLevel = $this->getUserLevel();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `admin` WHERE `userLevel` = :userLevel LIMIT 1");
				$query->bindParam(':userLevel', $userLevel);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("admin") ){
						$object = $result;
					}

				}
				if( is_object( $object ) ){
					return $object;
				}
			}
		}

		function getByCreationDate($creationDate){
			if( $this->connection ){
				if( $creationDate == null && $this->getCreationDate() != ""){
					$creationDate = $this->getCreationDate();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `admin` WHERE `creationDate` = :creationDate LIMIT 1");
				$query->bindParam(':creationDate', $creationDate);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("admin") ){
						$object = $result;
					}

				}
				if( is_object( $object ) ){
					return $object;
				}
			}
		}

		function getByLastLogin($lastLogin){
			if( $this->connection ){
				if( $lastLogin == null && $this->getLastLogin() != ""){
					$lastLogin = $this->getLastLogin();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `admin` WHERE `lastLogin` = :lastLogin LIMIT 1");
				$query->bindParam(':lastLogin', $lastLogin);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("admin") ){
						$object = $result;
					}

				}
				if( is_object( $object ) ){
					return $object;
				}
			}
		}

		function getByEnabled($enabled){
			if( $this->connection ){
				if( $enabled == null && $this->getEnabled() != ""){
					$enabled = $this->getEnabled();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `admin` WHERE `enabled` = :enabled LIMIT 1");
				$query->bindParam(':enabled', $enabled);
				$object = null;

				if( $query->execute() ){
					while( $result = $query->fetchObject("admin") ){
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
				$query = $this->connection->prepare("SELECT * FROM `admin` WHERE `id` = :id");
				$query->bindParam(':id', $id);

				if( $query->execute() ){
					while( $result = $query->fetchObject("admin") ){
						$admins[] = $result;
					}
					if( is_array( $admins ) ){
						return $admins;
					}else{
						return array();
					}

				}
			}
		}

		function getListByUsername($username=null){
			if( $this->connection ){
				if( $username == null && $this->getUsername() != ""){
					$username = $this->getUsername();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `admin` WHERE `username` = :username");
				$query->bindParam(':username', $username);

				if( $query->execute() ){
					while( $result = $query->fetchObject("admin") ){
						$admins[] = $result;
					}
					if( is_array( $admins ) ){
						return $admins;
					}else{
						return array();
					}

				}
			}
		}

		function getListByPassword($password=null){
			if( $this->connection ){
				if( $password == null && $this->getPassword() != ""){
					$password = $this->getPassword();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `admin` WHERE `password` = :password");
				$query->bindParam(':password', $password);

				if( $query->execute() ){
					while( $result = $query->fetchObject("admin") ){
						$admins[] = $result;
					}
					if( is_array( $admins ) ){
						return $admins;
					}else{
						return array();
					}

				}
			}
		}

		function getListBySalt($salt=null){
			if( $this->connection ){
				if( $salt == null && $this->getSalt() != ""){
					$salt = $this->getSalt();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `admin` WHERE `salt` = :salt");
				$query->bindParam(':salt', $salt);

				if( $query->execute() ){
					while( $result = $query->fetchObject("admin") ){
						$admins[] = $result;
					}
					if( is_array( $admins ) ){
						return $admins;
					}else{
						return array();
					}

				}
			}
		}

		function getListByEmail($email=null){
			if( $this->connection ){
				if( $email == null && $this->getEmail() != ""){
					$email = $this->getEmail();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `admin` WHERE `email` = :email");
				$query->bindParam(':email', $email);

				if( $query->execute() ){
					while( $result = $query->fetchObject("admin") ){
						$admins[] = $result;
					}
					if( is_array( $admins ) ){
						return $admins;
					}else{
						return array();
					}

				}
			}
		}

		function getListByUserLevel($userLevel=null){
			if( $this->connection ){
				if( $userLevel == null && $this->getUserLevel() != ""){
					$userLevel = $this->getUserLevel();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `admin` WHERE `userLevel` = :userLevel");
				$query->bindParam(':userLevel', $userLevel);

				if( $query->execute() ){
					while( $result = $query->fetchObject("admin") ){
						$admins[] = $result;
					}
					if( is_array( $admins ) ){
						return $admins;
					}else{
						return array();
					}

				}
			}
		}

		function getListByCreationDate($creationDate=null){
			if( $this->connection ){
				if( $creationDate == null && $this->getCreationDate() != ""){
					$creationDate = $this->getCreationDate();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `admin` WHERE `creationDate` = :creationDate");
				$query->bindParam(':creationDate', $creationDate);

				if( $query->execute() ){
					while( $result = $query->fetchObject("admin") ){
						$admins[] = $result;
					}
					if( is_array( $admins ) ){
						return $admins;
					}else{
						return array();
					}

				}
			}
		}

		function getListByLastLogin($lastLogin=null){
			if( $this->connection ){
				if( $lastLogin == null && $this->getLastLogin() != ""){
					$lastLogin = $this->getLastLogin();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `admin` WHERE `lastLogin` = :lastLogin");
				$query->bindParam(':lastLogin', $lastLogin);

				if( $query->execute() ){
					while( $result = $query->fetchObject("admin") ){
						$admins[] = $result;
					}
					if( is_array( $admins ) ){
						return $admins;
					}else{
						return array();
					}

				}
			}
		}

		function getListByEnabled($enabled=null){
			if( $this->connection ){
				if( $enabled == null && $this->getEnabled() != ""){
					$enabled = $this->getEnabled();
				}

				/*Perform Query*/
				$query = $this->connection->prepare("SELECT * FROM `admin` WHERE `enabled` = :enabled");
				$query->bindParam(':enabled', $enabled);

				if( $query->execute() ){
					while( $result = $query->fetchObject("admin") ){
						$admins[] = $result;
					}
					if( is_array( $admins ) ){
						return $admins;
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
		function arrayToCSVFile($array, $filename="admin.csv", $delimiter=",", $showHeader=true){
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
				$buildQuery="SELECT * FROM `admin` WHERE ";
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
							while( $result = $query->fetchObject("admin") ){
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