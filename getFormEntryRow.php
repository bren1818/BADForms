<?php
require_once( "includes/include.php" );

function generateHtml($formID){
	$db = getConnection();
	ob_start();
?>
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
						echo '<option data-type="'.$result->getName().'" value="'.$result->getId().'">'.$result->getDescription().'</option>';
					}
				}
			?>
		</select>
	</div>

	<div class="row">
		<label for="label">
			The label text for form field
		</label>
		<input type="text" name="label" value="" />
	</div>
	
	<div class="row">
		<label for="name">
			The name of the field (system)
		</label>
		<input type="text" name="name" value="" />
	</div>

	<div class="row defaultVal">
		<label for="defaultVal">
			The default value for form field
		</label>
		<input type="text" name="defaultVal" value="" />
	</div>

	<div class="row errorText">
		<label for="errorText">
			The error text if entered incorrectly
		</label>
		<input type="text" name="errorText" value="" />
	</div>

	<div class="row tooltip">
		<label for="tooltip">
			The text displayed as a tool tip
		</label>
		<input type="text" name="tooltip" value="" />
	</div>

	<div class="row placeholder">
		<label for="placeholder">
			The placeholder text 
		</label>
		<input type="text" name="placeholder" value="" />
	</div>
	
	<div class="row listType">
		<label for="listType">
			List Type
		</label>
		Comma Separated <input type="radio" name="listType" value="1" />, Pre-Existing <input type="radio" name="listType" value="2" />
	</div>	
	
	<div class="row csList">
		<label for="csList">
			Comma Separated list of values
		</label>
		<textarea name="csList"></textarea>
	</div>
	
	<div class="row listID">
		<label for="listID">
			Choose a list.
			<a href="#">Pick List</a>
		</label>
		<input type="hidden" name="listID" value="" />
	</div>
	
	<div class="advancedSettings row">
	
		<div class="row regex">
			<label for="regex">
				Regular Expression for validation  
			</label>
			<input type="text" name="regex" value="" />
		</div>
			
		<div class="row minLength">
			<label for="minLength">
				minimum length of input 
			</label>
			<input type="number" name="minLength" value="" />
		</div>
		
		<div class="row maxLength">
			<label for="maxLength">
				maximum length of input 
			</label>
			<input type="number" name="maxLength" value="" />
		</div>
		
		<div class="row minVal">
			<label for="minVal">
				min value of input 
			</label>
			<input type="number" name="minVal" value="" />
		</div>
		
		<div class="row maxVal">
			<label for="maxVal">
				maximum value of input 
			</label>
			<input type="number" name="maxVal" value="" />
		</div>

		<div class="row classes">
			<label for="classes">
				CSS Class(es) space separated for styling
			</label>
			<input type="text" name="classes" value="" />
		</div>
		
		
		<div class="row encrypted">
			<label for="encrypted">
				Does this data need to be encrypted?
			</label>
			<?php
				//check parent to see if disabled or nt
			?>
			<input type="radio" name="encrypted" value="1" /> Yes 
			<input type="radio" name="encrypted" value="0" checked="checked"/> No
			<?php
			
			?>
		</div>
		
		<div class="row required">
			<label for="required">
				Is this field required?
			</label>
			<input type="radio" name="required" value="1" /> Yes <input type="radio" name="required" value="0" checked="checked"/> No
		</div>	
	</div>
	
	<div class="row hidden">
		<input type="hidden" name="formID" value="<?php ?>" />
		<input type="hidden" name="formObjectID" value="<?php ?>" />
		<input type="hidden" name="rowOrder" value="<?php ?>" />
		<input type="hidden" name="isDeleted" value="<?php ?>" />
		<input type="hidden" name="tempID" value="<?php echo time(); ?>" />
	</div>
</div>
<?php
	$component = ob_get_contents();
	ob_end_clean();
	return $component;
}



if( isset($_REQUEST) && isset($_REQUEST['form']) && $_REQUEST['form']  != "" ){
	$form = $_REQUEST['form'];
	echo generateHtml( $form );
}

?>