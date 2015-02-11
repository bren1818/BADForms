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
		exit;
	}
	
?>
<form name="listset" id="listset" method="POST" action="" enctype="multipart/form-data">

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
			<?php $listType_values = array("value-value", "key-value"); ?>
			<?php 
			if( isset( $listset) && $listset->getListType() != "" ){
				 $listType_selected = $listset->getListType();
			}else{
				 $listType_selected = "";
			} 
			?>
			<select name="listType" disabled="disabled" >
				<?php for($v=0; $v < sizeof($listType_values); $v++){ ?>
					<option value="<?php echo trim($listType_values[$v]); ?>" <?php if( $v == $listType_selected ){ echo "selected"; } ?>><?php echo trim($listType_values[$v]); ?></option>
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
					<option value="<?php echo $private_values[$v]; ?>" <?php if($private_values[$v] ==  $private_selected ){ echo "selected"; } ?>><?php echo $private_values[$v]; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="formRow rowCenter">
		<button id="updateList"><i class="fa fa-floppy-o"></i> Update List Info</button>
        <input type="hidden" name="listID" value="<?php echo $listset->getId(); ?>"/>
	</div>
</form>

<hr />
<div id="ListItems">
<?php
	if( $listset->getListType() == 1){
			//1 keyval default
		echo "<h2>Key-Value List</h2>";
	}else{
		echo "<h2>Value List</h2>";
	}
?>

<button class="btn addRow"><i class="fa fa-plus"></i> Add Row</button> <button class="btn save"><i class="fa fa-floppy-o"></i> Save</button>

<ul id="sortable">
<?php
	if( $listset->getListType() == 1){
		//1 keyval default
	
			$query = $conn->prepare("SELECT * FROM `listitemkv`  WHERE `listID` = :listID order by `rowOrder` ASC");
			$query->bindParam(':listID', $listID);			
			if( $query->execute() ){
				while( $result = $query->fetchObject("listitemkv") ){
					?>
                	<li class="item itemKV">
                    	<form class="listItem_row" id="listitem_<?php echo $result->getId(); ?>">
                        	<i class="fa fa-bars"></i>
                            <input type="hidden" name="rowOrder" value="<?php echo $result->getRowOrder(); ?>" />
                            <input type="hidden" name="id" value="<?php echo $result->getId(); ?>" />
                            <input type="hidden" name="deleted" value="0" />
                            
                            <label for="listitem_<?php echo $result->getId(); ?>_key">Key: <input id="listitem_<?php echo $result->getId(); ?>_key" type="text" name="itemKey" value="<?php echo $result->getItemKey(); ?>"></label>
                            
                             <label for="listitem_<?php echo $result->getId(); ?>_val">Value: <input id="listitem_<?php echo $result->getId(); ?>_val" type="text" name="itemVal" value="<?php echo $result->getItem(); ?>"></label>
                            <label><button class="deleteItem"><i class="fa fa-trash-o"></i> Delete</button></label>
                        </form>
                    </li>
                <?php
				}
			}
		
		
	}else{
		//0 - val-val
		
		$query = $conn->prepare("SELECT * FROM `listitem` WHERE `listID` = :listID order by `rowOrder` ASC");
		$query->bindParam(':listID', $listID);		
		if( $query->execute() ){
			while( $result = $query->fetchObject("listitem") ){
				?>
                	<li class="item itemVal">
                    	<form class="listItem_row" id="listitem_<?php echo $result->getId(); ?>">
                        	<i class="fa fa-bars"></i>
                            <input type="hidden" name="rowOrder" value="<?php echo $result->getRowOrder(); ?>" />
                            <input type="hidden" name="id" value="<?php echo $result->getId(); ?>" />
                            <input type="hidden" name="deleted" value="0" />
                           
                            
                             <label for="listitem_<?php echo $result->getId(); ?>_value">Value: <input id="listitem_<?php echo $result->getId(); ?>_value" type="text" name="itemVal" value="<?php echo $result->getItem(); ?>"></label>
                             <label><button class="deleteItem"><i class="fa fa-trash-o"></i> Delete</button></label>
                        </form>
                    </li>
                <?php
			}
		}

		
	}
?>
</ul>
<button class="btn addRow"><i class="fa fa-plus"></i> Add Row</button> <button class="btn save"><i class="fa fa-floppy-o"></i> Save</button>
</div>
<hr />
<style>
	li.item{ list-style: none; }

	li.item label{ margin-right: 10px; }

	i.fa-bars{
		cursor: move;
		margin-right: 10px;
	}
</style>
<script type="text/javascript">
	function orderItems(){
		$('#ListItems ul li .listItem_row').not('li.deleted').each(function(index){
			$(this).find(":input[name='rowOrder']").attr('value',index);
		});
	}
	
	function bindEvents(){
		$('.deleteItem').unbind();
		
		$('.deleteItem').click(function(event){
			event.preventDefault();
			
			window.alert("delete");
		});	
	}

	$(function(){
		$('#updateList').click(function(event){
			window.alert("update");
		});
		
		$('.btn.addRow').click(function(event){
			var tempID = new Date().getTime();
			<?php if( $listset->getListType() == 1){ ?>
				//Key-Value List
				var html = 	'<li class="item itemKV">' +
                    		'<form class="listItem_row" id="listitem_' + tempID + '">' +
                        	'<i class="fa fa-bars"></i>' + 
                            '<input type="hidden" name="rowOrder" value="" />' + 
                            '<input type="hidden" name="id" value="" />' +
                            '<input type="hidden" name="deleted" value="0" />' +
                            '<label for="listitem_' + tempID + '_key">Key: <input id="listitem_' + tempID + '_key" type="text" name="itemKey" value=""></label>' + 
                            '<label for="listitem_' + tempID + '_val">Value: <input id="listitem_' + tempID + '_val" type="text" name="itemVal" value=""></label>' +
							'<label><button class="deleteItem"><i class="fa fa-trash-o"></i> Delete</button></label>' +
                        	'</form>' +
                    		'</li>';
			<?php }else{ ?>
				//Value Value List
				var html = 	'<li class="item itemKV">' +
                    		'<form class="listItem_row" id="listitem_' + tempID + '">' +
                        	'<i class="fa fa-bars"></i>' + 
                            '<input type="hidden" name="rowOrder" value="" />' + 
                            '<input type="hidden" name="id" value="" />' +
                            '<input type="hidden" name="deleted" value="0" />' +
                           // '<label for="listitem_' + tempID + '_key">Key: <input id="listitem_' + tempID + '_key" type="text" name="itemKey" value=""></label>' + 
                            '<label for="listitem_' + tempID + '_val">Value: <input id="listitem_' + tempID + '_val" type="text" name="itemVal" value=""></label>' +
							'<label><button class="deleteItem"><i class="fa fa-trash-o"></i> Delete</button></label>' +
                        	'</form>' +
                    		'</li>';
			<?php }	 ?>	
			
			$('#sortable').append( html );
			bindEvents();
			orderItems();
		});
		
		$('.btn.save').click(function(event){
			orderItems();
			window.alert("save");
		});
		
		
		
		$( "#sortable" ).sortable({
			placeholder: "ui-state-highlight",
			stop: function(event, ui) { 
				//window.alert("dropped");
				orderItems();
			}
		});
		
		bindEvents();
		
	});
</script>
<?php
	pageFooter();
?>