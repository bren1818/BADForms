<?php
	class textarea{
		
		private $formObject;
		
		/*Constructor*/
		function __construct($formObject=null){
			$this->formObject = $formObject;
		}		
		
		function render(){
			?>
				<label for="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>">
					<span class="labelText"><?php echo $this->formObject->getLabel(); ?></span>
					<textarea
                    
                    	name="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>"
                          
						class="textarea <?php echo $this->formObject->getClasses(); ?>" 
                        
						id="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" 
                        
						
						<?php if($this->formObject->getRegex() != "" ){ ?>
						pattern="<?php echo $this->formObject->getRegex(); ?>"
						<?php } ?>
                        
						<?php if( $this->formObject->getMinLength() != ""){ ?>
						data-min-length="<?php echo $this->formObject->getMinLength(); ?>" 
                        <?php } ?>
                        
                        <?php if( $this->formObject->getMaxLength() != ""){ ?>
						data-max-length="<?php echo $this->formObject->getMaxLength(); ?>"
                        <?php } ?>
                        
                        <?php if( $this->formObject->getMaxLength() != ""){ ?>
						maxlength="<?php echo $this->formObject->getMaxLength(); ?>"
                        <?php } ?>
                        
						<?php if( $this->formObject->getRequired() ){ echo 'required="required"'; } ?>><?php echo $this->formObject->getDefaultVal(); ?></textarea>
				</label>
			<?php
		}
		
		
	}

?>