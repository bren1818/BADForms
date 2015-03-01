<?php
	class datetimepicker{
		
		private $formObject;
		private	$js;
		
		
		/*Constructor*/
		function __construct($formObject=null){
			$this->formObject = $formObject;
		}
		
		function getJS(){
			return "$('#input_". $this->formObject->getFormID().'_'.$this->formObject->getId()."').datepicker();";
		}
				
		function hasReturnValue(){
			return 1;
		}
		
		function render(){
			?>
				<label for="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>">
					<?php echo $this->formObject->getLabel(); ?>
					<input 
                    	name="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" 
						class=" datepicker<?php echo $this->formObject->getClasses(); ?>" 
						id="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" 
						type="text" placeholder="<?php echo $this->formObject->getPlaceHolder(); ?>" 
						<?php if( $this->formObject->getRequired() ){ echo 'required="required"'; } ?>/>
				</label>
			<?php
			//value=" echo $this->formObject->getDefaultVal(); "
		}
		
		
	}

?>