<?php
	include "includes/include.php";
	$conn = getConnection();
	
	if( isset($_REQUEST) && isset($_REQUEST['formID']) && $_REQUEST['formID'] != "" ){
		$formID = $_REQUEST['formID'];
	}else{
		echo "No formID received";
		exit;
	}
	
	//try loading form
	$Theform = new Theform($conn);
	$Theform = $Theform->load($formID);
	
	if( is_object($Theform) ){
		$now = time();
		if( $Theform->getSunrise() == "0000-00-00 00:00:00"){
			//ignore it
		}else{
			$sunrise = strtotime( $Theform->getSunrise() );
			if( $now < $sunrise ){
				echo "Form not available yet";
				exit;
			}
		}
	
		if( $Theform->getSunset() == "0000-00-00 00:00:00"){
			//ignore it
		}else{
			$sunset = strtotime( $Theform->getSunset() );
			if( $now > $sunset ){
				echo "Form no longer available";
				exit;
			}
		}
	}else{
		echo "Could not load Form...";
		exit;
	}
	
	
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
	echo '<form method="POST" class="previewForm" action="/captureForm.php?formID='.$formID.'">';
	$formJS = "";
	if( $query->execute() ){
		$rows = 0;
		while( $result = $query->fetchObject("formobject") ){
			//echo generateHtml( $result );
			
			$type = "".$listTypes[ $result->getType() ];
			
			if( $type != "no-type-select" ){
			
				if( class_exists( $type ) ){
					
					$rows++;
				
					$class = new $type($result);
				
					echo '<div id="form-item-id-'.$result->getId().'" class="formRow type-'.$type.' row-'.$rows.'">';
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
$(function(){
	$( document ).tooltip({show: null,
		position: {
			my: "left top",
			at: "left bottom"
		},
		open: function( event, ui ) {
			ui.tooltip.animate({ top: ui.tooltip.position().top + 10 }, "fast" );
		}
	});
});
</script>
<script src="/getJS.php?formID=<?php echo $formID; ?>" type="text/javascript"></script>
<?php
pageFooter();
?>