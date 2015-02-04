<?php
	class input{
		
		private $formObject;
		
		/*Constructor*/
		function __construct($formObject=null){
			$this->formObject = $formObject;
		}
		
		function render(){
			?>
				<label for="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>">
					<?php echo $this->formObject->getLabel(); ?>
					<input 
                    	name="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" 
						class="<?php echo $this->formObject->getClasses(); ?>" 
						id="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" 
						type="text" placeholder="<?php echo $this->formObject->getPlaceHolder(); ?>" 
						value="<?php echo $this->formObject->getDefaultVal(); ?>"
						<?php if($this->formObject->getRegex() != "" ){ ?>
						pattern="<?php echo $this->formObject->getRegex(); ?>"
						<?php } ?>
						data-min-length="<?php echo $this->formObject->getMinLength(); ?>" 
						data-max-length="<?php echo $this->formObject->getMaxLength(); ?>"
						maxlength="<?php echo $this->formObject->getMaxLength(); ?>"
						<?php if( $this->formObject->getRequired() ){ echo 'required="required"'; } ?>/>
				</label>
			<?php
		}
		
		
	}

?>