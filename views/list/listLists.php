<?php
	include "../../includes/include.php";
	$conn = getConnection();
	
	$query = "SELECT * FROM `listset` order by `listName` ASC";
	
	$query = $conn->query( $query );
	
	if( $query->execute() ){
		$results = $query->rowCount();
		
		echo '<div class="row">';
			echo '<p style="font-size: 11px">Create lists to be used as re-useable content for radio buttons, checkboxes, select boxes etc!</p><hr />';
		echo '</div>';
		
		while( $result = $query->fetchObject("listset") ){	
			echo '<div class="row">';
				echo '<p><a class="btn pickList" onClick="pickListItem(\''.$result->getId().'\',\''.$result->getListName().'\');"><i class="fa fa-check"></i></a> <a  href="/views/list/editList.php?listID='.$result->getId().'"><i class="fa fa-pencil"></i> &ldquo;'.$result->getListName().'&rdquo; '.($result->getListType() == 1 ? '<i class="fa fa-th-list"></i>' : '<i class="fa fa-align-justify"></i>').'</a> - <a target="_blank" href="/views/list/previewList.php?listID='.$result->getId().'"><i class="fa fa-desktop"></i> Preview List</a></p>';
			echo '</div>';
		}
		
		if( $results == 0 ){
			echo '<div class="row">';
				echo '<p><i class="fa fa-frown-o"></i> Oh Noes! You haven\'t created any Lists. I mean stay the course if you want but re-useable data might be helpful...</p>';
			echo '</div>';
		}
	}
	
	echo '<div class="row"><a class="btn" href="/views/list/buildList.php"><i class="fa fa-plus"></i> Create List</a></div>';
?>