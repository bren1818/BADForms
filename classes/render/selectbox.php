<?php
	class selectbox   {
		
		private $formObject;
		
		/*Constructor*/
		function __construct($formObject=null){
			$this->formObject = $formObject;
		}	
		
		function render(){
			?>
				<label for="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>">
					<?php echo $this->formObject->getLabel(); ?>
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
						//$preSelected = explode(",", $this->formObject->getDefaultVal() );
						//$preSelected = array_map('trim',$preSelected); //trim the strings
						$preSelected = trim( $this->formObject->getDefaultVal() );
						// value="<?php echo $item;  
                        //    if( in_array( $item, $preSelected, false ) ){ echo "checked"; }
                        //    echo trim($item); <br />
						
						
						?>
                        <select
                            name="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>"  
                            class="<?php echo $this->formObject->getClasses(); ?>" 
                            id="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>"
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
				</label>
			<?php
		}
		
		
	}
?>