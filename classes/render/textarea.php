<?php
	class textarea{
		
		private $formObject;
		
		/*Constructor*/
		function __construct($formObject=null){
			$this->formObject = $formObject;
		}		
		
		function getPattern($pattern, $minLength, $maxLength){
			
			if( $minLength == 0 ){ $minLength = ""; }
			if( $maxLength == 0 ){ $maxLength = ""; }
			
			if( trim($pattern) != "" ){
				return $pattern;
			}else{
				if( trim($minLength) != "" && trim($maxLength) != ""){
					return ".{".$minLength.",".$maxLength."}";
				}else if( trim($minLength) != ""){
					return ".{".$minLength.",}";
				}else if( trim($maxLength) != ""){
					return ".{0,".$maxLength."}";
				}else{
					return ""; //nothing
				}
			}
		}
		
		function render(){
			?>
				<label for="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>">
					<span class="labelText"><?php echo $this->formObject->getLabel(); ?></span>
					<textarea
                    
                    	name="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>"
                          
						class="textarea <?php echo $this->formObject->getClasses(); ?>" 
                        
						id="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" 
						
						<?php $pattern = $this->getPattern($this->formObject->getRegex(),$this->formObject->getMinLength(),$this->formObject->getMaxLength());
						if($pattern != "" ){ ?>
						pattern="<?php echo $pattern; ?>"
						<?php } ?>             
                        
						<?php if( $this->formObject->getMinLength() != ""){ ?>
						data-min-length="<?php echo $this->formObject->getMinLength(); ?>" 
                        <?php } ?>
                        
                        <?php if( $this->formObject->getMaxLength() != ""){ ?>
						data-max-length="<?php echo $this->formObject->getMaxLength(); ?>"
                        <?php } ?>
                        
                        <?php if( $this->formObject->getMaxLength() != "" && $this->formObject->getMaxLength() != 0 ){ ?>
						maxlength="<?php echo $this->formObject->getMaxLength(); ?>"
                        <?php } ?>
                        
						<?php if( $this->formObject->getRequired() ){ echo 'required="required"'; } ?>><?php echo $this->formObject->getDefaultVal(); ?></textarea>
				</label>
			<?php
		}
		
		
	}

?>