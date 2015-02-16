<?php
	class phone{
		
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
		
		function render(){
			?>
            	<div class="formRowLabel">
					<label for="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>"><span class="labelText"><?php echo $this->formObject->getLabel(); ?>
					<?php if( $this->formObject->getRegex() == "" ){ ?>(xxx-xxx-xxxx)<?php } ?>
					</span></label>
				</div>
                <div class="formRowInput">
                    <input 	
                    name="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" 
                    class="inputBox <?php echo $this->formObject->getClasses(); ?>" 
                    id="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" 
                    type="tel" 
                    
					<?php if( trim($this->formObject->getErrorText()) != ""){ ?>
                    title="<?php echo $this->formObject->getErrorText() ?>"
                    <?php } ?>
                    
                    <?php if( $this->formObject->getPlaceHolder() != "" ){ ?>
                    placeholder="<?php echo $this->formObject->getPlaceHolder(); ?>"
                    <?php } ?>
                    
                    <?php if( $this->formObject->getDefaultVal() != "" ){ ?>
                    value="<?php echo $this->formObject->getDefaultVal(); ?>"
                    <?php } ?>
                    pattern="([0-9]+[\s-])?[(]?[0-9]{3}[)]?[\s-]?[0-9]{3}[\s-][0-9]{4}"
                    data-min-length="" 
                    data-max-length="21"
                    maxlength="21"
                    <?php if( $this->formObject->getRequired() ){ echo 'required="required"'; } ?>/>
          	</div>
			<?php
		}
	}
?>