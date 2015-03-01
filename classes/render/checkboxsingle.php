<?php
	class checkboxsingle {
		
		private $formObject;
		
		/*Constructor*/
		function __construct($formObject=null){
			$this->formObject = $formObject;
		}
		
		function getJS(){
			return "";
		}
				
		function hasReturnValue(){
			return 1;
		}

		function render(){
			?>
            	<div class="formRowLabel">
				<label for="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>">
					<span class="labelText"><?php echo $this->formObject->getLabel(); ?></span>
                </label>
                </div>
                <div class="formRowInput">    
					<input type="checkbox"
                    	name="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" 
						class="checkBoxItem <?php echo $this->formObject->getClasses(); ?>" 
						id="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" 
						<?php if( $this->formObject->getRequired() ){ echo ' required="required"'; } ?> 
						<?php if( strtolower($this->formObject->getDefaultVal()) == "checked" ){ echo " checked"; }?>/>
				</div>	
			<?php
		}
		
		
	}
?>