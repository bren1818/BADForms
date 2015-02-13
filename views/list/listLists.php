<?php
	include "../../includes/include.php";
	$conn = getConnection();
	
	$query = "SELECT * FROM `listset`";
	
	$query = $conn->query( $query );
	
	if( $query->execute() ){
		while( $result = $query->fetchObject("listset") ){	
			echo '<div class="row">';
				echo $result->getId();
				echo $result->getListName();
				echo $result->getListType();
			echo '</div>';
		}
	}
	
?>