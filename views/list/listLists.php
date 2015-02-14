<?php
	include "../../includes/include.php";
	$conn = getConnection();
	
	$query = "SELECT * FROM `listset` order by `listName` ASC";
	
	$query = $conn->query( $query );
	
	if( $query->execute() ){
		while( $result = $query->fetchObject("listset") ){	
			echo '<div class="row">';
				echo '<p><a class="btn" onClick="pickListItem(\''.$result->getId().'\',\''.$result->getListName().'\');"><i class="fa fa-check"></i></a> '.($result->getListType() == 1 ? '<i class="fa fa-th-list"></i>' : '<i class="fa fa-align-justify"></i>').' '.$result->getListName().'</p>';
			echo '</div>';
		}
	}
	
?>