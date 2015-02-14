<?php
	include "../../includes/include.php";
	$conn = getConnection();
	
	$query = "SELECT * FROM `listset` order by `listName` ASC";
	
	$query = $conn->query( $query );
	
	if( $query->execute() ){
		while( $result = $query->fetchObject("listset") ){	
			echo '<div class="row">';
				echo '<p><a class="btn pickList" onClick="pickListItem(\''.$result->getId().'\',\''.$result->getListName().'\');"><i class="fa fa-check"></i></a> '.($result->getListType() == 1 ? '<i class="fa fa-th-list"></i>' : '<i class="fa fa-align-justify"></i>').' '.$result->getListName().' - <a target="_blank" href="/views/list/previewList.php?listID='.$result->getId().'">Preview List</a> - <a target="_blank" href="/views/list/editList.php?listID='.$result->getId().'"><i class="fa fa-pencil"></i> Edit List</a></p>';
			echo '</div>';
		}
	}
	
	echo '<div class="row"><a class="btn" target="_blank" href="/views/list/buildList.php"><i class="fa fa-plus"></i> Create List</a></div>';
?>