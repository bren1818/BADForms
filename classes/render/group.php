<?php
	class group{
		
		private $formObject;
		
		/*Constructor*/
		function __construct($formObject=null){
			$this->formObject = $formObject;
		}
		/*
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
		*/
		function getJS(){
			return "";
		}
						
		function hasReturnValue(){
			return 1;
		}

		function render(){
			
			//if( ($this->formObject->getReuseableType() == 1 || $this->formObject->getReuseableType() == 2 ) && $this->formObject->getType() == 14 ){	
					$ReUseID = $this->formObject->getReuseableID();
					
					//echo "Here: ".$ReUseID." type: ".$this->formObject->getReuseableType();
					
					if( $this->formObject->getReuseableType() == 1  && $ReUseID > 0){
						//Group
						//Hurray Recursion
						
						$conn = getConnection();
						
						$types = "Select `id`, `name` FROM `objecttype`";
						$types = $conn->query( $types );
						$listTypes = array();
						if( $types->execute() ){
							while( $result = $types->fetch(PDO::FETCH_ASSOC) ){
								$listTypes[ $result['id'] ] = $result['name'];
							}
						}
											
						
						//css
						//js
						
						$query = "SELECT * FROM `formobject` WHERE `formID` = :formID order by `rowOrder` ASC";
						$query = $conn->prepare( $query );
						$query->bindParam(':formID', $ReUseID);
						
						if( $query->execute() ){
							$rows = 0;
							while( $result = $query->fetchObject("formobject") ){
								//echo generateHtml( $result );
								
								$type = "".$listTypes[ $result->getType() ];
								
								if( $type != "no-type-select" ){
								
									if( class_exists( $type ) ){
										
										$rows++;
									
										$class = new $type($result);
									
										echo '<div id="form-item-id-'.$result->getId().'" class="formRow type-'.$type.' row-'.$rows.'">';
											$class->render();
										echo '</div>';
										
										//if( method_exists($class, "getJS") ){
											//$formJS = $formJS.$class->getJS();
										//}
										
									}else{
										echo '<div class="formRow">';
											echo "Error, Class: ".$type." does not exist";
										echo '</div>';	
									}
									
								}
								
							}
						}
						
						
						
						/*
						$ReUseformObject = new Theform( $db );
						$ReUseformObject = $ReUseformObject->load( $ReUseID );
						
						if( $ReUseformObject->getId() > 0 ){
							echo '<b>Chosen Group</b>: &ldquo;' . $ReUseformObject->getTitle() . '&rdquo;  <a class="clearPick" onClick="clearGroup(this);"><i class="fa fa-times"></i></a>';
						}
						*/
						
						
					}else{
						//item
						/*
						$ReUseformObject = new formobject( $db );
						$ReUseformObject = $ReUseformObject->load( $ReUseID );
						
						if( $ReUseformObject->getId() > 0 ){
							echo '<b>Chosen Group</b>: &ldquo;' . $ReUseformObject->getLabel() . '&rdquo;  <a class="clearPick" onClick="clearGroup(this);"><i class="fa fa-times"></i></a>';
						}
						*/
						
					}

				//}
			
			
			
			
			
			
			/*
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
			*/
		}
	}
?>