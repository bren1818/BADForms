<?php
	include "../../includes/include.php";
	$conn = getConnection();
	
	$query = "SELECT * FROM `theform` order by `title` ASC";
	
	$query = $conn->query( $query );
	
	if( $query->execute() ){
		while( $result = $query->fetchObject("Theform") ){	
			echo '<div class="row">';
				echo '<p><a target="_blank" href="/views/form/buildForm.php?formID='.$result->getId().'"><i class="fa fa-pencil"></i> '.$result->getTitle().' </a> - <a target="_blank" href="/renderForm.php?formID='.$result->getId().'"><i class="fa fa-desktop"></i> Preview Form</a></p>';
			echo '</div>';
		}
	}
	
	echo '<div class="row"><a class="btn" target="_blank" href="/views/form/createForm.php"><i class="fa fa-list-alt"></i> Create Form</a></div>';
?>