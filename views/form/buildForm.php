<?php
	include "../../includes/include.php";

	$securityKey = 1;
	$ownerID = 1;
	
	if( isset($_REQUEST) && isset($_REQUEST['formID']) ){
		$formID = $_REQUEST['formID'];
	}else{
		//$formID = 1;
		echo "No Form ID Supplied";
		exit;
	}
	
	pageHeader();
	
	?>
    <script type="text/javascript">var formID = <?php echo $formID; ?>;</script>
	<script src="<?php echo JS_DIR.'/builder.js'; ?>"></script>
	<link rel="stylesheet" href="<?php echo CSS_DIR.'/builder.css'; ?>"/>
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
<div class="formOptions">
<a class="btn" href="/"><i class="fa fa-home"></i> Home</a>
<a class="btn" href="/views/form/formCssJs.php?codeType=1&formID=<?php echo $formID; echo $css;?>"><i class="fa fa-pencil-square-o"></i> Edit Form CSS</a>
<a class="btn" href="/views/form/formCssJs.php?codeType=2&formID=<?php echo $formID; echo $js; ?>"><i class="fa fa-code"></i> Edit Form Javascript</a>
<a class="btn" href="/views/form/editForm.php?formID=<?php echo $formID; ?>"><i class="fa fa-pencil-square-o"></i> Edit Form Information</a>
<a class="btn" href="/renderForm.php?formID=<?php echo $formID; ?>"><i class="fa fa-desktop"></i> Preview Form</a>

</div>

<div id="listPicker"></div>

<!-- pull id if applicable -->
<?php
	$theForm = ""; //container
	$query = "SELECT * FROM `theform` WHERE `id` = :formID";
	$query = $conn->prepare( $query );
	$query->bindParam(':formID', $formID);
	
	if( $query->execute() ){
		$theForm = $query->fetchObject("theform");
	}
?>


<h2><?php if( is_object($theForm)){ echo $theForm->getTitle(); } ?></h2>
<p><?php if( is_object($theForm)){ echo $theForm->getDescription(); } ?></p>

<br />
<hr />
<h3>Form Fields</h3>
<div id="formHolder" class="encrypt-mode-<?php echo $theForm->getEncryptionMode(); ?>">
<ul id="sortable">
<?php 
	include "../../getFormEntryRow.php";
	
	$query = "SELECT * FROM `formobject` WHERE `formID` = :formID order by `rowOrder` ASC";
	$query = $conn->prepare( $query );
	$query->bindParam(':formID', $formID);
	
	if( $query->execute() ){
		while( $result = $query->fetchObject("formobject") ){
			echo generateHtml( $result );
		}
	}
?>
</ul>
</div>

<button class="btn" id="addRow"><i class="fa fa-plus"></i> Add Row</button> <button class="btn" id="save"><i class="fa fa-floppy-o"></i> Save</button>

<a class="btn" target="_blank" href="/renderForm.php?formID=<?php echo $formID; ?>"><i class="fa fa-desktop"></i> Preview Form</a>
<?php
	pageFooter();

?>