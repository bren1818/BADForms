<?php
	class rangeslider{
		
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
			return '$(function() {
						$( "#slider-range-max" ).slider({
						  range: "max",
						  min: 1,
						  max: 10,
						  value: 2,
						  slide: function( event, ui ) {
							$( "#rangeSlider_'. $this->formObject->getFormID().'_'.$this->formObject->getId().'" ).val( ui.value );
						  }
						});
						$( "#rangeSlider_'. $this->formObject->getFormID().'_'.$this->formObject->getId().'" ).val( $( "#slider-range-max" ).slider( "value" ) );
					  });';
		}
		
		function render(){
			?>
            	<div class="formRowLabel">
					<label for="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>"><span class="labelText"><?php echo $this->formObject->getLabel(); ?></span></label>
				</div>
                <div class="formRowInput">
                    <input 	
                    name="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" 
                    class="rangeSlider <?php echo $this->formObject->getClasses(); ?>" 
                    id="rangeSlider_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" 
                    type="text" 
                    
					<?php if( trim($this->formObject->getErrorText()) != ""){ ?>
                    title="<?php echo $this->formObject->getErrorText() ?>"
                    <?php } ?>
                    
                 
                    
                    <?php if( $this->formObject->getDefaultVal() != "" ){ ?>
                    value="<?php echo $this->formObject->getDefaultVal(); ?>"
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
                    <div id="slider-range-max"></div>
          	</div>
			<?php
		}
	}
?>