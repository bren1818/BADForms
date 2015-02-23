<?php
require_once( "includes/include.php" );

function generateHtml($formObject){
	$db = getConnection();
	$tempID = filter_var(microtime(true), FILTER_SANITIZE_NUMBER_INT);
	
	$isGroupType = 0;
	if( ! isset($formObject) || $formObject == "" || ! is_object($formObject) ){
		$formObject = new formobject();
	}else{
		if( $formObject->getFormId() != "" ){
			$form = new Theform($db);
			$formID = $formObject->getFormId();
			$form = $form->load( $formID );
			if( $form->getId() > 0 ){
				if( $form->getIsGroup() > 0){
					$isGroupType = 1;
				}
			}
		}
	}
	
	//optimize
	$RowTypes = array();
	$query = $db->prepare("SELECT * FROM `objecttype` order by `ordered` ASC");		
	if( $query->execute() ){
		while( $result = $query->fetchObject("objecttype") ){
			$RowTypes[$result->getId()] = $result->getName();	
		}
	}
	
	ob_start();
?>
<li class="<?php echo " list-type-".$formObject->getListType(); echo " ".(isset($RowTypes[$formObject->getType()]) ? $RowTypes[$formObject->getType()] : "no-type-select"); ?>">
<form id="<?php if( isset($formObject) && $formObject->getId() != ""){ echo $formObject->getId(); $tempID = $formObject->getId(); }else{ echo $tempID;  } ?>">
<div class="form_row_object">
	<div class="row type">
		<label for="type">
			Choose input type:
		</label>
		
		<select class="select type" name="type" title="Select the type of entry object you wish to add to the form">
			<?php
				//could use $RowTypes
			
				if( $isGroupType == 0 ){
					$query = $db->prepare("SELECT * FROM `objecttype` order by `ordered` ASC");
				}else{
					$query = $db->prepare("SELECT * FROM `objecttype` WHERE `name` != 'group' order by `ordered` ASC");
				}
				if( $query->execute() ){
					while( $result = $query->fetchObject("objecttype") ){
						echo '<option data-type="'.$result->getName().'" value="'.$result->getId().'" '.($result->getId() == $formObject->getType() ? "selected" : "").'>'.$result->getDescription().'</option>';
					}
				}
			?>
		</select>
	</div>

	<div class="row rowLabel">
		<label for="label">
			The label text for form field
		</label>
		<input type="text" name="label" value="<?php echo $formObject->getLabel(); ?>" required="required" title="This is what will be shown beside the entry field to the form user"/>
	</div>
	
	<div class="row rowName">
		<label for="name">
			The name of the field (system)
		</label>
		<input type="text" name="name" value="<?php echo $formObject->getName(); ?>" required="required" title="This is for the admin/data collectors convenience - should be unique name for what this field is"/>
	</div>

	<div class="row defaultVal">
		<label for="defaultVal">
			The default value for form field
		</label>
		<input type="text" name="defaultVal" value="<?php echo $formObject->getDefaultVal(); ?>" title="This is the default value which pre-populates the form"/>
	</div>

	<div class="row errorText">
		<label for="errorText">
			The error/title text if entered incorrectly/to give hints
		</label>
		<input type="text" name="errorText" value="<?php echo $formObject->getErrorText(); ?>" title="See this popup? This is what it is, this text will also be shown as an error message back to the user on invalid submission"/>
	</div>

	<div class="row placeholder">
		<label for="placeholder">
			The placeholder text 
		</label>
		<input type="text" name="placeholder" value="<?php echo $formObject->getPlaceholder(); ?>" title="This is the hint text shown to user - similar to default but when submitted the placeholder has no value"/>
	</div>
	
	<div class="row listType">
		<label for="listType">
			List Type:
		</label>
		<br />
		Comma Separated <input type="radio" name="listType" value="1" <?php if( $formObject->getListType() == 1){ echo " checked"; } ?>/><br />
		Pre-Existing <input type="radio" name="listType" value="2" <?php if( $formObject->getListType() == 2){ echo " checked"; } ?>/>
	</div>	
	
	<div class="row csList">
		<label for="csList">
			Comma Separated list of values
		</label>
		<textarea name="csList" title="This is a comma separated list of values which is turned into something the form user can choose from."><?php echo $formObject->getCsList(); ?></textarea>
	</div>
	
	<div class="row listID">
		<label for="listID">
			Choose a list.
			<a class="btn" onClick="pickList(this)" title="clicking this will allow you to choose from your pre-created lists"><i class="fa fa-list-alt"></i> Pick List</a>
		</label>
		<input type="hidden" name="listID" value="<?php if( $formObject->getListType() == 2){ if(  $formObject->getListID() != "" ){ echo $formObject->getListID(); } } ?>" />
        <label class="listName" for="listName">
        	<?php 
				if( $formObject->getListType() == 2 &&  $formObject->getListID() != "" ){	
					$Listset = new Listset( $db);
					$Listset = $Listset->load( $formObject->getListID() );
					echo '<b>Chosen List</b>: &ldquo;' . $Listset->getListName() . '&rdquo;  <a class="clearPick" onClick="clearPick(this);"><i class="fa fa-times"></i></a>'; 
				}
			?>
        </label>
	</div>
	
	<div class="row reUseableItem">
		
		<input type="hidden" name="reuseableType" value="" />
		<input type="hidden" name="reuseableID" value="" />
		
		<div class="row reUseableGroup">
			<label for="reUseableGroup">
				Choose a Re-useable Group
				<a class="btn" onClick="pickGroup(this , 1)" title="clicking this will allow you to choose from your pre-created group"><i class="fa fa-indent"></i> Pick Group</a>
			</label>
			
			
			
			
		</div>
		<div class="row reUseableFormItem">
			<label for="reUseableGroup">
				Choose a Re-useable Item
				<a class="btn" onClick="pickGroup(this , 2)" title="clicking this will allow you to choose from your pre-created Iten"><i class="fa fa-sliders"></i> Pick Item</a>
			</label>
			
		</div>
	</div>
	
	<div class="advancedSettings row">
    	<div class="showSettings btn">
        	<i class="fa fa-cogs"></i> Show Advanced
        </div>
		
        <div class="row regex">
			<label for="regex">
				Regular Expression for validation  
			</label>
			<input type="text" name="regex" title="For power users only - this allows you to write a custom Regular expression to validate input" value="<?php echo $formObject->getRegex(); ?>" />
		</div>
			
		<div class="row minLength">
			<label for="minLength">
				minimum length of input 
			</label>
			<input type="number" name="minLength" value="<?php echo $formObject->getMinLength(); ?>" />
		</div>
		
		<div class="row maxLength">
			<label for="maxLength">
				maximum length of input 
			</label>
			<input type="number" name="maxLength" value="<?php echo $formObject->getMaxLength(); ?>" />
		</div>
		
		<div class="row minVal">
			<label for="minVal">
				min value of input 
			</label>
			<input type="number" name="minVal" value="<?php echo $formObject->getMinVal(); ?>" />
		</div>
		
		<div class="row maxVal">
			<label for="maxVal">
				maximum value of input 
			</label>
			<input type="number" name="maxVal" value="<?php echo $formObject->getMaxVal(); ?>" />
		</div>

		<div class="row classes">
			<label for="classes">
				CSS Class(es) space separated for styling
			</label>
			<input type="text" name="classes" value="<?php echo $formObject->getClasses(); ?>" title="Used in conjunction with CSS to help style the form elements if required."/>
		</div>
		
		
		<div class="row encrypted">
			<label for="encrypted">
				Does this data need to be encrypted?
			</label>
			<?php
				//check parent to see if disabled or nt
			?>
			<input type="radio" name="encrypted" value="1" <?php if( $formObject->getEncrypted() == "1" ){ echo "checked"; } ?>/> Yes 
			<input type="radio" name="encrypted" value="0" <?php if( $formObject->getEncrypted() == "0" ){ echo "checked"; } ?>/> No
			<?php
			
			?>
		</div>
		
		<div class="row required">
			<label for="required">
				Is this field required?
			</label>
			<input type="radio" name="required" value="1" <?php if( $formObject->getRequired() == "1" ){ echo 'checked="checked"'; } ?>/> Yes
			<input type="radio" name="required" value="0" <?php if( $formObject->getRequired() == "0" ){ echo 'checked="checked"'; } ?>/> No
		</div>	
	</div>
	
	<div class="row hidden">
		<input type="hidden" name="formID" value="<?php echo $formObject->getFormID(); ?>" />
		<input type="hidden" name="id" value="<?php echo $formObject->getId(); ?>" />
		<input type="hidden" name="rowOrder" value="<?php echo $formObject->getRowOrder(); ?>" />
		<input type="hidden" name="isDeleted" value="<?php echo "0"; ?>" />
		<input type="hidden" name="tempID" value="<?php echo $tempID; ?>" />
	</div>
</div>
</form>
</li>
<?php
	$component = ob_get_contents();
	ob_end_clean();
	return $component;
}



if( isset($_REQUEST) && isset($_REQUEST['form']) && $_REQUEST['form']  != "" ){
	$form = $_REQUEST['form'];
	$formObject = new formobject();
	$formObject->setFormID( $form );
	
	echo generateHtml( $formObject );
}

?>