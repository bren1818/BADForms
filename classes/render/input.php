<?php
	class input{
		
		private $formObject;
		public $errors;
		public $errorCount;
		
		/*Constructor*/
		function __construct($formObject=null){
			$this->formObject = $formObject;
			$this->errors = array();
			$this->errorCount = 0;
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
		
		function startsWith($haystack, $needle) {
			// search backwards starting from haystack length characters from the end
			return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
		}
		function endsWith($haystack, $needle) {
			// search forward starting from end minus needle length characters
			return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
		}
		
		function getJS(){
			return "";
		}
						
		function hasReturnValue(){
			return 1;
		}
		
		function validate($value){
			$valid = 1;
			
			$required = $this->formObject->getRequired();
			$minLength = $this->formObject->getMinLength();
			$maxLength = $this->formObject->getMaxLength();
			$regex = $this->formObject->getRegex();
			
			if( $required == 1 ){
				if( trim($value) == "" ){
					$this->errorCount++;
					$this->errors[] = "Field is required.";
					$valid = 0;
				}
			}
			
			if( $minLength != ""  ){
				if( strlen( $value) < $minLength  && $required){
					$this->errorCount++;
					$this->errors[] = "Field does not meet minimum length required.";
					$valid = 0;
				}				
			}
			
			if( $maxLength != ""  ){
				if( strlen( $value) > $maxLength ){
					$this->errorCount++;
					$this->errors[] = "Field is longer than maximum allowable length.";
					$valid = 0;
				}				
			}
			
			if( trim($regex) != ""  ){
				
				if( !startsWith($regex,"/") ){ // /^
					$regex = "/".$regex;
				}
				
				if( !endsWith($regex, "/") ){ // $/
					$regex = $regex."/";
				}
				
				
				if( preg_match($regex,$value) != 1 ){
					$this->errorCount++;
					$this->errors[] = "Field does not match required input pattern (".$regex.").";
					$valid = 0;
				}
				
			}
			
			
			return $valid;
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
                    type="text" 
                    
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