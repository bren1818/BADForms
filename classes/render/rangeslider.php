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
		
		function getDefault(){
			$val = (int)$this->formObject->getDefaultVal();
			if( $val == ""){ $val = 0; }
			if( !is_int($val) ){ $val = 0; }
			return $val;
			
		}
		
		function getMax(){
			$val = (int)$this->formObject->getMaxVal();
			if( $val == ""){ $val = $this->getMin(); }
			if( !is_int($val) ){ $val = $this->getMin(); }
			return $val;
		}
		
		function getMin(){
			$val = (int)$this->formObject->getMinVal();
			if( $val == ""){ $val = 0; }
			if( !is_int($val) ){ $val = 0; }
			return $val;
		}
		
		
		function getJS(){
			return '$( "#slider-range-'.$this->formObject->getFormID().'_'.$this->formObject->getId().'" ).slider({
					  range: "max",
					  min: '.$this->getMin().',
					  max: '.$this->getMax().',
					  value: '.$this->getDefault().',
					  slide: function( event, ui ) {
						$( "#rangeSlider_'. $this->formObject->getFormID().'_'.$this->formObject->getId().'" ).val( ui.value );
					  }
					});
					$( "#rangeSlider_'. $this->formObject->getFormID().'_'.$this->formObject->getId().'" ).val( $( "#slider-range-'.$this->formObject->getFormID().'_'.$this->formObject->getId().'" ).slider( "value" ) );';
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
                    class="rangeSlider <?php echo $this->formObject->getClasses(); ?>" 
                    id="rangeSlider_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" 
                    type="text" 
             
                    <?php if( $this->formObject->getDefaultVal() != "" ){ ?>
                    value="<?php echo $this->formObject->getDefaultVal(); ?>"
                    <?php } ?>
                    
                    />
                    <div id="slider-range-<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>"></div>
          	</div>
			<?php
		}
	}
?>