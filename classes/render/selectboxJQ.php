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
						
		function hasReturnValue(){
			return 1;
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
						if( $listType == 1 ){
							for($cb = 0; $cb < sizeof($items); $cb++){ 
								$item = $items[$cb];
							?>
                            <option value="<?php echo $item; ?>"<?php if($item == $preSelected){ echo " selected"; } ?>><?php echo $item; ?></option>
                     	<?php } 
						}else{
							$conn = getConnection();
							
							$listset = new Listset( $conn );
							$listset = $listset->load( $this->formObject->getListID() );
							
							$default = $listset->getDefaultValue();
							
							if( $listset->getListType() == 1){ //1 key-val list
								$query = $conn->prepare("SELECT * FROM `listitemkv` WHERE `listID` = :listID order by `rowOrder` ASC");
								$object = "listitemkv";
							}else{								//0 val list
								$query = $conn->prepare("SELECT * FROM `listitem` WHERE `listID` = :listID order by `rowOrder` ASC");
								$object = "listitem";
							}
								
							$query->bindParam(':listID', $listset->getId());			
							//echo '<option value=""> - </option>';
							if( $query->execute() ){
								while( $result = $query->fetchObject($object) ){
									 if( $listset->getListType() == 1){
										//key value
										echo '<option value="'.$result->getItemKey().'" '.(trim($default) == trim($result->getItemKey()) ? ' selected' : '').'>'.$result->getItem().'</option>';
									 }else {
										//value value
										echo '<option value="'.$result->getItem().'" '.(trim($default) == trim($result->getItem()) ? ' selected' : '').'>'.$result->getItem().'</option>';
									 }
								}
							}
													
						
						}
						?>
                     </select>
				</div>
			<?php
		}
	}
?>