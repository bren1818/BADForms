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
	
	if(  null !== ($Theform->getJqTheme()) && $Theform->getJqTheme() != "" && null !== ($Theform->getJqVersion()) && $Theform->getJqVersion() != "" ){
	
	echo ' <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/'.$Theform->getJqVersion().'/themes/'.$Theform->getJqTheme().'/jquery-ui.css" />';
	//echo $Theform->getJqVersion().'/themes/'.$Theform->getJqTheme();
		}else{
	?>
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
    <?php
		}
	?>
    <link rel="stylesheet" href="/css/formPreview.css" />
    <link rel="stylesheet" href="/getCss.php?formID=<?php echo $formID; ?>" />
	<?php
	//check if file?
	
	//enctype="multipart/form-data
	
	echo '<form method="POST" class="previewForm" action="/captureForm.php?formID='.$formID.'" enctype="multipart/form-data">';
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
						//pa( $result );
						
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
	if( $Theform->getIsGroup() == 1){
		echo '<div class="formRow">';
		echo '<p>This Group\'s elements will be rendered along with the other elements of the form.</p>';
		//echo '<p><a href="/views/group/buildGroup.php?formID='.$Theform->getId().'">Back to Group Editor</a></p>';
		echo '</div>';
	}else{
		//echo '<div class="formRow">';
		//echo '<p><a href="/views/form/buildForm.php?formID='.$Theform->getId().'">Back to Form Editor</a></p>';
		//echo '</div>';
		
		echo '<div class="formRow">';
		
		echo '<br /><input class="btn" type="submit" value="TEST - SUBMIT" />';
		echo '</div>';
		
	}
	echo '<input type="hidden" name="formID" value="'.$formID.'"/>';
	echo '<div class="clear"></div>';
	echo "</form>";

echo '<div class="clear"></div>';
?>
<br />
<hr />
<br />
<p><a href="/views/form/buildForm.php?formID=<?php echo $formID; ?>" class='btn'><i class="fa fa-list-alt"></i> Back to Form</a> - <label for="disableHTML5Check">Disable html5 Validation - this will allow you to submit invalid content. <input id="disableHTML5Check" name="disableHTML5Check" type="checkbox" /></label></p>

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
	
	$('#disableHTML5Check').change(function() {
		if(this.checked) {
			//Do stuff
			alert("HTML5 Validation has been disabled");
			$('.previewForm').attr("novalidate", "");
		}else{
			$('.previewForm').removeAttr("novalidate");
		}
	});
	
});
</script>
<script src="/getJS.php?formID=<?php echo $formID; ?>" type="text/javascript"></script>
<?php
pageFooter();
?>