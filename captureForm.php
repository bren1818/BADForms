<?php
	include "includes/include.php";
	
	
	if( isPostback() ){
		
		echo "Posted Data";
		pa( $_POST );
		
		$conn = getConnection();
		$formID = "";
		$encryptor = "";
		
		if( isset($_POST) && isset($_POST['formID']) ){
			if( is_int( (int)$_POST['formID'] ) ){
				$formID = $_POST['formID'];
				
				
				$Theform = new Theform($conn);
				$Theform = $Theform->load($formID);
				
				if( is_object($Theform) ){
					$now = time();
					if( $Theform->getSunrise() == "0000-00-00 00:00:00"){
						//ignore it
					}else{
						$sunrise = strtotime( $Theform->getSunrise() );
						if( $now < $sunrise ){
							echo "Form not available yet to accept submissions";
							exit;
						}
					}
				
					if( $Theform->getSunset() == "0000-00-00 00:00:00"){
						//ignore it
					}else{
						$sunset = strtotime( $Theform->getSunset() );
						if( $now > $sunset ){
							echo "Form no longer available to recieve submissions";
							exit;
						}
					}
				}else{
					echo "Could not load Form...";
					exit;
				}
				
				//encryption mode
				//encryption key
				
				
				$salty = $Theform->getEncryptionSalt();
				$encryptionKey = BASE_ENCRYPTION_SALT.$salty;
				//if requires Encryption
				$encryptor = new BrenCrypt();
				$encryptor->setKey( $encryptionKey );
				
				
				/*Update Hit Count*/
				
				
			}else{
				echo "Non Numeric Form ID";
				exit;
			}
		}else{
			//unknown formID
			exit;
		}
		
		$types = "Select `id`, `name` FROM `objecttype`";
		$types = $conn->query( $types );
		$fieldTypes = array();
		if( $types->execute() ){
			while( $result = $types->fetch(PDO::FETCH_ASSOC) ){
				$fieldTypes[ $result['id'] ] = $result['name'];
			}
		}
		
	
		$query = "SELECT * FROM `formobject` WHERE `formID` = :formID order by `rowOrder` ASC"; //type no nt chosen
		$query = $conn->prepare( $query );
		$query->bindParam(':formID', $formID);
	
		$capturedData = array();
		$counter = 1;
		$errors = 0;
		
		$saveRow = array();
	
		if( $query->execute() ){
			while( $result = $query->fetchObject("formobject") ){
				
				//if re-useable
				
				if( $result->getReuseableType() == 1 || $result->getReuseableType() == 2){
					if( $result->getReuseableType() == 1 ){ //type 14
						//group
						$reUseID = $result->getReuseableID(); //id for the group
						
						
						
						/*
							Re-Factor!
						*/
							$gquery = "SELECT * FROM `formobject` WHERE `formID` = :formID order by `rowOrder` ASC"; //type no nt chosen
							$gquery = $conn->prepare( $gquery );
							$gquery->bindParam(':formID', $reUseID);
							if( $gquery->execute() ){
								while( $gresult = $gquery->fetchObject("formobject") ){
									
									
									$fieldType = $gresult->getType();
									$hasReturnValue = 1;
									if( isset($fieldTypes) && isset($fieldTypes[$fieldType]) ){
										 if( class_exists($fieldTypes[$fieldType]) ){
											$ClassFunction = new $fieldTypes[$fieldType]();
											if( is_object($ClassFunction) ){
												if( method_exists( $ClassFunction, "hasReturnValue") ){
													$hasReturnValue = $ClassFunction->hasReturnValue();
												}
											}
										 }
									}
									
									if( $hasReturnValue ){
														
									
									
										//echo generateHtml( $result );
										$inputName = $gresult->getName();
										$inputID = $gresult->getId();
										$postBackID = 'input_'.$reUseID.'_'.$inputID;
										$postBackValue = "";
										$encryptData = $gresult->getEncrypted();
										$required = $gresult->getRequired();
										$isListType = (($gresult->getListType() == 1 || $gresult->getListType() == 2) ? 1 : 0);
										
										
										//get type, use type to get value & error etc based on name??
										
										
										if( isset($_POST[$postBackID] ) ){
											if( $isListType ){
												if( is_array($_POST[$postBackID]) ){
													$arr = $_POST[$postBackID];
													$postBackValue = implode(",",$arr);
												}else{
													$postBackValue = (isset($_POST[$postBackID]) ? $_POST[$postBackID] : "");
												}
											}else{
												$postBackValue = (isset($_POST[$postBackID]) ? $_POST[$postBackID] : "");
											}
										}
										
										if( $postBackValue != "" && $encryptData ){ //encrypting of global form must be some or all
											$encryptedD = $encryptor->encrypt( $postBackValue );
											$postBackValue = $encryptedD;
										}
										
										//check the data for errors...
										if( isset( $inputName ) && $inputName != "" ){
											$capturedData[ $counter."_$inputName" ] = $postBackValue;		
										}else{
											$capturedData[ $counter."_$postBackID" ] = $postBackValue;
										}
										
										$saveRow[] = array("item" => $counter, "encrypted" => ($encryptData == 1 ? 1 : 0), "name" => $inputName, "value" => $postBackValue);
										
										$counter++;
									
									
									
									}
									
									
									
									
									
								}
							}
					}else{ //type
					
					}
					
					
					continue;
				}
				
				//-------------------------------------------------------------
				$fieldType = $result->getType();
				$className = "";
				$hasReturnValue = 1;
				$validates = 0;
				$ObjectType = null;
				
				if( isset($fieldTypes) && isset($fieldTypes[$fieldType]) ){
					 if( class_exists($fieldTypes[$fieldType]) ){
						$className = $fieldTypes[$fieldType];
						$ClassFunction = new $fieldTypes[$fieldType]($result);
						if( is_object($ClassFunction) ){
							$ObjectType = $ClassFunction;
							
							if( method_exists( $ClassFunction, "hasReturnValue") ){
								$hasReturnValue = $ClassFunction->hasReturnValue();
							}
							
							if( method_exists($ClassFunction, "validate") ){
								$validates = 1;
							}
							
						}
					 }
				}
				
				//echo $className.'<br />';
				if( $className == "fileupload"){
						if( !file_exists( FORM_SUBMISSION_DATA.DIRECTORY_SEPARATOR.$formID ) ){
								mkdir( FORM_SUBMISSION_DATA.DIRECTORY_SEPARATOR.$formID );
								//form Data here
								
								
								
								
						}	
						
						//exit;
				}
				
				
				
				
				if( $hasReturnValue ){
				
					//echo generateHtml( $result );
					$inputName = $result->getName();
					$inputID = $result->getId();
					$postBackID = 'input_'.$formID.'_'.$inputID;
					$postBackValue = "";
					$encryptData = $result->getEncrypted();
					$required = $result->getRequired();
					$isListType = (($result->getListType() == 1 || $result->getListType() == 2) ? 1 : 0);
					
					
					
					
					if( $className == "fileupload"){
						//handle in validate?
						echo "Required: ".$required.'<br />';
						$target_dir = FORM_SUBMISSION_DATA.DIRECTORY_SEPARATOR.$formID.DIRECTORY_SEPARATOR;
						echo "Target dir: ".$target_dir.'<br />';
						echo "Input_ID: ".$postBackID.'<br />';
						
						$regex = $result->getRegex();
						
						$target_file = $target_dir . time().'_'. basename($_FILES[$postBackID]["name"]);
						$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
						$size = $_FILES[$postBackID]["size"];
						
						echo "FileName: ".$target_file.'<br />';
						echo "Regex: ".$regex.'<br />';
						echo $target_file.'<br />';
						echo $target_dir.'<br />';
						echo "file type: ".$fileType.'<br />';
						echo "size: ".$size.'<br />';
						
						if( !file_exists($target_file) ){
						
								if (move_uploaded_file($_FILES[$postBackID]["tmp_name"], $target_file)) {
										echo "The file ". basename( $_FILES[$postBackID]["name"]). " has been uploaded.";
								} else {
										echo "Sorry, there was an error uploading your file.";
								}
										
						}else{
								echo "File (".$target_file.") already Exists";
						}
						//exit;
						
						
					}//end file upload
					
					
					//should do checking based on type ex, if empty and is required... etc
					
					if( isset($_POST[$postBackID] ) ){
						if( $isListType ){
							if( is_array($_POST[$postBackID]) ){
								$arr = $_POST[$postBackID];
								$postBackValue = implode(",",$arr);
							}else{
								$postBackValue = (isset($_POST[$postBackID]) ? $_POST[$postBackID] : "");
							}
						}else{
							$postBackValue = (isset($_POST[$postBackID]) ? $_POST[$postBackID] : "");
						}
					}
					
					if( $postBackValue != "" && $encryptData ){ //encrypting of global form must be some or all
						$encryptedD = $encryptor->encrypt( $postBackValue );
						$postBackValue = $encryptedD;
					}
					
					//check the data for errors...
					if( isset( $inputName ) && $inputName != "" ){
						$capturedData[ $counter."_$inputName" ] = $postBackValue;		
					}else{
						$capturedData[ $counter."_$postBackID" ] = $postBackValue;
					}
					
					
					if( $validates ){
						if( $ObjectType != null ){
							echo "Validating Object...<br />";
							$valid = $ObjectType->validate($postBackValue);
							
							if( $valid ){
								//continue
							}else{
								$errors++;
								echo "Error Count: ".$ObjectType->errorCount. " - ".print_r($ObjectType->errors,true);
							}
							
							//echo '<pre>'.print_r( $ObjectType , true).'</pre>';
							
						}
					}
					
					$saveRow[] = array("item" => $counter, "encrypted" => ($encryptData == 1 ? 1 : 0), "name" => $inputName, "value" => $postBackValue);
					
					$counter++;
				
				}
			}
			
		}
		
		if( $errors > 0 ){
			echo "<p>This data contains errors and would not be stored</p>";
		}else{
			echo "<p>Stored Data</p>";
		}
		
		
		
		pa( array_filter($capturedData) ); //array_filter removes empty values	
		
		
		echo json_encode( $saveRow );
		
		//store in DB as flat JSON or as key-value 
		//submission (id) - form (id) - date - ip
		//submissionID-key-value
		
		$saved1 = 0;
		$saved2 = 0;
	
		if( (isset($_REQUEST['realPost']) && $_REQUEST['realPost'] == "1" ) || ( isset($_POST['forceSave']) && $_POST['forceSave'] == 1) ){
	
			$entry = new Formentry($conn);
			$entry->setFormID( $formID );
			$entry->setSaveTime( getCurrentDateTime() );
			$entry->setRemoteIP( $_SERVER['REMOTE_ADDR'] );
			$entry->setRemoteSession( session_id()  );
			if( $entry->save() > 0 ){
				//entry saved.
				echo "<br /><br />Entry Created";
				$Formsavejson = new Formsavejson($conn);
				$Formsavejson->setEntryID( $entry->getId() );
				$Formsavejson->setData( json_encode($saveRow) );
				
				$saved1 = 1;
				
				if( $Formsavejson->save() > 0 ){
					echo "<br /><br />Entry Saved as JSON";
					$saved2 = 1;
				}
			}
		}else{
			echo "<br />Not inserting Test Data into DB...<br />";
		}
	
	
		echo "<br /><br /><a href='/views/form/reviewSubmissions.php?formID=".$formID."'><i class='fa fa-clipboard'></i> View Submissions</a>";
		
		//back?? 
		//dont save the test?!
	
	
		if( (isset($_REQUEST['realPost']) && $_REQUEST['realPost'] == "1") || ( isset($_POST['forceSave']) && $_POST['forceSave'] == 1) ){
			ob_clean();
			if( $saved1 == 1 && $saved2 == 1){
				
				//thank you text
				echo "<h1>Thank you for your submission</h1>";
			}
			
			if( isset($_POST['forceSave']) && $_POST['forceSave'] == 1 ){
				echo '<hr />';	
			}
		}
	
	
		exit;
	}else{
		echo "No Posted Data";
		exit;
	}
?>