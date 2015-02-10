<?php
	include "../../includes/include.php";
	$conn = getConnection();
	pageHeader();
	$listset = "";
	
	if( isset($_REQUEST) && isset($_REQUEST['listID']) ){
		$listID = $_REQUEST['listID'];
		$listset = new Listset( $conn );
		$listset = $listset->load( $listID );
		
		//pa( $listset );
		
	}else{
		echo "Could not load list";
	}
	
?>
<form name="listset" id="listset" method="POST" action="" enctype="multipart/form-data">
	<!--
    <div class="formRow">
		<div class="rowLabel">
			<label for="formID">formID:*</label>
		</div>
		<div class="rowField">
			<input type="number" name="formID" id="formID" value="<?php echo (isset($listset) ?  $listset->getFormID() : ''); ?>" title="formID is a required field. " required="required" />
		</div>
	</div>
    -->
	<div class="formRow">
		<div class="rowLabel">
			<label for="listName">List Name:*</label>
		</div>
		<div class="rowField">
			<input type="text" name="listName" id="listName" value="<?php echo (isset($listset) ?  $listset->getListName() : ''); ?>" pattern=".{0,60}" title="List Name is RequiredList Name must be between 0 and 60 characters in length. " required="required"/>
		</div>
	</div>
	<div class="formRow">
		<div class="rowLabel">
			<label for="listType">List Type:*</label>
		</div>
		<div class="rowField">
			<?php $listType_values = array("value-value", " key-value"); ?>
			<?php if( isset( $listset) && $listset->getListType() != null ){
				 $listType_selected = $listset->getListType();
			}else{
				 $listType_selected = "";
			} ?>
			<select name="listType" required="required" >
				<?php for($v=0; $v < sizeof($listType_values); $v++){ ?>
					<option value="<?php echo $listType_values[$v]; ?>" <?php if($listType_values[$v] ==  $listType_selected ){ echo "selected"; } ?>><?php echo $listType_values[$v]; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="formRow">
		<div class="rowLabel">
			<label for="defaultValue">Default Value for List:</label>
		</div>
		<div class="rowField">
			<input type="text" name="defaultValue" id="defaultValue" value="<?php echo (isset($listset) ?  $listset->getDefaultValue() : ''); ?>"  title="" />
		</div>
	</div>
    <!--
	<div class="formRow">
		<div class="rowLabel">
			<label for="owner">Owner:*</label>
		</div>
		<div class="rowField">
			<input type="number" name="owner" id="owner" value="<?php echo (isset($listset) ?  $listset->getOwner() : ''); ?>" title="Owner is a required field. " required="required" />
		</div>
	</div>
    -->
	<div class="formRow">
		<div class="rowLabel">
			<label for="private">Is list private?:</label>
		</div>
		<div class="rowField">
			<?php $private_values = array("public", " private"); ?>
			<?php if( isset( $listset) && $listset->getPrivate() != null ){
				 $private_selected = $listset->getPrivate();
			}else{
				 $private_selected = "";
			} ?>
			<select name="private">
				<?php for($v=0; $v < sizeof($private_values); $v++){ ?>
					<option value="<?php echo $private_values[$v]; ?>" <?php if($private_values[$v] ==  $private_selected ){ echo "selected"; } ?>><?php echo $private_values[$v]; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="formRow rowCenter">
		<input class="button" type="submit" value="SUBMIT" />
	</div>
</form>

<hr />

<?php
	if( $listset->getListType() == 1){
		//1 keyval default
		echo "<h2>Key-Value List</h2>";
	}else{
		//0 - val-val
		echo "<h2>Value List</h2>";
	}
?>

<ul>
	<li></li>
</ul>

<hr />
<button class="btn">Save List</button>

<?php
	pageFooter();
?>