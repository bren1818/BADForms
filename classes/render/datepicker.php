<?php
	class datepicker{
		
		private $formObject;
		private	$js;
		
		
		/*Constructor*/
		function __construct($formObject=null){
			$this->formObject = $formObject;
		}
		
		function getJS(){
			return "$('#datePicker_". $this->formObject->getFormID().'_'.$this->formObject->getId()."').datepicker();";
		}
				
		function hasReturnValue(){
			return 1;
		}

		function render(){
			?>
				<div class="formRowLabel">
				<label for="datePicker_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>">
					<span class="labelText"><?php echo $this->formObject->getLabel(); ?></span>
                </label>
                </div>
                <div class="formRowInput">
					<input 
                    	name="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" 
						class="datepicker <?php echo $this->formObject->getClasses(); ?>" 
						id="datePicker_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" 
						type="text" placeholder="<?php echo $this->formObject->getPlaceHolder(); ?>"
						<?php if( $this->formObject->getDefaultVal() != "" ){ echo ' value="'.$this->formObject->getDefaultVal().'" '; } ?>
						<?php if( $this->formObject->getRequired() ){ echo 'required="required"'; } ?>/>
				</div>
			<?php
			//value=" echo ; "
		}
		
		
	}

?>