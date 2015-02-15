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
						
						
						
					?>
                    <div id="radioButtonMultiple_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>" class="radioButtonList">
                    <?php
						if( $listType == 1 ){
							//csv
							$items = explode(",", $this->formObject->getCsList() );	
							$items = array_map('trim',$items);
						
							$preSelected = explode(",", $this->formObject->getDefaultVal() );
							$preSelected = array_map('trim',$preSelected); //trim the strings
					
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
                     <?php } 
						}else if( $listType == 2){
							//echo "other list type";
							
							
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
								$cb = 0;
								while( $result = $query->fetchObject($object) ){
								?>
                                 <div class="radioButtonItem checkBoxItem-<?php echo ($cb+1); ?>">
                                    <div class="radioButton">
                                        <input type="radio"
                                        name="input_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>"  
                                        class="radioButtonItem <?php echo $this->formObject->getClasses(); ?>" 
                                        id="radioButton_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>_<?php echo ($cb + 1); ?>"
                                        value="<?php if( $listset->getListType() == 1){ echo trim($result->getItemKey()); }else if( $listset->getListType() == 0 ){ echo trim($result->getItem()); } ?>" 
                                        <?php 
                                        if($listset->getListType() == 1){
                                            if( trim($result->getItemKey()) == trim($default)  ){ echo "checked"; }
                                        }else if( $listset->getListType() == 0 ){
                                            if( trim($result->getItem()) == trim($default)  ){ echo "checked"; }
                                        }
                                         ?>
                                        /> 
                                     </div>
                                     <div class="radioButtonValue">
                                        <label for="radioButton_<?php echo $this->formObject->getFormID().'_'.$this->formObject->getId(); ?>_<?php echo ($cb + 1); ?>"><?php echo trim($result->getItem()); ?></label>
                                     </div>
                                </div>  
										
										<?php
									 
									 
									 $cb++;
								}
							}
							
							
							
							
							
							
							
							
						}else{
							echo ">Unknown List Type<";	
						}
						?>
                     </div>
				</div>
			<?php
		}
		
		
	}
?>