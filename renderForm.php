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
	
	
	$query = "SELECT * FROM `formobject` WHERE `formID` = :formID order by `rowOrder` ASC";
	$query = $conn->prepare( $query );
	$query->bindParam(':formID', $formID);
	
	pageHeader();
	?>
	<link rel="stylesheet" href="/css/formPreview.css" />
    <link rel="stylesheet" href="/getCss.php?formID=<?php echo $formID; ?>" />
	<?php
	echo '<form method="POST" action="/captureForm.php?formID='.$formID.'">';
	$formJS = "";
	if( $query->execute() ){
		while( $result = $query->fetchObject("formobject") ){
			//echo generateHtml( $result );
			
			$type = "".$listTypes[ $result->getType() ];
			
			if( $type != "no-type-select" ){
			
				if( class_exists( $type ) ){
				
					$class = new $type($result);
				
					echo '<div id="form-item-'.$result->getId().'" class="formRow type-'.$type.'">';
						$class->render();
					echo '</div>';
					
					if( method_exists($class, "getJS") ){
						$formJS = $formJS.$class->getJS();
					}
					
				}else{
					echo '<div class="formRow">';
						echo "Error, Class: ".$type." does not exist";
					echo '</div>';	
				}
				
			}
			
		}
	}
	echo '<div class="formRow">';
	echo '<input class="btn" type="submit" value="SUBMIT" />';
	echo '</div>';
	echo '<input type="hidden" name="formID" value="'.$formID.'"/>';
	echo "</form>";
?>
<script type="text/javascript">
	<?php echo $formJS; ?>
</script>
<script src="/getJS.php?formID=<?php echo $formID; ?>" type="text/javascript"></script>
<?php
pageFooter();
?>