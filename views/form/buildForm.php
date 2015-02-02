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
<a href="/views/form/formCssJs.php?codeType=1&formID=<?php echo $formID; ?>">Edit Form CSS</a>
<a href="/views/form/formCssJs.php?codeType=2&formID=<?php echo $formID; ?>">Edit Form Javascript</a>

<!-- pull id if applicable -->


<div id="formHolder">
<ul id="sortable">
<?php /* 
load form objects
<li>
	<?php
		include "getFormEntryRow.php";
		$row = generateHtml("");
		echo $row;
	?>
</li>
*/?>
</ul>
</div>

<button id="addRow">Add Row</button>
<button id="save">Save</button>

<?php
	pageFooter();

?>