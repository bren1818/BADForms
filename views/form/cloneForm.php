<?php
	//clone form

	//get id - clone it, on successful clone 
	//clone children
	//clone css
	//clone js
	
	include "../../includes/include.php";
	
	pageHeader();

	if( isset($_REQUEST) && isset($_REQUEST['formID']) ){
		$formID = $_REQUEST['formID'];
		
		
	$conn = getConnection(); //set to DB Conn
	$clone = new Theform($conn); 
	$clone = $clone->load( $formID );
	if( is_object($clone) && $clone->getId() > 0 ){
		echo "<p>Loading Form to Clone with ID: ".$formID."</p>";
		//clone was made in memory
		$clone->setId("");
		$clone->setOwner( $currentUser->getId() );
		$clone->setTitle( $clone->getTitle()." (clone)" );
		$clone->setNumViews( 0 );
		$clone->setNumSubmissions ( 0 );
		$clone->setEnabled ( 0 );
		$clone->setCreated( date('Y-m-d H:i:s',time()) );
		$clone->setConnection( $conn );
		if( $clone->save() > 0 ){
			$cloneID = $clone->getId();
			echo "<p>Clone Object Created... with ID: ".$cloneID."</p>";
			
			echo "<p>Commence Cloning CSS & JS</p>";	
			$cssJS = $conn->prepare("SELECT * FROM `formcode` WHERE `formID` = :formID");
			$cssJS->bindParam('formID', $formID);
			if( $cssJS->execute() ){
				while( $code = $cssJS->fetchObject("Formcode") ){
						
						if( $code->getCodeType() == 1 ){
							echo "<p>Cloning CSS</p>";
						}else if( $code->getCodeType() == 2 ){
							echo "<p>Cloning JS</p>";
						}
						$code->setId('');
						$code->setFormID( $cloneID );
						$code->setLastUpdate( date('Y-m-d H:i:s',time()) );
						$code->setConnection( $conn );
						if( $code->save() > 0 ){
							if( $code->getCodeType() == 1 ){
								echo "<p>CSS Cloned</p>";
							}else if( $code->getCodeType() == 2 ){
								echo "<p>JS Cloned</p>";
							}
						}else{
							if( $code->getCodeType() == 1 ){
								echo "<p>CSS could <b>not</b> be Cloned</p>";
							}else if( $code->getCodeType() == 2 ){
								echo "<p>JS could <b>not</b> be Cloned</p>";
							}
						}
						
				}
			}else{
				echo "<p>Could not clone CSS or JS</p>";	
			}
			
			/*Actual Objects */
			
			$formElements = $conn->prepare("SELECT * FROM `formobject` WHERE `formID` = :formID");
			$formElements->bindParam('formID', $formID);
			$cloned = 0;
			$failed = 0;
			if( $formElements->execute() ){
				
				while( $element = $formElements->fetchObject("Formobject") ){
					$element->setId("");
					$element->setConnection($conn);
					echo "<p>Attempting to clone: '".$element->getLabel()."'</p>";
					$element->setFormID( $cloneID );
					
					if( $element->save() > 0 ){
						echo "<p>clone of: '".$element->getLabel()."' successful.</p>";
						$cloned++;	
					}else{
						echo "<p>Could not clone: '".$element->getLabel()."'</p>";
						$failed++;	
					}
				}
				
				echo "<p>Unable to clone ".$failed." form objects</p>";
				echo "<p>Successfully cloned: ".$cloned." form objects</p>";
				
			}else{
				echo "<p>Could not get Form Object's Elements</p>";
			}
			
			
		}else{
			echo "<p>Error Could not clone Form</p>";	
		}
		
	}
		
	echo "<p>Form Cloning Complete!</p>";
	echo '<a class="btn" href="/views/form/buildForm.php?formID='.$cloneID.'">View Clone</a>';	
		
	}else{
		//$formID = 1;
		echo "No Form ID Supplied";
		exit;
	}
	pageFooter();
?>
