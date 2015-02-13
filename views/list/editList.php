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
<link rel="stylesheet" href="<?php echo CSS_DIR.'/builder.css'; ?>"/>
<style type="text/css">
	ul#sortable{ margin: 20px 0px; }
	ul#sortable li{ padding: 5px; margin: 5px 0px; width: auto; }
	
	li.item{ list-style: none; }

	li.item label{ margin-right: 10px; }

	i.fa-bars{
		cursor: move;
		margin-right: 10px;
	}
	
	li.item.deleted i,
	li.item.deleted label{
		display: none;
	}
</style>

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
    	<br />
		<button class="btn" id="updateList"><i class="fa fa-floppy-o"></i> Update List Info</button> <a class="btn" href="/"><i class="fa fa-home"></i> Home</a>
        <input type="hidden" name="listID" value="<?php echo $listset->getId(); ?>"/>
	</div>
</form>

<hr />
<div id="ListItems">
<?php
	if( $listset->getListType() == 1){
		echo "<h2>Key-Value List</h2>";
	}else{
		echo "<h2>Value List</h2>";
	}
?>

<button class="btn addRow"><i class="fa fa-plus"></i> Add Row</button> <button class="btn save"><i class="fa fa-floppy-o"></i> Save</button>

<ul id="sortable">
<?php
	if( $listset->getListType() == 1){ //1 key-val list
		$query = $conn->prepare("SELECT * FROM `listitemkv` WHERE `listID` = :listID order by `rowOrder` ASC");
		$object = "listitemkv";
	}else{								//0 val list
		$query = $conn->prepare("SELECT * FROM `listitem` WHERE `listID` = :listID order by `rowOrder` ASC");
		$object = "listitem";
	}	
	
	$query->bindParam(':listID', $listID);			
	if( $query->execute() ){
		
		while( $result = $query->fetchObject($object) ){
			?>
			<li id="list-item-<?php echo $result->getId(); ?>" class="item <?php if($listset->getListType() == 1){ echo "itemKV"; }else{ echo "itemVal"; } ?>">
				<form class="listItem_row" id="listitem_<?php echo $result->getId(); ?>">
					<i class="fa fa-bars"></i>
                    <input type="hidden" name="tempID" value="<?php echo $result->getId(); ?>" />
					<input type="hidden" name="rowOrder" value="<?php echo $result->getRowOrder(); ?>" />
					<input type="hidden" name="id" value="<?php echo $result->getId(); ?>" />
					<input type="hidden" name="deleted" value="0" />
					<?php if( $listset->getListType() == 1){ ?>
					<label for="listitem_<?php echo $result->getId(); ?>_key">Key: <input id="listitem_<?php echo $result->getId(); ?>_key" type="text" name="itemkey" value="<?php echo $result->getItemKey(); ?>"></label>
					<?php } ?>
					<label for="listitem_<?php echo $result->getId(); ?>_val">Value: <input id="listitem_<?php echo $result->getId(); ?>_val" type="text" name="item" value="<?php echo $result->getItem(); ?>"></label>
					<label><button class="btn deleteItem"><i class="fa fa-trash-o"></i> Delete</button></label>
				</form>
			</li>
		<?php
		}
	}
?>
</ul>
<button class="btn addRow"><i class="fa fa-plus"></i> Add Row</button> <button class="btn save"><i class="fa fa-floppy-o"></i> Save</button>
</div>
<hr />

<h2>Preview (as Select Box)</h2>
<p>Save changes and refresh to see new preview</p>
<select>
<?php
	//NEED TO GET THE DEFAULT!
	$default = $listset->getDefaultValue();

	if( $listset->getListType() == 1){ //1 key-val list
		$query = $conn->prepare("SELECT * FROM `listitemkv` WHERE `listID` = :listID order by `rowOrder` ASC");
		$object = "listitemkv";
	}else{								//0 val list
		$query = $conn->prepare("SELECT * FROM `listitem` WHERE `listID` = :listID order by `rowOrder` ASC");
		$object = "listitem";
	}	
	$query->bindParam(':listID', $listset->getId());			
	echo '<option value=""> - </option>';
	if( $query->execute() ){
		while( $result = $query->fetchObject($object) ){
			 if( $listset->getListType() == 1){
    			//key value
				echo '<option value="'.$result->getItemKey().'" '.(trim($default) == trim($result->getItemKey()) ? ' selected' : '').'>'.$result->getItem().'</option>';
    		 }else if( $listset->getListType() == 0 ){
    			//value value
				echo '<option value="'.$result->getItem().'" '.(trim($default) == trim($result->getItemKey()) ? ' selected' : '').'>'.$result->getItem().'</option>';
    		 }
    	}
	}
	?>
