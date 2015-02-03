<?php
	include "includes".DIRECTORY_SEPARATOR."include.php";
	ob_clean();
	header('Content-Type: text/css; charset=UTF-8');
	echo "/**Generated CSS FILE FOR FORM**/\r\n";
	if( isset($_REQUEST['formID']) && $_REQUEST['formID'] != "" ){
		$formID = (int)$_REQUEST['formID'];
		$conn = getConnection();
		$query = "SELECT `code` FROM `formcode` WHERE `formID` = :formID AND `codeType` = 1";
		$query = $conn->prepare( $query );
		$query->bindParam(':formID', $formID);
		if( $query->execute() ){
			if( $query->rowCount() > 0 ){
				$CSS = $query->fetch(PDO::FETCH_ASSOC);
				if( isset( $CSS['code'] ) ){
					echo $CSS['code'];
				}
			}
		}
	}
?>