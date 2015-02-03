<?php
	include "includes/include.php";
	$conn = getConnection();
	
	$formID = 1;
	
	
	$types = "Select `id`, `name` FROM `objecttype`";
	$types = $conn->query( $types );
	$listTypes = array();
	if( $types->execute() ){
		while( $result = $types->fetch(PDO::FETCH_ASSOC) ){
			$listTypes[ $result['id'] ] = $result['name'];
		}
	}
	
	
	$query = "SELECT * FROM `formobject` WHERE `formID` = :formID";
	$query = $conn->prepare( $query );
	$query->bindParam(':formID', $formID);
	
	pageHeader();
	?>
	<link rel="stylesheet" href="/getCss.php?formID=<?php echo $formID; ?>" />
	<?php
	echo '<form method="POST" action="">';
	
	if( $query->execute() ){
		while( $result = $query->fetchObject("formobject") ){
			//echo generateHtml( $result );
			
			$type = "".$listTypes[ $result->getType() ];
			
			$class = new $type($result);
			
			echo '<div class="formRow">';
			$class->render();
			echo '</div>';
			
			//pa( $result );
			//echo '<hr>';
		}
	}
	echo '<div class="formRow">';
	echo '<input type="submit" value="SUBMIT" />';
	echo '</div>';
	echo '<input type="hidden" name="formID" value="'.$formID.'"/>';
	echo "</form>";
?>
<script src="/getJS.php?formID=<?php echo $formID; ?>" type="text/javascript"></script>
<?php
pageFooter();
?>