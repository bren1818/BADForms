<?php
	include "../../includes/include.php";

	$securityKey = 1;
	$ownerID = 1;
	$formID = 1;
	
/*	
type, i
label, v
name, v
defaultVal, v
errorText, v
placeholder, v
regex, v
minVal, i
maxVal, i
minLength, i
maxLength, i

listID, i
csList, v

classes, v
isRequired, i
encryptVal, i
formID, i
rowOrder, i
*/
	
	pageHeader();
	
	?>
	<script src="<?php echo JS_DIR.'/builder.js'; ?>"></script>
	<?php
	
	$conn = getConnection();
	
	$query = "Select `id` from `formcode` where `formID` = :formID AND `codeType` = 1";
	$query = $conn->prepare( $query );
	$query->bindParam(':formID', $formID);
	
	$css = "";
	if( $query->execute() ){
		$css = $query->fetchAll(PDO::FETCH_ASSOC);
		if( isset($css) && isset( $css[0]['id'] ) ){
			$css = "&id=".$css[0]['id'];
		}else{
			$css = "";
		}
	}
	
	$query = "Select `id` from `formcode` where `formID` = :formID AND `codeType` = 2";
	$query = $conn->prepare( $query );
	$query->bindParam(':formID', $formID);
	$js = "";
	if( $query->execute() ){
		$js = $query->fetchAll(PDO::FETCH_ASSOC);
		
		if( isset($js) && isset( $js[0]['id'] ) ){
			$js = "&id=".$js[0]['id'];
		}else{
			$js = "";
		}
	}

	
?>
<a href="/views/form/formCssJs.php?codeType=1&formID=<?php echo $formID; echo $css;?>">Edit Form CSS</a>
<a href="/views/form/formCssJs.php?codeType=2&formID=<?php echo $formID; echo $js; ?>">Edit Form Javascript</a>

<!-- pull id if applicable -->


<div id="formHolder">
<ul id="sortable">
<?php 
	include "../../getFormEntryRow.php";
	
	$query = "SELECT * FROM `formobject` WHERE `formID` = :formID";
	$query = $conn->prepare( $query );
	$query->bindParam(':formID', $formID);
	
	if( $query->execute() ){
		
		while( $result = $query->fetchObject("formobject") ){
			//$object = $result;
			//echo '<li>'.pa($result).'</li>';
			echo '<li>'.generateHtml( $result ).'</li>';
		}
	}
?>
</ul>
</div>

<button id="addRow">Add Row</button>
<button id="save">Save</button>

<?php
	pageFooter();

?>