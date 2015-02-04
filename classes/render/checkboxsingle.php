<?php
	class checkboxsingle {
		
		private $formObject;
		
		/*Constructor*/
		function __construct($formObject=null){
			$this->formObject = $formObject;
		}
		
		function render(){
			?>
				<label for="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>">
					<?php echo $this->formObject->getLabel(); ?>
					<input type="checkbox"
                    	name="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" 
						class="<?php echo $this->formObject->getClasses(); ?>" 
						id="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" 
						<?php if( $this->formObject->getRequired() ){ echo ' required="required"'; } ?> 
						<?php if( strtolower($this->formObject->getDefaultVal()) == "checked" ){ echo " checked"; }?>/>
				</label>
			<?php
		}
		
		
	}

?>