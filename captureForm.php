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
				
				$encryptionKey = BASE_ENCRYPTION_SALT."";
				
				//if requires Encryption
				$encryptor = new BrenCrypt();
				$encryptor->setKey( $encryptionKey );
				
				
			}else{
				echo "Non Numeric Form ID";
				exit;
			}
		}else{
			//unknown formID
			exit;
		}
	
		$query = "SELECT * FROM `formobject` WHERE `formID` = :formID order by `rowOrder` ASC"; //type no nt chosen
		$query = $conn->prepare( $query );
		$query->bindParam(':formID', $formID);
	
		$capturedData = array();
		$counter = 1;
		
		$saveRow = array();
	
		if( $query->execute() ){
			while( $result = $query->fetchObject("formobject") ){
				//echo generateHtml( $result );
				$inputName = $result->getName();
				$inputID = $result->getId();
				$postBackID = 'input_'.$formID.'_'.$inputID;
				$postBackValue = "";
				$encryptData = $result->getEncrypted();
				$required = $result->getRequired();
				$isListType = (($result->getListType() == 1 || $result->getListType() == 2) ? 1 : 0);
				
				
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
				
				if( $postBackValue != "" && $encryptData ){
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
		echo "Stored Data";
		pa( $capturedData );	
		
		
		echo json_encode( $saveRow );
		
		//store in DB as flat JSON or as key-value 
		//submission (id) - form (id) - date - ip
		//submissionID-key-value
	
	
		exit;
	}else{
		echo "No Posted Data";
		exit;
	}
?>