</select>
<br /><br /><br />
<a class="btn" href="/"><i class="fa fa-home"></i> Home</a>

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
			//check if this item has an id
			if( $(this).parents('.listItem_row').find("input[name='id']").attr('value') == "" ){
				//no value has been assigned
				console.log("No Value");
				$(this).parents('li').remove();
			}else{
				//flag for deletion - hide other elements
				$(this).parents('.listItem_row').find("input[name='deleted']").attr('value', 1);
				$(this).parents('li').addClass('deleted');
			}
			
			
			//window.alert("delete");
		});	
	}

	$(function(){
		
		$('.btn.addRow').click(function(event){
			var tempID = new Date().getTime();
			
			var html = 	'<li id="list-item-' + tempID + '" class="item <?php if($listset->getListType() == 1){ echo "itemKV"; }else{ echo "itemVal"; } ?>">' +
						'<form class="listItem_row" id="listitem_' + tempID + '">' +
						'<i class="fa fa-bars"></i>' + 
						'<input type="hidden" name="tempID" value="' + tempID + '"/>' +
						'<input type="hidden" name="rowOrder" value="" />' + 
						'<input type="hidden" name="id" value="" />' +
						'<input type="hidden" name="deleted" value="0" />' +
						<?php if( $listset->getListType() == 1){ ?>'<label for="listitem_' + tempID + '_key">Key: <input id="listitem_' + tempID + '_key" type="text" name="itemkey" value=""></label>' +<?php }	 ?>	 
						'<label for="listitem_' + tempID + '_val">Value: <input id="listitem_' + tempID + '_val" type="text" name="item" value=""></label>' +
						'<label><button class="btn deleteItem"><i class="fa fa-trash-o"></i> Delete</button></label>' +
						'</form>' +
						'</li>';

			$('#sortable').append( html );
			bindEvents();
			orderItems();
		});
		
		$( "#sortable" ).sortable({
			placeholder: "ui-state-highlight",
			stop: function(event, ui) { 
				orderItems();
			}
		});
		
		bindEvents();
		
		$('.save.btn').click(function(event){
			orderItems(); // build into below
			var save = [];
			$('#ListItems ul li .listItem_row').each(function(index){
				var formDataObj = {};
				$(this).find(":input").not("[type='submit']").not("[type='reset']").not('button').each(function(){
					var thisInput = $(this);
					if( $(this).attr('type') == "radio" ){
						//radio - only record if it is selected
						if( $(this).is(':checked') ){
							formDataObj[thisInput.attr("name")] = thisInput.val();
						}
					}else{
						formDataObj[thisInput.attr("name")] = thisInput.val();
					}
				});
				save.push(  formDataObj );
			});
			
			
			var saveString = JSON.stringify(save);
			console.log( saveString  );
			
			
			$.post( "/views/list/saveList.php", { listID: "<?php echo $listset->getId(); ?>", listType: "<?php echo $listset->getListType(); ?>", key: "<?php echo md5( $listset->getId().BASE_ENCRYPTION_SALT.$listset->getListType() ); ?>", items: saveString })
			  .done(function( data ) {
				 //check for codes or errors 
				 console.log( data );
				 
				 window.alert("saved");
				 //Check Save Date
				 
				 /*
				var obj = jQuery.parseJSON( data );
				if( obj !== null ){
					for(var o = 0; o < obj.length; o++){
						if( obj[o].tempID != "" && obj[o].id != "" ){
							console.log( obj[o].tempID + " > " + obj[o].id );
							$('.form_row_object .row.hidden input[value="' + obj[o].tempID + '"]').parent().find('input[name="id"]').attr('value', obj[o].id);
						}
					}
				}
				alert("Saved"); //disable overlay?
				//remove deleted??
				*/
			});
			
			
		});
		
		$('#updateList').click(function(event){
			event.preventDefault();
			
			var save = [];
			$('#listset').each(function(index){
				var formDataObj = {};
				$(this).find(":input").not("[type='submit']").not("[type='reset']").not('button').each(function(){
					var thisInput = $(this);
					if( $(this).attr('type') == "radio" ){
						//radio - only record if it is selected
						if( $(this).is(':checked') ){
							formDataObj[thisInput.attr("name")] = thisInput.val();
						}
					}else{
						formDataObj[thisInput.attr("name")] = thisInput.val();
					}
				});
				save.push(  formDataObj );
			});
			
			
			var saveString = JSON.stringify(save);
			console.log( saveString  );
			window.alert(" To do - save this: " );
			
			/*
			$.post( "/views/list/saveList.php", { listID: "<?php echo $listset->getId(); ?>", listType: "<?php echo $listset->getListType(); ?>", key: "<?php echo md5( $listset->getId().BASE_ENCRYPTION_SALT.$listset->getListType() ); ?>", formData: saveString })
			  .done(function( data ) {
				 //check for codes or errors 
				 console.log( data );
				 
				 window.alert("saved");
				
			});
			*/
			
		});
		
	});
</script>
<?php
	pageFooter();
?>