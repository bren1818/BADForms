<?php
	class email{
		
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
		
		function getJS(){
			return "";
		}
		
		function hasReturnValue(){
			return 1;
		}
	
		function render(){
			?>
            	<div class="formRowLabel">
					<label for="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>"><span class="labelText"><?php echo $this->formObject->getLabel(); ?></span></label>
				</div>
                <div class="formRowInput">
                    <input 	
                    name="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" 
                    class="inputBox <?php echo $this->formObject->getClasses(); ?>" 
                    id="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" 
                    type="email" 
                    
					<?php if( trim($this->formObject->getErrorText()) != ""){ ?>
                    title="<?php echo $this->formObject->getErrorText() ?>"
                    <?php } ?>
                    
                    <?php if( $this->formObject->getPlaceHolder() != "" ){ ?>
                    placeholder="<?php echo $this->formObject->getPlaceHolder(); ?>"
                    <?php } ?>
                    
                    <?php if( $this->formObject->getDefaultVal() != "" ){ ?>
                    value="<?php echo $this->formObject->getDefaultVal(); ?>"
                    <?php } ?>
                    
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
                    
                    <?php if( $this->formObject->getMaxLength() != "" && $this->formObject->getMaxLength() != 0){ ?>
                    maxlength="<?php echo $this->formObject->getMaxLength(); ?>"
                    <?php } ?>
                    
                    <?php if( $this->formObject->getRequired() ){ echo 'required="required"'; } ?>/>
          	</div>
			<?php
		}
	}
?>