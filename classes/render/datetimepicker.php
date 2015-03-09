<?php
	class datetimepicker{
		
		private $formObject;
		private	$js;
		
		
		/*Constructor*/
		function __construct($formObject=null){
			$this->formObject = $formObject;
		}
		
		function getJS(){
			return "$('#datetimePicker_". $this->formObject->getFormID().'_'.$this->formObject->getId()."').datetimepicker({\"dateFormat\" : \"mm/dd/yy\", \"timeFormat\": \"hh:mm tt\"});";
		}
				
		function hasReturnValue(){
			return 1;
		}

		function render(){
			?>
				<div class="formRowLabel">
				<label for="datetimePicker_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>">
					<span class="labelText"><?php echo $this->formObject->getLabel(); ?></span>
                </label>
                </div>
                <div class="formRowInput">
					<input 
                    	name="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" 
						class="datetimepicker <?php echo $this->formObject->getClasses(); ?>" 
						id="datetimePicker_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" 
						type="text" placeholder="<?php echo $this->formObject->getPlaceHolder(); ?>"
						<?php if( $this->formObject->getDefaultVal() != "" ){ echo ' value="'.$this->formObject->getDefaultVal().'" '; } ?>
						<?php if( $this->formObject->getRequired() ){ echo 'required="required"'; } ?>/>
				</div>
			<?php
			//value=" echo ; "
		}
		
		
		
		
	}

?>