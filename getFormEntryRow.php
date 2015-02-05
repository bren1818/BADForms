<?php
require_once( "includes/include.php" );

function generateHtml($formObject){
	$db = getConnection();
	
	if( ! isset($formObject) || $formObject == "" || ! is_object($formObject) ){
		$formObject = new formobject();
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
<form>
<div class="form_row_object">
	<div class="row type">
		<label for="type">
			Choose input type:
		</label>
		<select class="select type" name="type">
			<?php
				$query = $db->prepare("SELECT * FROM `objecttype` order by `ordered` ASC");		
				if( $query->execute() ){
					while( $result = $query->fetchObject("objecttype") ){
						echo '<option data-type="'.$result->getName().'" value="'.$result->getId().'" '.($result->getId() == $formObject->getType() ? "selected" : "").'>'.$result->getDescription().'</option>';
					}
				}
			?>
		</select>
	</div>

	<div class="row">
		<label for="label">
			The label text for form field
		</label>
		<input type="text" name="label" value="<?php echo $formObject->getLabel(); ?>" />
	</div>
	
	<div class="row">
		<label for="name">
			The name of the field (system)
		</label>
		<input type="text" name="name" value="<?php echo $formObject->getName(); ?>" />
	</div>

	<div class="row defaultVal">
		<label for="defaultVal">
			The default value for form field
		</label>
		<input type="text" name="defaultVal" value="<?php echo $formObject->getDefaultVal(); ?>" />
	</div>

	<div class="row errorText">
		<label for="errorText">
			The error text if entered incorrectly
		</label>
		<input type="text" name="errorText" value="<?php echo $formObject->getErrorText(); ?>" />
	</div>

	<div class="row placeholder">
		<label for="placeholder">
			The placeholder text 
		</label>
		<input type="text" name="placeholder" value="<?php echo $formObject->getPlaceholder(); ?>" />
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
		<textarea name="csList"><?php echo $formObject->getCsList(); ?></textarea>
	</div>
	
	<div class="row listID">
		<label for="listID">
			Choose a list.
			<a href="#">Pick List</a>
		</label>
		<input type="hidden" name="listID" value="" />
	</div>
	
	<div class="advancedSettings row">
    	<div class="row showSettings">
        	Show Advanced
        </div>
		
        <div class="row regex">
			<label for="regex">
				Regular Expression for validation  
			</label>
			<input type="text" name="regex" value="<?php echo $formObject->getRegex(); ?>" />
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
			<input type="text" name="classes" value="<?php echo $formObject->getClasses(); ?>" />
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
		<input type="hidden" name="tempID" value="<?php md5($formObject->getId()) ?>" />
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