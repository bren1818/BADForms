<?php
	class radiobutton  {
		
		private $formObject;
		
		/*Constructor*/
		function __construct($formObject=null){
			$this->formObject = $formObject;
		}
		
		function getJS(){
			return "";
		}	
		
		function render(){
			?>
				<div class="formRowLabel">
				<label for="radioButtonMultiple_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>">
					<span class="labelText"><?php echo $this->formObject->getLabel(); ?></span>
                </label>
                </div>
                <div class="formRowInput">
                    <?php
						$listType = $this->formObject->getListType();
						$items = array();
						if( $listType == 1 ){
							//csv
							$items = explode(",", $this->formObject->getCsList() );	
							$items = array_map('trim',$items);
						}else{
							//existing
								//-kv list
								//-std list
						}
						$preSelected = explode(",", $this->formObject->getDefaultVal() );
						$preSelected = array_map('trim',$preSelected); //trim the strings
					?>
                    <div id="radioButtonMultiple_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" class="radioButtonList">
                    <?php
						//need logic for key value
						for($cb = 0; $cb < sizeof($items); $cb++){ 
							$item = $items[$cb];
					?>
                    	<div class="radioButtonItem checkBoxItem-<?php echo ($cb+1); ?>">
                            <div class="radioButton">
                                <input type="radio"
                                name="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>"  
                                class="radioButtonItem <?php echo $this->formObject->getClasses(); ?>" 
                                id="radioButton_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>_<?php echo ($cb + 1); ?>"
                                value="<?php echo $item; ?>" 
                                <?php if( in_array( $item, $preSelected, false ) ){ echo "checked"; }?>
                                /> 
							 </div>
                             <div class="radioButtonValue">
                                <label for="radioButton_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>_<?php echo ($cb + 1); ?>"><?php echo trim($item); ?></label>
                             </div>
                        </div>    
                     <?php } ?>
                     </div>
				</div>
			<?php
		}
		
		
	}
?>