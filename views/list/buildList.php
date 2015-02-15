<?php
	include "../../includes/include.php";
	$conn = getConnection();
	pageHeader();
	
	$listset = new Listset( $conn ); //$conn 
	if(strtoupper($_SERVER["REQUEST_METHOD"]) === "POST") {
		$listset->setOwner( 1 ); // update
		$listset->getFromPost();
		if( $listset->save() >= 1){
			$listID = $listset->getId();
			header("Location: /views/list/editList.php?listID=".$listID);
		}else{
			pa($listset);
			//echo $listset->getErrors();
		}
	}
	
?>
<link rel="stylesheet" href="<?php echo CSS_DIR.'/formBuilder.css'; ?>"/>

<form name="listset" id="listset" method="POST" action="" enctype="multipart/form-data">
	<div class="formRow">
    	<h1>Build List</h1>
    </div>
	<div class="formRow">
		<div class="rowLabel">
			<label for="listName">List Name:*</label>
		</div>
		<div class="rowField">
			<input type="text" name="listName" id="listName" value="<?php echo (isset($listset) ?  $listset->getListName() : ''); ?>" pattern=".{1,60}" title="List Name is RequiredList Name must be between 0 and 60 characters in length. " required="required"/>
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
					<option value="<?php echo $v; ?>" <?php if($v ==  $listType_selected ){ echo "selected"; } ?>><?php echo $listType_values[$v]; ?></option>
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
					<option value="<?php echo $private_values[$v]; ?>" <?php if($v ==  $private_selected ){ echo "selected"; } ?>><?php echo $private_values[$v]; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="formRow rowCenter">
		<input class="button" type="submit" value="SUBMIT" />
	</div>
</form>



<?php pageFooter(); ?>