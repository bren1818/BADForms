<?php
	//delete css
	//delete js
	//delete children
	//delete Form
	//delete Submissions
	
	include "../../includes/include.php";
	
	pageHeader();

	if( isset($_REQUEST) && isset($_REQUEST['formID']) ){
		$formID = $_REQUEST['formID'];
		
		
	$conn = getConnection(); //set to DB Conn
	$clone = new Theform($conn); 
	$clone = $clone->load( $formID );
	
	$deletedCSSJSS = 1;
	$deletedElements = 1;
	
	if( is_object($clone) && $clone->getId() > 0 ){
		echo "<p>Loading Form to Delete with ID: ".$formID."</p>";
		//clone was made in memory
		
		$clone->setConnection( $conn );
			
		echo "<p>Commence Deletion of CSS & JS</p>";	
		$cssJS = $conn->prepare("SELECT * FROM `formcode` WHERE `formID` = :formID");
		$cssJS->bindParam('formID', $formID);
		
		if( $cssJS->execute() ){
			while( $code = $cssJS->fetchObject("Formcode") ){
					if( $code->getCodeType() == 1 ){
						echo "<p>Deleting CSS</p>";
					}else if( $code->getCodeType() == 2 ){
						echo "<p>Deleting JS</p>";
					}
					
					$code->setConnection( $conn );
					
					if( $code->delete() > 0 ){
						if( $code->getCodeType() == 1 ){
							echo "<p>CSS Deleted</p>";
						}else if( $code->getCodeType() == 2 ){
							echo "<p>JS Deleted</p>";
						}
					}else{
						$deletedCSSJSS = 0;
						if( $code->getCodeType() == 1 ){
							echo "<p>CSS could <b>not</b> be Deleted</p>";
						}else if( $code->getCodeType() == 2 ){
							echo "<p>JS could <b>not</b> be Deleted</p>";
						}
					}	
			}
		}else{
			echo "<p>Could not Delete CSS or JS</p>";	
		}
		
		/*Actual Objects */
		
		$formElements = $conn->prepare("SELECT * FROM `formobject` WHERE `formID` = :formID");
		$formElements->bindParam('formID', $formID);
		$cloned = 0;
		$failed = 0;
		if( $formElements->execute() ){
			
			while( $element = $formElements->fetchObject("Formobject") ){
				
				$element->setConnection($conn);
				echo "<p>Attempting to Delete: '".$element->getLabel()."'</p>";
				//$element->setFormID( $cloneID );
				
				if( $element->delete() > 0 ){
					echo "<p>Deletion of: '".$element->getLabel()."' successful.</p>";
					$cloned++;	
				}else{
					$deletedElements = 0;
					echo "<p>Could not Delete: '".$element->getLabel()."'</p>";
					$failed++;	
				}
			}
			
			echo "<p>Unable to delete ".$failed." form objects</p>";
			echo "<p>Successfully deleted: ".$cloned." form objects</p>";
			
		}else{
			echo "<p>Could not delete Form Object's Elements</p>";
		}
		
		
		
		if( $deletedCSSJSS && $deletedElements ){
			
			if( $clone->delete() > 0 ){
				echo "<p>Form Deleted</p>";	
			}
			
		}else{
			echo "<p>Some Elements could not be deleted. Please contact an Administrator</p>";	
		}
	}
		
	echo "<p>Form Deletion Complete!</p>";
	echo '<a class="btn" href="/">Home</a>';	
		
	}else{
		//$formID = 1;
		echo "No Form ID Supplied";
		exit;
	}
	pageFooter();
?>
