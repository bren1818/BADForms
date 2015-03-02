<?php
	include "../../includes/include.php";
	$conn = getConnection();
	
	$query = "SELECT * FROM `theform` where `isGroup` <> 1 order by `title` ASC";
	
	$query = $conn->query( $query );
	
	if( $query->execute() ){
		while( $result = $query->fetchObject("Theform") ){	
			echo '<div class="row">';
				//active?
				//last modified
				//created
			
				echo '<p><a  href="/views/form/buildForm.php?formID='.$result->getId().'"><i class="fa fa-pencil"></i> &ldquo;'.$result->getTitle().'&rdquo; </a> - <a target="_blank" href="/renderForm.php?formID='.$result->getId().'"><i class="fa fa-desktop"></i> Preview Form</a> - <a href="/views/form/reviewSubmissions.php?formID='.$result->getId().'">Submissions</a></p>';
			echo '</div>';
		}
	}
	
	echo '<div class="row"><a class="btn" href="/views/form/createForm.php"><i class="fa fa-plus"></i> Create Form</a></div>';
?>