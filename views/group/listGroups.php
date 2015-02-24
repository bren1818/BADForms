<?php
	include "../../includes/include.php";
	$conn = getConnection();
	
	$query = "SELECT * FROM `theform` WHERE `isGroup` = 1 order by `title` ASC";
	
	$query = $conn->query( $query );
	
	if( $query->execute() ){
		while( $result = $query->fetchObject("Theform") ){	
			echo '<div class="row">';
				//active?
				//last modified
				//created
			
				echo '<p><a class="btn pickList" onClick="pickGroupItem(\''.$result->getId().'\', \'1\', \''.$result->getTitle().'\');"><i class="fa fa-check"></i></a> <a href="/views/group/buildGroup.php?formID='.$result->getId().'"><i class="fa fa-pencil"></i> &ldquo;'.$result->getTitle().'&rdquo; </a> - <a target="_blank" href="/renderForm.php?formID='.$result->getId().'"><i class="fa fa-desktop"></i> Preview Form</a></p>';
			echo '</div>';
		}
	}
	
	echo '<div class="row"><a class="btn" href="/views/group/createGroup.php"><i class="fa fa-plus"></i> Create Group</a></div>';
?>