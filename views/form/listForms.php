<?php
	include "../../includes/include.php";
	$conn = getConnection();
	
	$query = "SELECT * FROM `theform` where `isGroup` <> 1 order by `lastUpdated` DESC";
	
	$query = $conn->query( $query );
	
	if( $query->execute() ){
		$results = $query->rowCount();
		
		echo '<div class="row">';
			echo '<p style="font-size: 11px">Create Forms to collect your data. Forms can contain Groups, or other input elements.</p><hr />';
		echo '</div>';		
		
		while( $result = $query->fetchObject("Theform") ){	
			echo '<div class="row">';
				echo '<p><a  href="/views/form/buildForm.php?formID='.$result->getId().'"><i class="fa fa-pencil"></i> &ldquo;'.$result->getTitle().'&rdquo; </a> - <a target="_blank" href="/renderForm.php?formID='.$result->getId().'"><i class="fa fa-desktop"></i> Preview Form</a> - <a href="/views/form/reviewSubmissions.php?formID='.$result->getId().'">Submissions</a></p>';
			echo '</div>';
		}
		
		if( $results == 0 ){
			echo '<div class="row">';
				echo '<p><i class="fa fa-thumbs-o-down"></i> Oh Noes! You haven\'t created any forms. Thats kind of the purpose of the application!</p>';
			echo '</div>';
		}
		
	}
	
	echo '<div class="row"><a class="btn" href="/views/form/createForm.php"><i class="fa fa-plus"></i> Create Form</a></div>';
?>