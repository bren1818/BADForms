<?php
	class hidden{
		
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
					<?php /* ?><label for="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>"><span class="labelText"><?php echo $this->formObject->getLabel(); ?></span></label><?php */ ?>
				</div>
                <div class="formRowInput">
                    <input 	
                    name="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" 
                    class="inputBox <?php echo $this->formObject->getClasses(); ?>" 
                    id="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" 
                    type="hidden" 
                    <?php if( $this->formObject->getDefaultVal() != "" ){ ?>
                    value="<?php echo $this->formObject->getDefaultVal(); ?>"
                    <?php } ?>
                    />
          	</div>
			<?php
		}
	}
?>