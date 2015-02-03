<?php
	include "includes".DIRECTORY_SEPARATOR."include.php";
	ob_clean();
	header('Content-Type: text/javascript');
	echo "/**Generated JS FILE FOR FORM**/\r\n";
	if( isset($_REQUEST['formID']) && $_REQUEST['formID'] != "" ){
		$formID = (int)$_REQUEST['formID'];
		$conn = getConnection();
		$query = "SELECT `code` FROM `formcode` WHERE `formID` = :formID AND `codeType` = 2";
		$query = $conn->prepare( $query );
		$query->bindParam(':formID', $formID);
		if( $query->execute() ){
			if( $query->rowCount() > 0 ){
				$JS = $query->fetch(PDO::FETCH_ASSOC);
				if( isset( $JS['code'] ) ){
					echo $JS['code'];
				}
			}
		}
	}
?>