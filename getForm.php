<?php
	include "includes/include.php";
	
	$formID = "";
	$securityKey = "";
	
	if( isset($_REQUEST) && isset($_REQUEST['ID']) && $_REQUEST['ID'] != "" ){
		$formID = $_REQUEST['ID'];
	}
	
	if( isset($_REQUEST) && isset($_REQUEST['key']) && $_REQUEST['key'] != "" ){
		$securityKey = $_REQUEST['key'];
	}
	
	if( $formID != "" && $securityKey != "" ){
		
			if( md5($formID.BASE_ENCRYPTION_SALT) == $securityKey ){
				ob_clean();
				//echo file_get_contents("renderForm.php?formID=".$formID);
				
	$conn = getConnection();			
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
	
	$title = $Theform->getTitle();
	
	pageHeader($title, false);
	
	
	if(  null !== ($Theform->getJqTheme()) && $Theform->getJqTheme() != "" && null !== ($Theform->getJqVersion()) && $Theform->getJqVersion() != "" ){
	
	echo ' <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/'.$Theform->getJqVersion().'/themes/'.$Theform->getJqTheme().'/jquery-ui.css" />';
	
		}else{
	?>
    	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
    <?php
		}
	?>
	<link rel="stylesheet" href="<?php echo PUBLIC_SERVER_ADDRESS; ?>/css/formPreview.css" />
    <link rel="stylesheet" href="<?php echo PUBLIC_SERVER_ADDRESS; ?>/getCss.php?formID=<?php echo $formID; ?>" />
	<?php
	echo '<form method="POST" class="previewForm" action="'.PUBLIC_SERVER_ADDRESS.'/captureForm.php?formID='.$formID.'&realPost=1">';
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
	//if( $Theform->getIsGroup() == 1){
		//echo '<div class="formRow">';
		//echo '<p>This Group\'s elements will be rendered along with the other elements of the form.</p>';
		//echo '<p><a href="/views/group/buildGroup.php?formID='.$Theform->getId().'">Back to Group Editor</a></p>';
		//echo '</div>';
	//}else{
		//echo '<div class="formRow">';
		//echo '<p><a href="/views/form/buildForm.php?formID='.$Theform->getId().'">Back to Form Editor</a></p>';
		//echo '</div>';
		
		echo '<div class="formRow">';
		echo '<input class="btn" type="submit" value="SUBMIT" />';
		echo '</div>';
	//}
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
<script src="<?php echo PUBLIC_SERVER_ADDRESS; ?>/getJS.php?formID=<?php echo $formID; ?>" type="text/javascript"></script>
<?php
				
				
				
				
				
				
				exit;
			}else{
				echo "Invalid Security Code";
				exit;
			}
	}else{
		echo "Invalid Security Code.";
		exit;
	}
?>