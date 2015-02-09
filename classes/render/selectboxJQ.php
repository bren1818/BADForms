<?php
	class selectboxJQ   {
		
		private $formObject;
		
		/*Constructor*/
		function __construct($formObject=null){
			$this->formObject = $formObject;
		}	
		
		function getJS(){
			return "$('#selectBox_".$this->formObject->getFormID().'_'.$this->formObject->getId()."').selectmenu();";
		}
		
		function render(){
			?>
				<div class="formRowLabel">
				<label for="selectBox_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>">
					<span class="labelText"><?php echo $this->formObject->getLabel(); ?></span>
                </label>
                </div>
                <div class="formRowInput">
                    <?php
						$listType = $this->formObject->getListType();
						if( $listType == 1 ){
							//csv
							$items = explode(",", $this->formObject->getCsList() );	
							$items = array_map('trim',$items);
						}else{
							//existing
								//-kv list
								//-std list
						}
						
						$preSelected = trim( $this->formObject->getDefaultVal() );
						
						?>
                        <select
                            name="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>"  
                            class="selectBox <?php echo $this->formObject->getClasses(); ?>" 
                            id="selectBox_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>"
                            >
                            <option value="">-</option>
                        <?php
						//need logic for key value
						for($cb = 0; $cb < sizeof($items); $cb++){ 
							$item = $items[$cb];
						?>
                            <option value="<?php echo $item; ?>"<?php if($item == $preSelected){ echo " selected"; } ?>><?php echo $item; ?></option>
                     	<?php } ?>
                     </select>
				</div>
			<?php
		}
	}
?>